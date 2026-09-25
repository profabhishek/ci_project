/* ---------------------------------------------------------------------------
 * Searchable dropdown for long <select> lists (the Nomenclature lists).
 *
 * Usage: add  data-searchable="true"  to a <select> and include this file
 * (plus css/iccr-searchable-select.css). Selects added or rewritten later are
 * handled automatically. Optional: data-search-placeholder="Search ..." sets
 * the text shown in the empty search field.
 *
 * The visible control is a search field (magnifier on the left): the user
 * clicks it and types, and the matching options are listed underneath.
 *
 * Design rule: the original <select> is never replaced. It stays in the form,
 * visually hidden, and remains the single source of truth:
 *   - it is what gets submitted, and "required" still blocks an empty submit;
 *     the search field has no name, so it is never submitted itself;
 *   - scripts that rewrite its options (e.g. $('.nomenclature').html(...)) are
 *     picked up by a MutationObserver;
 *   - value changes made by scripts, form reset, disable/enable are picked up
 *     by a light sync check;
 *   - picking an item sets select.value and fires real "change" and "input"
 *     events, so existing jQuery handlers ($(...).change, $(document).on)
 *     run exactly as they did with the plain dropdown.
 *
 * Written in ES5 and pure ASCII on purpose, so it runs on older browsers and
 * cannot be broken by a server or upload tool that changes the file encoding.
 * ------------------------------------------------------------------------- */
