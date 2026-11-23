<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('a2a_nav_tr')) {
    // Menu titles come from the database in English. When Hindi is chosen,
    // translate the standard ones; anything else is shown as typed.
    function a2a_nav_tr($title)
    {
        if (!function_exists('a2a_lang_code') || a2a_lang_code() === 'en') { return $title; }
        static $map = array('home' => 'a2a_home', 'about us' => 'a2a_about', 'schemes' => 'a2a_schemes',
            'scheme list' => 'a2a_scheme_list', 'instructions' => 'a2a_instructions', 'cities brief' => 'a2a_cities',
            'universities' => 'a2a_universities', 'guidelines' => 'a2a_guidelines', 'faqs' => 'a2a_faqs',
            'contact us' => 'a2a_contact', 'alumni' => 'a2a_alumni', 'feedback' => 'a2a_feedback', 'help' => 'a2a_help');
        $k = strtolower(trim($title));
        return isset($map[$k]) ? a2a_t($map[$k]) : $title;
    }
}

/**
 * Header menu from the iccr_nav_links table (managed in /adminpanel/nav).
 *
 * a2a_nav_load($user) returns NULL when the table does not exist or has no
 * active rows. The header then falls back to its built-in menu, so the site
 * never loses its navigation.
 */

if (!function_exists('a2a_nav_load')) {
    function a2a_nav_load($user)
    {
        $CI =& get_instance();
        $logged_in = !empty($user);
        // Menu rows are cached for 5 minutes (cleared whenever the admin panel changes the menu)
        $CI->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
        $rows = $CI->cache->get('a2a_nav_rows');
        if (!is_array($rows)) {
            if (!$CI->db->table_exists('iccr_nav_links')) {
                return NULL;
            }
            $rows = $CI->db->where('is_active', 1)
                           ->order_by('sort_order', 'ASC')->order_by('id', 'ASC')
                           ->get('iccr_nav_links')->result_array();
            @$CI->cache->save('a2a_nav_rows', $rows, 300);
        }
        if (!$rows) {
            return NULL;
        }
        $by_parent = array();
        foreach ($rows as $r) {
            if ($r['visibility'] === 'guest' && $logged_in) { continue; }
            if ($r['visibility'] === 'user' && !$logged_in) { continue; }
            $by_parent[(int) $r['parent_id']][] = $r;
        }
        $build = function ($parent, $depth) use (&$build, $by_parent, $CI) {
            $out = array();
            if (empty($by_parent[$parent]) || $depth > 2) { return $out; }
            foreach ($by_parent[$parent] as $r) {
                $r['children'] = $build((int) $r['id'], $depth + 1);
                if ($r['page_group'] !== NULL && $r['page_group'] !== '') {
                    $pages = $CI->common_model->getFrontPage((int) $r['page_group']);
                    foreach ((array) $pages as $p) {
                        $r['children'][] = array('id' => 0, 'title' => $p['page_title'], 'subtitle' => '', 'icon' => 'fa-file-text-o',
                            'url' => 'home/page/' . $p['page_slug'], 'new_tab' => 0, 'children' => array());
                    }
                }
                $out[] = $r;
            }
            return $out;
        };
        $all = $build(0, 0);
        $tree = array('main' => array(), 'action' => array());
        foreach ($all as $r) {
            $tree[$r['position'] === 'action' ? 'action' : 'main'][] = $r;
        }
        return $tree;
    }
}

if (!function_exists('a2a_nav_url')) {
    function a2a_nav_url($url, $user)
    {
        $url = trim((string) $url);
        if ($url === '#') { return '#'; }
        if (preg_match('/^\s*(javascript|data|vbscript):/i', $url)) { return '#'; }
        if ($url === '{dashboard}') {
            $type = isset($user['user_type']) ? (int) $user['user_type'] : 0;
            $map = array(1 => 'applicant/dashboard', 2 => 'mission/dashboard', 3 => 'headquarter/dashboard', 4 => 'regional/dashboard', 5 => 'admin/dashboard', 8 => 'university/dashboard');
            return site_url(isset($map[$type]) ? $map[$type] : '');
        }
        if (preg_match('#^(https?:)?//#i', $url) || strpos($url, '/') === 0 || strpos($url, 'mailto:') === 0 || strpos($url, 'tel:') === 0) {
            return $url;
        }
        return site_url($url);
    }
}

