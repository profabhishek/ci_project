/* ---------------------------------------------------------------------------
 * Searchable dropdown for long <select> lists (the Nomenclature lists).
 *
 * Usage: add  data-searchable="true"  to a <select> and include this file
 * (plus css/iccr-searchable-select.css). Selects added or rewritten later are
 * handled automatically.
 *
 * Design rule: the original <select> is never replaced. It stays in the form,
 * visually hidden, and remains the single source of truth:
 *   - it is what gets submitted, and "required" still blocks an empty submit;
 *   - scripts that rewrite its options (e.g. $('.nomenclature').html(...)) are
 *     picked up by a MutationObserver;
 *   - value changes made by scripts, form reset, disable/enable are picked up
 *     by a light sync check;
 *   - picking an item sets select.value and fires real "change" and "input"
 *     events, so existing jQuery handlers ($(...).change, $(document).on)
 *     run exactly as they did with the plain dropdown.
 *
 * Written in ES5 on purpose so it also runs on older browsers.
 * ------------------------------------------------------------------------- */
(function (window, document) {
    'use strict';

    if (window.IccrSearchSelect) {
        return; // already loaded on this page
    }

    var MAX_RENDER = 400; // cap rows drawn per keystroke; typing narrows further
    var uid = 0;
    var instances = [];

    var ICON_SEARCH = '<svg width="15" height="15" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="#6b7686" stroke-width="2.2"/><path d="M15.5 15.5L21 21" stroke="#6b7686" stroke-width="2.2" stroke-linecap="round"/></svg>';
    var ICON_CHEVRON = '<svg class="iccr-ss-chevron" width="12" height="8" viewBox="0 0 12 8" aria-hidden="true" focusable="false"><path d="M1 1.5l5 5 5-5" fill="none" stroke="#6b7686" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    // Lower-case, strip accents and punctuation, collapse spaces, so that
    // "phd yoga" finds "Ph.D Yoga" and "m.d." finds "MD (Ayurveda)".
    var canNormalize = typeof ''.normalize === 'function';
    function fold(text) {
        var s = String(text == null ? '' : text).toLowerCase();
        if (canNormalize) {
            s = s.normalize('NFD').replace(/[̀-ͯ]/g, '');
        }
        return s.replace(/[^a-z0-9ऀ-ॿ]+/g, ' ').replace(/\s+/g, ' ').trim();
    }
    function squash(text) {
        return fold(text).replace(/ /g, '');
    }

    function escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // Every search word must appear (any order). Words are also matched with
    // punctuation removed, so "phd" matches "Ph.D".
    function matches(item, words) {
        for (var i = 0; i < words.length; i++) {
            if (item.folded.indexOf(words[i]) === -1 && item.squashed.indexOf(words[i]) === -1) {
                return false;
            }
        }
        return true;
    }

    // Highlight the typed text when it appears literally in the label.
    function highlight(label, rawQuery) {
        var q = String(rawQuery).trim();
        if (q === '') {
            return escapeHtml(label);
        }
        var at = label.toLowerCase().indexOf(q.toLowerCase());
        if (at === -1) {
            return escapeHtml(label);
        }
        return escapeHtml(label.slice(0, at)) +
            '<mark>' + escapeHtml(label.slice(at, at + q.length)) + '</mark>' +
            escapeHtml(label.slice(at + q.length));
    }

    // Small helpers for browsers without Element.closest / classList.toggle(force)
    // / modern key names (old IE and Edge report "Down", "Esc", "Spacebar").
    function closestOption(el, root) {
        while (el && el !== root) {
            if (el.classList && el.classList.contains('iccr-ss-option')) { return el; }
            el = el.parentNode;
        }
        return null;
    }
    function setClass(el, name, on) {
        if (on) { el.classList.add(name); } else { el.classList.remove(name); }
    }
    var KEY_ALIASES = { Down: 'ArrowDown', Up: 'ArrowUp', Esc: 'Escape', Spacebar: ' ' };
    function keyOf(e) {
        var k = e.key || '';
        return KEY_ALIASES[k] || k;
    }

    function fireEvent(el, name) {
        var ev;
        if (typeof window.Event === 'function') {
            ev = new window.Event(name, { bubbles: true });
        } else {
            ev = document.createEvent('HTMLEvents');
            ev.initEvent(name, true, false);
        }
        el.dispatchEvent(ev);
    }

    function SearchSelect(select) {
        this.select = select;
        this.id = 'iccr-ss-' + (++uid);
        this.items = [];
        this.visible = [];
        this.activeIndex = -1;
        this.isOpen = false;
        this.lastValue = null;
        this.lastDisabled = null;
        this.build();
        this.readOptions();
        this.syncLabel();
        this.watch();
    }

    SearchSelect.prototype.build = function () {
        var self = this;
        var select = this.select;

        var wrap = document.createElement('div');
        wrap.className = 'iccr-ss';
        wrap.innerHTML =
            '<button type="button" class="iccr-ss-toggle" aria-haspopup="listbox" aria-expanded="false" aria-controls="' + this.id + '-list"></button>' +
            '<span class="iccr-ss-icons">' + ICON_SEARCH + ICON_CHEVRON + '</span>' +
            '<div class="iccr-ss-panel" hidden>' +
                '<div class="iccr-ss-searchbox">' + ICON_SEARCH +
                    '<input type="text" class="iccr-ss-search" autocomplete="off" spellcheck="false" ' +
                        'placeholder="Type to search..." aria-label="Search" aria-controls="' + this.id + '-list">' +
                    '<button type="button" class="iccr-ss-clear" aria-label="Clear search" hidden>&times;</button>' +
                '</div>' +
                '<div class="iccr-ss-count" aria-live="polite"></div>' +
                '<ul class="iccr-ss-list" id="' + this.id + '-list" role="listbox"></ul>' +
            '</div>';

        select.parentNode.insertBefore(wrap, select.nextSibling);
        select.classList.add('iccr-ss-native');
        select.setAttribute('tabindex', '-1');
        select.setAttribute('aria-hidden', 'true');

        this.wrap = wrap;
        this.toggle = wrap.querySelector('.iccr-ss-toggle');
        this.panel = wrap.querySelector('.iccr-ss-panel');
        this.search = wrap.querySelector('.iccr-ss-search');
        this.clearBtn = wrap.querySelector('.iccr-ss-clear');
        this.count = wrap.querySelector('.iccr-ss-count');
        this.list = wrap.querySelector('.iccr-ss-list');

        // Label the control like the original field, for screen readers.
        if (select.id) {
            var label = document.querySelector('label[for="' + select.id + '"]');
            if (label) {
                this.toggle.setAttribute('aria-label', label.textContent.replace(/\*/g, '').trim());
            }
        }

        this.toggle.addEventListener('click', function () {
            if (self.isOpen) { self.close(true); } else { self.open(''); }
        });

        // Start typing on the closed control = open and search straight away.
        this.toggle.addEventListener('keydown', function (e) {
            if (self.select.disabled) { return; }
            var key = keyOf(e);
            if (key === 'ArrowDown' || key === 'ArrowUp' || key === 'Enter' || key === ' ') {
                e.preventDefault();
                self.open('');
            } else if (key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                e.preventDefault();
                self.open(key);
            }
        });

        var timer = null;
        this.search.addEventListener('input', function () {
            self.clearBtn.hidden = self.search.value === '';
            clearTimeout(timer);
            timer = setTimeout(function () { self.render(); }, 60);
        });

        this.search.addEventListener('keydown', function (e) {
            var key = keyOf(e);
            if (key === 'ArrowDown') {
                e.preventDefault();
                self.move(1);
            } else if (key === 'ArrowUp') {
                e.preventDefault();
                self.move(-1);
            } else if (key === 'PageDown') {
                e.preventDefault();
                self.move(8);
            } else if (key === 'PageUp') {
                e.preventDefault();
                self.move(-8);
            } else if (key === 'Enter') {
                // Never let Enter submit the surrounding form from the search box.
                e.preventDefault();
                if (self.activeIndex > -1) {
                    self.choose(self.visible[self.activeIndex]);
                }
            } else if (key === 'Escape') {
                e.preventDefault();
                self.close(true);
            } else if (key === 'Tab') {
                self.close(false);
            }
        });

        this.clearBtn.addEventListener('click', function () {
            self.search.value = '';
            self.clearBtn.hidden = true;
            self.render();
            self.search.focus();
        });

        // mousedown (not click) so the search box keeps focus while picking.
        this.list.addEventListener('mousedown', function (e) {
            var li = closestOption(e.target, self.list);
            if (!li) { return; }
            e.preventDefault();
            var idx = parseInt(li.getAttribute('data-index'), 10);
            if (!isNaN(idx) && self.visible[idx]) {
                self.choose(self.visible[idx]);
            }
        });

        this.list.addEventListener('mousemove', function (e) {
            var li = closestOption(e.target, self.list);
            if (!li) { return; }
            var idx = parseInt(li.getAttribute('data-index'), 10);
            if (!isNaN(idx) && idx !== self.activeIndex) {
                self.setActive(idx, false);
            }
        });

        // Browser validation ("required") fires on the hidden select - show it
        // on the visible control instead and bring it into view.
        select.addEventListener('invalid', function () {
            self.wrap.classList.add('is-invalid');
            try { self.wrap.scrollIntoView({ block: 'center' }); } catch (err) { /* old browsers */ }
            self.toggle.focus();
        });

        select.addEventListener('change', function () {
            self.syncLabel();
        });
    };

    // Read the <option>s (and <optgroup>s) into a searchable list.
    SearchSelect.prototype.readOptions = function () {
        var items = [];
        var opts = this.select.options;
        for (var i = 0; i < opts.length; i++) {
            var o = opts[i];
            var text = (o.text || '').replace(/\s+/g, ' ').trim();
            var group = o.parentNode && o.parentNode.tagName === 'OPTGROUP' ? (o.parentNode.label || '') : '';
            items.push({
                index: i,
                value: o.value,
                text: text,
                group: group,
                disabled: o.disabled || (o.parentNode && o.parentNode.disabled),
                // The empty "Select ..." entry is shown as the placeholder, not
                // as a result - except when it is the only thing to show.
                placeholder: o.value === '',
                folded: fold(text + ' ' + group),
                squashed: squash(text + ' ' + group)
            });
        }
        this.items = items;
        if (this.isOpen) {
            this.render();
        }
    };

    SearchSelect.prototype.selectedItem = function () {
        var i = this.select.selectedIndex;
        return i > -1 && this.items[i] ? this.items[i] : null;
    };

    SearchSelect.prototype.syncLabel = function () {
        var item = this.selectedItem();
        var text;
        var placeholder = !item || item.placeholder;
        if (item && item.text) {
            text = item.text;
        } else {
            var first = this.items.length && this.items[0].placeholder ? this.items[0].text : '';
            text = first || 'Select';
        }
        this.toggle.textContent = text;
        this.toggle.setAttribute('title', placeholder ? '' : text);
        setClass(this.toggle, 'is-placeholder', placeholder);
        this.lastValue = this.select.value;

        if (!placeholder) {
            this.wrap.classList.remove('is-invalid');
        }

        var disabled = !!this.select.disabled;
        if (disabled !== this.lastDisabled) {
            this.lastDisabled = disabled;
            this.toggle.disabled = disabled;
            setClass(this.wrap, 'is-disabled', disabled);
            if (disabled && this.isOpen) {
                this.close(false);
            }
        }
    };

    SearchSelect.prototype.watch = function () {
        var self = this;
        // Options replaced or edited by other scripts.
        if (window.MutationObserver) {
            this.observer = new window.MutationObserver(function () {
                self.readOptions();
                self.syncLabel();
            });
            this.observer.observe(this.select, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: ['disabled', 'label'] });
        }
    };

    // Cheap check for changes no event announces: $('#x').val('5'), form
    // reset, .prop('disabled', true), or the select being removed.
    SearchSelect.prototype.poll = function () {
        if (!document.documentElement.contains(this.select)) {
            this.destroy();
            return false;
        }
        if (this.select.value !== this.lastValue || !!this.select.disabled !== this.lastDisabled) {
            this.syncLabel();
        }
        return true;
    };

    SearchSelect.prototype.open = function (initialQuery) {
        if (this.select.disabled || this.isOpen) {
            return;
        }
        closeAll(this);
        this.isOpen = true;
        this.wrap.classList.add('is-open');
        this.toggle.setAttribute('aria-expanded', 'true');
        this.panel.hidden = false;

        // Open upwards when there is not enough room below.
        this.wrap.classList.remove('opens-up');
        var rect = this.toggle.getBoundingClientRect();
        var below = (window.innerHeight || document.documentElement.clientHeight) - rect.bottom;
        if (below < 360 && rect.top > below) {
            this.wrap.classList.add('opens-up');
        }

        this.search.value = initialQuery || '';
        this.clearBtn.hidden = this.search.value === '';
        this.render();
        this.search.focus();
        try {
            var end = this.search.value.length;
            this.search.setSelectionRange(end, end);
        } catch (err) { /* ignore */ }
    };

    SearchSelect.prototype.close = function (returnFocus) {
        if (!this.isOpen) {
            return;
        }
        this.isOpen = false;
        this.wrap.classList.remove('is-open');
        this.toggle.setAttribute('aria-expanded', 'false');
        this.panel.hidden = true;
        this.list.innerHTML = '';
        this.visible = [];
        this.activeIndex = -1;
        if (returnFocus) {
            this.toggle.focus();
        }
    };

    SearchSelect.prototype.render = function () {
        var raw = this.search.value;
        var query = fold(raw);
        var words = query === '' ? [] : query.split(' ');
        var selected = this.selectedItem();

        var results = [];
        var total = 0;
        for (var i = 0; i < this.items.length; i++) {
            var it = this.items[i];
            if (it.placeholder) { continue; }
            total++;
            if (words.length === 0 || matches(it, words)) {
                results.push(it);
            }
        }

        var shown = results.length > MAX_RENDER ? results.slice(0, MAX_RENDER) : results;
        this.visible = shown;

        var html = [];
        var lastGroup = null;
        var activeIndex = -1;
        for (var j = 0; j < shown.length; j++) {
            var item = shown[j];
            if (item.group && item.group !== lastGroup) {
                html.push('<li class="iccr-ss-group" role="presentation">' + escapeHtml(item.group) + '</li>');
            }
            lastGroup = item.group;
            var cls = 'iccr-ss-option';
            var isSel = selected && item.index === selected.index;
            if (isSel) { cls += ' is-selected'; }
            if (item.disabled) { cls += ' is-disabled'; }
            if (isSel && activeIndex === -1) { activeIndex = j; }
            html.push('<li class="' + cls + '" role="option" id="' + this.id + '-opt-' + j + '" data-index="' + j + '" aria-selected="' + (isSel ? 'true' : 'false') + '"' +
                (item.disabled ? ' aria-disabled="true"' : '') + '>' + highlight(item.text, raw) + '</li>');
        }
        if (shown.length === 0) {
            html.push('<li class="iccr-ss-empty" role="presentation">No match for &ldquo;' + escapeHtml(raw.trim()) + '&rdquo;. Try fewer or different words.</li>');
        }
        this.list.innerHTML = html.join('');

        if (words.length === 0) {
            this.count.textContent = total + ' options - type to search';
        } else if (results.length > shown.length) {
            this.count.textContent = results.length + ' matches - showing first ' + shown.length + ', keep typing to narrow down';
        } else {
            this.count.textContent = results.length + (results.length === 1 ? ' match' : ' matches');
        }

        // Highlight the current value, otherwise the first match when searching.
        if (activeIndex === -1 && words.length > 0 && shown.length > 0) {
            activeIndex = 0;
        }
        this.setActive(activeIndex, true);
    };

    SearchSelect.prototype.setActive = function (idx, scroll) {
        var prev = this.list.querySelector('.iccr-ss-option.is-active');
        if (prev) { prev.classList.remove('is-active'); }
        this.activeIndex = idx;
        if (idx < 0) {
            this.search.removeAttribute('aria-activedescendant');
            return;
        }
        var li = this.list.querySelector('[data-index="' + idx + '"]');
        if (!li) { return; }
        li.classList.add('is-active');
        this.search.setAttribute('aria-activedescendant', li.id);
        if (scroll) {
            var top = li.offsetTop;
            var bottom = top + li.offsetHeight;
            if (top < this.list.scrollTop) {
                this.list.scrollTop = top - 4;
            } else if (bottom > this.list.scrollTop + this.list.clientHeight) {
                this.list.scrollTop = bottom - this.list.clientHeight + 4;
            }
        }
    };

    SearchSelect.prototype.move = function (step) {
        if (!this.visible.length) { return; }
        var idx = this.activeIndex;
        var n = this.visible.length;
        var tries = 0;
        do {
            idx = idx < 0 ? (step > 0 ? 0 : n - 1) : Math.max(0, Math.min(n - 1, idx + step));
            tries++;
            if (!this.visible[idx].disabled) { break; }
            if ((idx === 0 && step < 0) || (idx === n - 1 && step > 0)) { break; }
        } while (tries < n);
        this.setActive(idx, true);
    };

    SearchSelect.prototype.choose = function (item) {
        if (!item || item.disabled) {
            return;
        }
        var changed = this.select.selectedIndex !== item.index;
        this.select.selectedIndex = item.index;
        this.syncLabel();
        this.close(true);
        if (changed) {
            fireEvent(this.select, 'input');
            fireEvent(this.select, 'change');
        }
    };

    SearchSelect.prototype.destroy = function () {
        if (this.observer) { this.observer.disconnect(); }
        if (this.wrap && this.wrap.parentNode) { this.wrap.parentNode.removeChild(this.wrap); }
        this.select.classList.remove('iccr-ss-native');
        this.select.removeAttribute('aria-hidden');
        this.select.removeAttribute('tabindex');
        delete this.select.iccrSearchSelect;
        var at = instances.indexOf(this);
        if (at > -1) { instances.splice(at, 1); }
    };

    function closeAll(except) {
        for (var i = 0; i < instances.length; i++) {
            if (instances[i] !== except) {
                instances[i].close(false);
            }
        }
    }

    function enhance(select) {
        if (!select || select.tagName !== 'SELECT' || select.multiple || select.iccrSearchSelect) {
            return select && select.iccrSearchSelect ? select.iccrSearchSelect : null;
        }
        var inst = new SearchSelect(select);
        select.iccrSearchSelect = inst;
        instances.push(inst);
        return inst;
    }

    function enhanceAll(root) {
        var list = (root || document).querySelectorAll('select[data-searchable="true"]');
        for (var i = 0; i < list.length; i++) {
            enhance(list[i]);
        }
    }

    // Close when clicking anywhere else.
    document.addEventListener('mousedown', function (e) {
        for (var i = 0; i < instances.length; i++) {
            if (instances[i].isOpen && !instances[i].wrap.contains(e.target)) {
                instances[i].close(false);
            }
        }
    });

    // Keep labels in step with changes no event reports; also enhance any
    // searchable select added to the page later.
    setInterval(function () {
        for (var i = instances.length - 1; i >= 0; i--) {
            instances[i].poll();
        }
        enhanceAll(document);
    }, 400);

    window.IccrSearchSelect = { enhance: enhance, enhanceAll: enhanceAll };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { enhanceAll(document); });
    } else {
        enhanceAll(document);
    }
})(window, document);