(function (window, document) {
    'use strict';

    if (window.IccrSearchSelect) {
        return; // already loaded on this page
    }

    var MAX_RENDER = 400; // cap rows drawn per keystroke; typing narrows further
    var uid = 0;
    var instances = [];

    var ICON_SEARCH = '<svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="#4d5b6c" stroke-width="2.4"/><path d="M15.5 15.5L21 21" stroke="#4d5b6c" stroke-width="2.4" stroke-linecap="round"/></svg>';
    var ICON_CHEVRON = '<svg class="iccr-ss-chevron" width="12" height="8" viewBox="0 0 12 8" aria-hidden="true" focusable="false"><path d="M1 1.5l5 5 5-5" fill="none" stroke="#6b7686" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    // Lower-case, strip accents and punctuation, collapse spaces, so that
    // "phd yoga" finds "Ph.D Yoga" and "m.d." finds "MD (Ayurveda)".
    // (\u0300-\u036f = combining accents, \u0900-\u097f = Devanagari.)
    var canNormalize = typeof ''.normalize === 'function';
    function fold(text) {
        var s = String(text == null ? '' : text).toLowerCase();
        if (canNormalize) {
            s = s.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }
        return s.replace(/[^a-z0-9\u0900-\u097f]+/g, ' ').replace(/\s+/g, ' ').trim();
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

    // Order results by closeness, keeping the list order within each rank:
    // 0 exact name, 1 name starts with the search, 2 every word matches a
    // whole word or the start of one, 3 anything else that matched.
    function rank(item, query, words) {
        if (item.folded === query || item.squashed === query.replace(/ /g, '')) { return 0; }
        if (item.folded.indexOf(query) === 0) { return 1; }
        var padded = ' ' + item.folded + ' ';
        for (var i = 0; i < words.length; i++) {
            if (padded.indexOf(' ' + words[i]) === -1) { return 3; }
        }
        return 2;
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

    // Text of the field's label: <label for="id">, else the first <label> in
    // the surrounding form row (these pages mostly use label for="inputEmail3").
    function fieldLabel(select) {
        var label = null;
        if (select.id) {
            label = document.querySelector('label[for="' + select.id + '"]');
        }
        var node = select.parentNode;
        for (var depth = 0; !label && node && depth < 3; depth++) {
            if (node.querySelector) {
                var found = node.querySelector('label');
                if (found && !found.contains(select)) { label = found; }
            }
            node = node.parentNode;
        }
        return label ? label.textContent.replace(/[*:]/g, '').replace(/\s+/g, ' ').trim() : '';
    }

    function SearchSelect(select) {
        this.select = select;
        this.id = 'iccr-ss-' + (++uid);
        this.items = [];
        this.visible = [];
        this.activeIndex = -1;
        this.isOpen = false;
        this.typed = false; // true once the user has typed since opening
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

        var labelText = fieldLabel(select);
        this.emptyPlaceholder = select.getAttribute('data-search-placeholder') ||
            (labelText && labelText.length <= 40 ? 'Search ' + labelText + ' - type here...' : 'Type here to search...');

        var wrap = document.createElement('div');
        wrap.className = 'iccr-ss';
        wrap.innerHTML =
            '<span class="iccr-ss-lead">' + ICON_SEARCH + '</span>' +
            '<input type="text" class="iccr-ss-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" ' +
                'role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="' + this.id + '-list">' +
            '<button type="button" class="iccr-ss-clear" tabindex="-1" aria-label="Clear search" hidden>&times;</button>' +
            '<button type="button" class="iccr-ss-arrow" tabindex="-1" aria-label="Show all options">' + ICON_CHEVRON + '</button>' +
            '<div class="iccr-ss-panel" hidden>' +
                '<div class="iccr-ss-count" aria-live="polite"></div>' +
                '<ul class="iccr-ss-list" id="' + this.id + '-list" role="listbox"></ul>' +
            '</div>';

        select.parentNode.insertBefore(wrap, select.nextSibling);
        select.classList.add('iccr-ss-native');
        select.setAttribute('tabindex', '-1');
        select.setAttribute('aria-hidden', 'true');

        this.wrap = wrap;
        this.input = wrap.querySelector('.iccr-ss-input');
        this.clearBtn = wrap.querySelector('.iccr-ss-clear');
        this.arrow = wrap.querySelector('.iccr-ss-arrow');
        this.panel = wrap.querySelector('.iccr-ss-panel');
        this.count = wrap.querySelector('.iccr-ss-count');
        this.list = wrap.querySelector('.iccr-ss-list');

        if (labelText) {
            this.input.setAttribute('aria-label', labelText);
        }

        // Clicking the field opens the full list; typing filters it. (click,
        // not mousedown, so the text selection made on open is not undone by
        // the mouse button being released.)
        this.input.addEventListener('click', function () {
            if (!self.isOpen) {
                self.open();
            }
        });

        // Tabbing into the field selects its text, so typing replaces it.
        this.input.addEventListener('focus', function () {
            if (!self.isOpen) {
                try { self.input.select(); } catch (err) { /* ignore */ }
            }
        });

        // Results are redrawn shortly after typing stops; flush() draws them
        // at once, so a quick Enter / arrow key acts on the up-to-date list.
        var timer = null;
        function flush() {
            if (timer !== null) {
                clearTimeout(timer);
                timer = null;
                if (self.isOpen) { self.render(); }
            }
        }
        this.input.addEventListener('input', function () {
            self.typed = true;
            if (!self.isOpen) {
                self.open();
            }
            self.clearBtn.hidden = self.input.value === '';
            clearTimeout(timer);
            timer = setTimeout(function () { timer = null; self.render(); }, 60);
        });

        this.input.addEventListener('keydown', function (e) {
            var key = keyOf(e);
            flush();
            if (key === 'Enter') {
                // The field is a text box inside the form: never let Enter
                // submit the form from here.
                e.preventDefault();
                if (self.isOpen && self.activeIndex > -1) {
                    self.choose(self.visible[self.activeIndex]);
                } else if (!self.isOpen) {
                    self.open();
                }
                return;
            }
            if (key === 'ArrowDown' || key === 'ArrowUp' || key === 'PageDown' || key === 'PageUp') {
                e.preventDefault();
                if (!self.isOpen) {
                    self.open();
                    return;
                }
                self.move(key === 'ArrowDown' ? 1 : key === 'ArrowUp' ? -1 : key === 'PageDown' ? 8 : -8);
            } else if (key === 'Escape') {
                if (self.isOpen) {
                    e.preventDefault();
                    self.close(true);
                }
            } else if (key === 'Tab') {
                self.close(false);
            }
        });

        this.clearBtn.addEventListener('mousedown', function (e) { e.preventDefault(); });
        this.clearBtn.addEventListener('click', function () {
            self.input.value = '';
            self.typed = true;
            self.clearBtn.hidden = true;
            if (!self.isOpen) { self.open(); }
            self.render();
            self.input.focus();
        });

        this.arrow.addEventListener('mousedown', function (e) { e.preventDefault(); });
        this.arrow.addEventListener('click', function () {
            if (self.select.disabled) { return; }
            if (self.isOpen) {
                self.close(true);
            } else {
                self.input.focus();
                self.open();
            }
        });

        // mousedown (not click) so the field keeps focus while picking.
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
        // on the visible field instead and bring it into view.
        select.addEventListener('invalid', function () {
            self.wrap.classList.add('is-invalid');
            try { self.wrap.scrollIntoView({ block: 'center' }); } catch (err) { /* old browsers */ }
            self.input.focus();
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
                // The empty "Select ..." entry is not listed as a result; the
                // empty search field plays its part.
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

    // Show the select's current value in the field (only while closed, so
    // what the user is typing is never overwritten).
    SearchSelect.prototype.syncLabel = function () {
        var item = this.selectedItem();
        var hasValue = !!(item && !item.placeholder && item.text);
        this.lastValue = this.select.value;

        if (!this.isOpen) {
            this.input.value = hasValue ? item.text : '';
            this.input.setAttribute('placeholder', this.emptyPlaceholder);
            this.clearBtn.hidden = true;
        }
        this.input.setAttribute('title', hasValue ? item.text : '');
        setClass(this.wrap, 'has-value', hasValue);

        if (hasValue) {
            this.wrap.classList.remove('is-invalid');
        }

        var disabled = !!this.select.disabled;
        if (disabled !== this.lastDisabled) {
            this.lastDisabled = disabled;
            this.input.disabled = disabled;
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

    SearchSelect.prototype.open = function () {
        if (this.select.disabled || this.isOpen) {
            return;
        }
        closeAll(this);
        this.isOpen = true;
        this.wrap.classList.add('is-open');
        this.input.setAttribute('aria-expanded', 'true');
        this.panel.hidden = false;

        // Open upwards when there is not enough room below.
        this.wrap.classList.remove('opens-up');
        var rect = this.input.getBoundingClientRect();
        var below = (window.innerHeight || document.documentElement.clientHeight) - rect.bottom;
        if (below < 360 && rect.top > below) {
            this.wrap.classList.add('opens-up');
        }

        if (!this.typed) {
            // Opened by click / arrow key: list everything and select the
            // current text, so the first key typed starts a fresh search.
            var item = this.selectedItem();
            if (item && !item.placeholder) {
                this.input.setAttribute('placeholder', item.text);
            }
            try { this.input.select(); } catch (err) { /* ignore */ }
        }
        this.clearBtn.hidden = !this.typed || this.input.value === '';
        this.render();
    };

    SearchSelect.prototype.close = function (returnFocus) {
        if (!this.isOpen) {
            return;
        }
        this.isOpen = false;
        this.typed = false;
        this.wrap.classList.remove('is-open');
        this.input.setAttribute('aria-expanded', 'false');
        this.input.removeAttribute('aria-activedescendant');
        this.panel.hidden = true;
        this.list.innerHTML = '';
        this.visible = [];
        this.activeIndex = -1;
        this.syncLabel(); // put the chosen value back in the field
        if (returnFocus) {
            this.input.focus();
        }
    };

    SearchSelect.prototype.render = function () {
        var raw = this.typed ? this.input.value : '';
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
        if (words.length > 0) {
            var ranked = [];
            for (var r = 0; r < results.length; r++) {
                ranked.push({ item: results[r], rank: rank(results[r], query, words), order: r });
            }
            ranked.sort(function (a, b) { return a.rank - b.rank || a.order - b.order; });
            for (var k = 0; k < ranked.length; k++) {
                results[k] = ranked[k].item;
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
            html.push('<li class="iccr-ss-empty" role="presentation">' +
                (total === 0 ? 'No options available.' : 'No match for &ldquo;' + escapeHtml(raw.trim()) + '&rdquo;. Try fewer or different words.') +
                '</li>');
        }
        this.list.innerHTML = html.join('');

        if (words.length === 0) {
            this.count.textContent = total + (total === 1 ? ' option' : ' options') + ' - type in the box above to search';
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
            this.input.removeAttribute('aria-activedescendant');
            return;
        }
        var li = this.list.querySelector('[data-index="' + idx + '"]');
        if (!li) { return; }
        li.classList.add('is-active');
        this.input.setAttribute('aria-activedescendant', li.id);
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
        this.close(true); // also shows the chosen text in the field
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
        try {
            var inst = new SearchSelect(select);
            select.iccrSearchSelect = inst;
            instances.push(inst);
            return inst;
        } catch (err) {
            // Never leave a field unusable: fall back to the normal dropdown.
            select.iccrSearchSelect = { failed: true };
            select.classList.remove('iccr-ss-native');
            select.removeAttribute('aria-hidden');
            select.removeAttribute('tabindex');
            var broken = select.nextSibling;
            if (broken && broken.className === 'iccr-ss') { broken.parentNode.removeChild(broken); }
            if (window.console && window.console.error) { window.console.error('iccr-searchable-select:', err); }
            return null;
        }
    }

    function enhanceAll(root) {
        var list = (root || document).querySelectorAll('select[data-searchable="true"]');
        for (var i = 0; i < list.length; i++) {
            enhance(list[i]);
        }
    }

    // Close when clicking or tabbing anywhere else. Leaving the field is not
    // treated as closing, so dragging the list's scrollbar keeps it open.
    function closeOutside(e) {
        for (var i = 0; i < instances.length; i++) {
            if (instances[i].isOpen && !instances[i].wrap.contains(e.target)) {
                instances[i].close(false);
            }
        }
    }
    document.addEventListener('mousedown', closeOutside);
    document.addEventListener('touchstart', closeOutside, { passive: true });
    document.addEventListener('focusin', closeOutside);

    // Keep labels in step with changes no event reports; also enhance any
    // searchable select added to the page later.
    setInterval(function () {
        for (var i = instances.length - 1; i >= 0; i--) {
            instances[i].poll();
        }
        enhanceAll(document);
    }, 400);

    window.IccrSearchSelect = { enhance: enhance, enhanceAll: enhanceAll, version: '2' };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { enhanceAll(document); });
    } else {
        enhanceAll(document);
    }
})(window, document);
