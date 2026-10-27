<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		</main>
	</div>
</div>
<script>
// Ask before any button marked data-confirm
document.addEventListener('submit', function (e) {
	var b = e.submitter || e.target.querySelector('[data-confirm]');
	var msg = (b && b.getAttribute('data-confirm')) || e.target.getAttribute('data-confirm');
	if (msg && !window.confirm(msg)) { e.preventDefault(); }
});
// Highlight changed fields and warn before leaving with unsaved changes
(function () {
	var dirty = false;
	document.querySelectorAll('form[data-track]').forEach(function (f) {
		f.addEventListener('input', function (e) {
			var el = e.target, wrap = el.closest('.f');
			if (wrap) { wrap.classList.toggle('changed', el.type === 'checkbox' ? el.checked !== el.defaultChecked : el.value !== el.defaultValue); }
			dirty = true;
		});
		f.addEventListener('submit', function () { dirty = false; });
	});
	window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });
})();
// Filter long forms by field name
document.querySelectorAll('[data-field-filter]').forEach(function (inp) {
	inp.addEventListener('input', function () {
		var q = inp.value.toLowerCase(), box = document.getElementById(inp.getAttribute('data-field-filter'));
		box.querySelectorAll('.f').forEach(function (f) { f.style.display = f.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none'; });
	});
});
// Tabs
document.querySelectorAll('[data-tabs]').forEach(function (tabs) {
	tabs.querySelectorAll('button').forEach(function (b) {
		b.addEventListener('click', function () {
			tabs.querySelectorAll('button').forEach(function (x) { x.classList.remove('on'); x.setAttribute('aria-selected', 'false'); });
			document.querySelectorAll('.ap-pane').forEach(function (p) { p.classList.remove('on'); });
			b.classList.add('on'); b.setAttribute('aria-selected', 'true');
			document.getElementById(b.getAttribute('data-pane')).classList.add('on');
			try { history.replaceState(null, '', '#' + b.getAttribute('data-pane')); } catch (e) {}
		});
	});
	if (location.hash) { var t = tabs.querySelector('[data-pane="' + location.hash.slice(1) + '"]'); if (t) { t.click(); } }
});
</script>
</body>
</html>