if (!function_exists('a2a_nav_icon')) {
    function a2a_nav_icon($r)
    {
        if (!empty($r['icon'])) { return $r['icon']; }
        $u = strtolower((string) $r['url']);
        if (substr($u, -4) === '.pdf') { return 'fa-file-pdf-o'; }
        if (preg_match('/\.xlsx?$/', $u)) { return 'fa-file-excel-o'; }
        return 'fa-angle-right';
    }
}

/** Print the <li> items of the main menu (top level + dropdowns). */
if (!function_exists('a2a_nav_render_main')) {
    function a2a_nav_render_main($items, $user)
    {
        $current = rtrim(current_url(), '/');
        foreach ($items as $r) {
            $t = html_escape(a2a_nav_tr($r['title']));
            $nt = !empty($r['new_tab']) ? ' target="_blank" rel="noopener"' : '';
            if (!empty($r['children'])) {
                echo '<li class="dropdown navbar-item">';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $t . ' <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>';
                echo '<ul class="dropdown-menu">';
                if ($r['url'] !== '#' && $r['url'] !== '') {
                    echo '<li><a href="' . html_escape(a2a_nav_url($r['url'], $user)) . '"' . $nt . '><span class="a2a-ico"><i class="fa fa-arrow-right" aria-hidden="true"></i></span><span>' . $t . '</span></a></li>';
                }
                foreach ($r['children'] as $c) {
                    a2a_nav_render_child($c, $user, 0);
                }
                echo '</ul></li>';
            } else {
                $href = a2a_nav_url($r['url'], $user);
                $active = (rtrim($href, '/') === $current) ? ' class="active" aria-current="page"' : '';
                echo '<li><a href="' . html_escape($href) . '"' . $active . $nt . '>' . $t . '</a></li>';
            }
        }
    }
}

if (!function_exists('a2a_nav_render_child')) {
    function a2a_nav_render_child($c, $user, $level)
    {
        $nt = !empty($c['new_tab']) ? ' target="_blank" rel="noopener"' : '';
        $sub = !empty($c['subtitle']) ? '<span class="a2a-meta">' . html_escape($c['subtitle']) . '</span>' : '';
        $pad = $level ? ' style="padding-left:' . (12 + 22 * $level) . 'px !important"' : '';
        $href = $c['url'] === '#' ? '#' : a2a_nav_url($c['url'], $user);
        echo '<li><a href="' . html_escape($href) . '"' . $nt . $pad . '><span class="a2a-ico"><i class="fa ' . html_escape(a2a_nav_icon($c)) . '" aria-hidden="true"></i></span><span>' . html_escape($c['title']) . $sub . '</span></a></li>';
        if (!empty($c['children'])) {
            foreach ($c['children'] as $g) {
                a2a_nav_render_child($g, $user, $level + 1);
            }
        }
    }
}

/** Print the right-hand buttons (position = action). */
if (!function_exists('a2a_nav_render_actions')) {
    function a2a_nav_render_actions($items, $user)
    {
        foreach ($items as $r) {
            $nt = !empty($r['new_tab']) ? ' target="_blank" rel="noopener"' : '';
            $icon = !empty($r['icon']) ? '<i class="fa ' . html_escape($r['icon']) . '" aria-hidden="true"></i> ' : '';
            echo '<li><a class="a2a-btn a2a-btn--ghost" href="' . html_escape(a2a_nav_url($r['url'], $user)) . '"' . $nt . '>' . $icon . html_escape(a2a_nav_tr($r['title'])) . '</a></li>';
        }
    }
}
