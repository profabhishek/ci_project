<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * One list of public pages, used by both the HTML sitemap (/seo/sitemap)
 * and the XML sitemap for search engines (/sitemap.xml).
 * Add a public page here and it appears in both.
 */
if (!function_exists('a2a_sitemap_groups')) {
    function a2a_sitemap_groups()
    {
        $CI =& get_instance();
        $docs = 'assets/site/docs/';
        $pages = function ($group) use ($CI) {
            $out = array();
            $rows = $CI->common_model->getFrontPage($group);
            if (!empty($rows)) { foreach ($rows as $p) { $out[] = array($p['page_title'], 'home/page/' . $p['page_slug']); } }
            return $out;
        };
        $cities = array('ahemdabad' => 'Ahmedabad', 'aligarh' => 'Aligarh', 'banglore' => 'Bengaluru', 'bhopal' => 'Bhopal',
            'bhuvneshwar' => 'Bhubaneswar', 'chandigarh' => 'Chandigarh', 'chennai' => 'Chennai', 'gauhati' => 'Guwahati',
            'goa' => 'Goa', 'hisar' => 'Hisar', 'hydrabad' => 'Hyderabad', 'jaipur' => 'Jaipur', 'jammu' => 'Jammu',
            'kolkata' => 'Kolkata', 'lucknow' => 'Lucknow', 'mumbai' => 'Mumbai', 'patna' => 'Patna', 'pune' => 'Pune',
            'varansi' => 'Varanasi');
        $cityLinks = array(array('Cities Brief (all cities)', 'home/cities'));
        foreach ($cities as $slug => $name) { $cityLinks[] = array($name, 'home/getCity/' . $slug); }

        return array(
            'Main pages' => array_merge(array(
                array('Home', ''),
                array('Contact Us', 'home/contactus'),
                array('Feedback', 'home/feedback'),
                array('Help', 'home/help'),
                array('FAQs', 'home/faqs'),
                array('Testimonials', 'home/testimonials'),
            )),
            'About ICCR' => $pages(1),
            'Instructions' => $pages(3),
            'Frequently asked questions' => $pages(4),
            'Schemes and institutions' => array(
                array('Scholarship Scheme List', 'home/getAllSchemeList'),
                array('National Institutes of Technology (NIT)', 'home/nitList'),
                array('National Institute of Fashion Technology (NIFT)', 'home/niftList'),
                array('ICAR empanelled universities', 'home/icarList'),
                array('AYUSH institutions', 'home/ayushList'),
                array('Gurus (performing arts)', 'home/guruList'),
                array('Applicant guidelines', 'home/applicant_guidlines'),
            ),
            'Cities in India' => $cityLinks,
            'Documents (PDF and Excel)' => array(
                array('Scholarship Guidelines (PDF)', $docs . 'Policy_Guidelines.pdf'),
                array('Timeline 2026-27 (PDF)', $docs . 'Timeline-AY-2026-27.pdf'),
                array('Physical Fitness Format (PDF)', $docs . 'Fitness.pdf'),
                array('Financial Terms (PDF)', $docs . 'Financial_Terms.pdf'),
                array('Universities (PDF)', $docs . 'universities.pdf'),
                array('Universities Details (Excel)', $docs . 'Universities_Details.xlsx'),
            ),
            'Account' => array(
                array('Sign in', '#myLogin'),
                array('Create an account', 'home/register'),
                array('Forgot password', 'home/forgotPassword'),
            ),
            'Policies' => array_merge($pages(0), array(
                array('Privacy Policy', 'home/privacy'),
                array('Terms and Conditions', 'home/termsandconditions'),
                array('Disclaimer', 'home/disclaimer'),
                array('Copyright Policy', 'home/copyright'),
                array('Hyperlink Policy', 'home/hyperlink'),
            )),
        );
    }
}
