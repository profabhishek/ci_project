/*
 * A2A session manager: sign out after 30 minutes of NO activity.
 *
 * - "Activity" = mouse, keyboard, scroll, touch or click in ANY open tab of
 *   the portal (tabs share the timer through localStorage), so working in one
 *   tab never logs you out of another.
 * - While you are active, the server session is kept alive with a light
 *   ping (at most every 4 minutes). That means a long form you are typing
 *   into is not lost just because you have not clicked Save yet.
 * - 2 minutes before the limit a dialog offers "Stay signed in".
 * - At the limit the portal signs out in every tab and shows a message.
 *
 * Needs (set by the page header): baseURL, isLogin ("true"/"false"),
 * redirectLink (role logout URL). Server limit: config.php sess_expiration.
 */
(function () {
  'use strict';
  if (window.A2A_SESSION_MANAGED) { return; }
  window.A2A_SESSION_MANAGED = true;

  var IDLE_LIMIT = 30 * 60 * 1000;      // 30 minutes
  var WARN_BEFORE = 2 * 60 * 1000;      // warn 2 minutes before
  var PING_EVERY = 4 * 60 * 1000;       // keep the server session fresh while active
  var KEY_ACT = 'a2a_last_activity';
  var KEY_OUT = 'a2a_signed_out';

  var base = (typeof window.baseURL === 'string' && window.baseURL) ? window.baseURL : '/';
  var loggedIn = String(window.isLogin) === 'true';
  if (!loggedIn) { return; }
  // user/logout works for every role and records the logout in the login history
  var logoutUrl = base + 'user/logout';

  var lastLocal = Date.now();
  var lastPing = Date.now();
  var warnEl = null;
  var countdownTimer = null;
  var done = false;

  function store(k, v) { try { localStorage.setItem(k, String(v)); } catch (e) {} }
  function read(k) { try { return parseInt(localStorage.getItem(k), 10) || 0; } catch (e) { return 0; } }
  function lastActivity() { return Math.max(lastLocal, read(KEY_ACT)); }

  function ping(force) {
    if (!force && Date.now() - lastPing < PING_EVERY) { return; }
    lastPing = Date.now();
    var x = new XMLHttpRequest();
    x.open('GET', base + 'session_ping?t=' + Date.now(), true);
    x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    x.onload = function () {
      try {
        var r = JSON.parse(x.responseText);
        if (r && r.loggedIn === false) { finish(true); }
      } catch (e) { /* page returned HTML: ignore */ }
    };
    x.send();
  }

  function activity() {
    if (done) { return; }
    lastLocal = Date.now();
    store(KEY_ACT, lastLocal);
    if (warnEl) { hideWarning(); ping(true); return; }
    ping(false);
  }

  function fmt(ms) {
    var s = Math.max(0, Math.ceil(ms / 1000));
    return Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2);
  }

  function showWarning() {
    if (warnEl) { return; }
    warnEl = document.createElement('div');
    warnEl.setAttribute('role', 'alertdialog');
    warnEl.setAttribute('aria-live', 'assertive');
    warnEl.setAttribute('aria-labelledby', 'a2aSessTitle');
    warnEl.style.cssText = 'position:fixed;inset:0;z-index:100000;background:rgba(6,20,46,.55);display:flex;align-items:center;justify-content:center;padding:16px;font-family:Inter,"Segoe UI",system-ui,Arial,sans-serif';
    warnEl.innerHTML =
      '<div style="background:#fff;border-radius:16px;max-width:420px;width:100%;padding:26px 26px 22px;box-shadow:0 24px 60px -20px rgba(6,20,46,.6);color:#0f1b2d">' +
      '<div style="width:44px;height:44px;border-radius:12px;background:#fff6e0;color:#93590d;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px">&#9203;</div>' +
      '<h2 id="a2aSessTitle" style="margin:0 0 6px;font-size:19px;font-weight:700">Are you still there?</h2>' +
      '<p style="margin:0 0 18px;color:#5a6a82;font-size:14px;line-height:1.55">For your security you will be signed out in <b id="a2aSessLeft" style="color:#0f1b2d">2:00</b> because of inactivity. Unsaved changes on this page may be lost.</p>' +
      '<div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">' +
      '<button type="button" id="a2aSessOut" style="height:40px;padding:0 16px;border-radius:10px;border:1px solid #dbe3ef;background:#fff;color:#5a6a82;font-weight:600;cursor:pointer">Sign out now</button>' +
      '<button type="button" id="a2aSessStay" style="height:40px;padding:0 18px;border-radius:10px;border:0;background:#163b78;color:#fff;font-weight:700;cursor:pointer">Stay signed in</button>' +
      '</div></div>';
    document.body.appendChild(warnEl);
    document.getElementById('a2aSessStay').onclick = function () { activity(); };
    document.getElementById('a2aSessOut').onclick = function () { finish(false); };
    document.getElementById('a2aSessStay').focus();
    countdownTimer = setInterval(function () {
      var left = IDLE_LIMIT - (Date.now() - lastActivity());
      var el = document.getElementById('a2aSessLeft');
      if (el) { el.textContent = fmt(left); }
    }, 1000);
  }

  function hideWarning() {
    if (countdownTimer) { clearInterval(countdownTimer); countdownTimer = null; }
    if (warnEl && warnEl.parentNode) { warnEl.parentNode.removeChild(warnEl); }
    warnEl = null;
  }

  function finish(alreadyOut) {
    if (done) { return; }
    done = true;
    hideWarning();
    store(KEY_OUT, Date.now());
    var msg = 'You were signed out after 30 minutes of inactivity. Please sign in again.';
    var home = base + '?text=' + encodeURIComponent(msg) + '&type=' + encodeURIComponent('Session ended') + '&at=warning&redirect=' + encodeURIComponent(base);
    if (alreadyOut) { window.location.href = home; return; }
    var x = new XMLHttpRequest();
    x.open('GET', logoutUrl, true);
    x.onloadend = function () { window.location.href = home; };
    x.send();
  }

  function tick() {
    if (done) { return; }
    var idle = Date.now() - lastActivity();
    if (idle >= IDLE_LIMIT) { finish(false); }
    else if (idle >= IDLE_LIMIT - WARN_BEFORE) { showWarning(); }
    else if (warnEl) { hideWarning(); }   // another tab was active
  }

  ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'wheel'].forEach(function (ev) {
    window.addEventListener(ev, function () {
      // mousemove fires a lot: only count it once every 15 seconds
      if (ev === 'mousemove' && Date.now() - lastLocal < 15000) { return; }
      activity();
    }, { passive: true, capture: true });
  });
  window.addEventListener('storage', function (e) {
    if (e.key === KEY_OUT && !done) { finish(true); }
    if (e.key === KEY_ACT) { tick(); }
  });
  document.addEventListener('visibilitychange', function () { if (!document.hidden) { tick(); } });

  store(KEY_ACT, Date.now());
  setInterval(tick, 15000);
})();
