/* Admin interactions: mobile rail, password eye, image preview + validation, repeatable sections. */
(function () {
    'use strict';

    // ---------- SweetAlert2 helpers (fall back to native dialogs if the library did not load) ----------
    var NAVY = '#1f1d36';
    function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }

    function confirmBox(message, okLabel) {
        if (!window.Swal) { return Promise.resolve(window.confirm(message)); }
        return Swal.fire({
            title: 'Are you sure?', text: message, icon: 'warning',
            showCancelButton: true, confirmButtonText: okLabel || 'Yes', cancelButtonText: 'Cancel',
            confirmButtonColor: NAVY, cancelButtonColor: '#8a8aa0', reverseButtons: true, focusCancel: true
        }).then(function (r) { return r.isConfirmed; });
    }

    function toast(icon, title) {
        if (!window.Swal) { return; }
        Swal.fire({ toast: true, position: 'top-end', icon: icon, title: title, showConfirmButton: false, timer: 3500, timerProgressBar: true });
    }

    // Mobile navigation rail
    var rail = document.getElementById('adm-rail');
    var burger = document.querySelector('[data-rail-toggle]');
    if (rail && burger) {
        burger.addEventListener('click', function () {
            var open = rail.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { rail.classList.remove('is-open'); burger.setAttribute('aria-expanded', 'false'); }
        });
        document.addEventListener('click', function (e) {
            if (rail.classList.contains('is-open') && !rail.contains(e.target) && !burger.contains(e.target)) {
                rail.classList.remove('is-open');
                burger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Password show / hide (hidden by default)
    document.querySelectorAll('[data-pass]').forEach(function (wrap) {
        var input = wrap.querySelector('input');
        var btn = wrap.querySelector('[data-pass-toggle]');
        var on = wrap.querySelector('[data-eye-on]');
        var off = wrap.querySelector('[data-eye-off]');
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            on.hidden = show;
            off.hidden = !show;
        });
    });

    // Table password cell show / hide
    document.querySelectorAll('[data-pass-cell]').forEach(function (wrap) {
        var btn = wrap.querySelector('[data-pass-cell-toggle]');
        var dots = wrap.querySelector('[data-pass-dots]');
        var plain = wrap.querySelector('[data-pass-plain]');
        var on = wrap.querySelector('[data-eye-on]');
        var off = wrap.querySelector('[data-eye-off]');
        if (!btn || !dots || !plain) { return; }
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var show = plain.hidden;
            plain.hidden = !show;
            dots.hidden = show;
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            btn.setAttribute('title', show ? 'Hide password' : 'Show password');
            if (on && off) {
                on.hidden = show;
                off.hidden = !show;
            }
        });
    });

    // Login history modal
    document.querySelectorAll('[data-login-history]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var name = btn.getAttribute('data-name') || '';
            var phone = btn.getAttribute('data-phone') || '—';
            var email = btn.getAttribute('data-email') || '—';
            var password = btn.getAttribute('data-password') || '';
            var rawHistory = btn.getAttribute('data-history') || '[]';
            var history = [];
            try { history = JSON.parse(rawHistory); } catch (e) { history = []; }

            var passHtml = password
                ? '<span class="adm-modal-pass" data-modal-pass>' +
                    '<span data-modal-dots style="letter-spacing:2px;font-weight:700;">••••</span>' +
                    '<span data-modal-plain hidden style="font-weight:700;letter-spacing:1.5px;color:#1f1d36;">' + esc(password) + '</span> ' +
                    '<button type="button" class="adm-modal-eye" data-modal-pass-toggle title="Show password" aria-label="Show password">' +
                        '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>' +
                    '</button>' +
                  '</span>'
                : '<span style="color:#8a8aa0;">—</span>';

            var historyRows = '';
            if (!history || history.length === 0) {
                historyRows = '<tr><td colspan="3" style="text-align:center;padding:18px;color:#8a8aa0;">No login records found yet.</td></tr>';
            } else {
                history.forEach(function (h, idx) {
                    historyRows += '<tr>' +
                        '<td style="padding:10px 12px;border-bottom:1px solid #f0f0f5;text-align:center;color:#8a8aa0;font-size:12px;">' + (idx + 1) + '</td>' +
                        '<td style="padding:10px 12px;border-bottom:1px solid #f0f0f5;font-weight:600;color:#1f1d36;">' + esc(h.date) + '</td>' +
                        '<td style="padding:10px 12px;border-bottom:1px solid #f0f0f5;color:#4c4a64;">' + esc(h.time) + '</td>' +
                    '</tr>';
                });
            }

            var html = '<div class="adm-hist-modal" style="text-align:left;">' +
                '<div style="background:#fbfbfd;border:1px solid #ececf2;border-radius:12px;padding:14px 16px;margin-bottom:16px;display:grid;grid-template-columns:repeat(auto-fit, minmax(130px, 1fr));gap:12px;font-size:13.5px;">' +
                    '<div><strong style="display:block;color:#8a8aa0;font-size:11px;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">User name</strong><span style="font-weight:700;color:#1f1d36;">' + esc(name) + '</span></div>' +
                    '<div><strong style="display:block;color:#8a8aa0;font-size:11px;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">Phone</strong><span>' + esc(phone) + '</span></div>' +
                    '<div><strong style="display:block;color:#8a8aa0;font-size:11px;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">Email</strong><span>' + esc(email) + '</span></div>' +
                    '<div><strong style="display:block;color:#8a8aa0;font-size:11px;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">Password</strong>' + passHtml + '</div>' +
                '</div>' +
                '<h4 style="margin:0 0 10px;font-size:13px;font-weight:700;color:#1f1d36;text-transform:uppercase;letter-spacing:.06em;">Login History (' + history.length + ')</h4>' +
                '<div style="max-height:260px;overflow-y:auto;border:1px solid #ececf2;border-radius:12px;">' +
                    '<table style="width:100%;border-collapse:collapse;font-size:13px;text-align:left;">' +
                        '<thead><tr style="background:#f5f5f9;color:#6b6b80;font-size:11.5px;text-transform:uppercase;letter-spacing:.06em;">' +
                            '<th style="padding:8px 12px;text-align:center;width:40px;">#</th>' +
                            '<th style="padding:8px 12px;">Date</th>' +
                            '<th style="padding:8px 12px;">Time</th>' +
                        '</tr></thead>' +
                        '<tbody>' + historyRows + '</tbody>' +
                    '</table>' +
                '</div>' +
            '</div>';

            if (window.Swal) {
                Swal.fire({
                    title: 'Login History',
                    html: html,
                    width: 600,
                    confirmButtonColor: NAVY,
                    confirmButtonText: 'Close',
                    didOpen: function (popup) {
                        var toggle = popup.querySelector('[data-modal-pass-toggle]');
                        if (toggle) {
                            toggle.addEventListener('click', function () {
                                var dots = popup.querySelector('[data-modal-dots]');
                                var plain = popup.querySelector('[data-modal-plain]');
                                var hidden = plain.hidden;
                                plain.hidden = !hidden;
                                dots.hidden = hidden;
                                toggle.setAttribute('aria-label', hidden ? 'Hide password' : 'Show password');
                                toggle.setAttribute('title', hidden ? 'Hide password' : 'Show password');
                                toggle.style.color = hidden ? '#1f1d36' : '#8a8aa0';
                            });
                        }
                    }
                });
            } else {
                alert('User: ' + name + '\nPassword: ' + (password || '—') + '\nTotal logins: ' + history.length);
            }
        });
    });

    // Image upload: type + size check, live preview
    var ALLOWED = ['image/jpeg', 'image/png', 'image/webp'];
    document.querySelectorAll('[data-upload]').forEach(function (box) {
        var input = box.querySelector('[data-input]');
        var preview = box.querySelector('[data-preview]');
        var empty = box.querySelector('[data-empty]');
        var error = box.querySelector('[data-error]');
        var maxKb = parseInt(box.getAttribute('data-max-kb'), 10) || 2048;
        var original = preview.getAttribute('src') || '';

        function fail(msg) {
            input.value = '';
            error.textContent = msg;
            error.hidden = false;
            toast('error', msg);
            if (original) { preview.src = original; preview.hidden = false; empty.hidden = true; }
            else { preview.hidden = true; empty.hidden = false; }
        }

        // Reset button: drop a newly chosen file and show the saved image again.
        input.addEventListener('adm:reset', function () {
            input.value = '';
            error.hidden = true;
            if (original) { preview.src = original; preview.hidden = false; empty.hidden = true; }
            else { preview.hidden = true; empty.hidden = false; }
        });

        input.addEventListener('change', function () {
            error.hidden = true;
            var file = input.files && input.files[0];
            if (!file) { return; }
            if (ALLOWED.indexOf(file.type) === -1) { return fail('Only JPG, PNG or WEBP images are allowed.'); }
            if (file.size > maxKb * 1024) { return fail('Image is too large. Maximum size is ' + (maxKb / 1024) + ' MB.'); }
            var url = URL.createObjectURL(file);
            preview.onload = function () { URL.revokeObjectURL(url); };
            preview.src = url;
            preview.hidden = false;
            empty.hidden = true;
        });
    });

    // Confirm destructive actions
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            confirmBox(form.getAttribute('data-confirm'), form.getAttribute('data-confirm-label') || 'Yes, delete').then(function (ok) {
                if (ok) { form.submit(); } // form.submit() does not re-fire this handler
            });
        });
    });

    // Repeatable appraisal sections
    var list = document.querySelector('[data-sections]');
    if (list) {
        var addBtn = document.querySelector('[data-add-section]');
        addBtn.addEventListener('click', function () {
            var first = list.querySelector('[data-section]');
            var copy = first.cloneNode(true);
            copy.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
            list.appendChild(copy);
            copy.querySelector('input').focus();
        });
        list.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-remove-section]');
            if (!btn) { return; }
            var items = list.querySelectorAll('[data-section]');
            var item = btn.closest('[data-section]');
            if (items.length > 1) { item.remove(); }
            else { item.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; }); }
        });
    }

    // Reset button: empties every text field of the form (the browser's own reset would only
    // bring back the saved values). Checkboxes, hidden fields and saved images are left alone.
    document.querySelectorAll('[data-reset]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var form = btn.closest('form');
            if (!form) { return; }
            confirmBox('All fields in this form will be emptied. Nothing is saved until you press Save.', 'Yes, clear').then(function (ok) {
                if (!ok) { return; }
                form.querySelectorAll('input, textarea').forEach(function (el) {
                    var type = (el.getAttribute('type') || 'text').toLowerCase();
                    if (type === 'file') { el.dispatchEvent(new Event('adm:reset')); }
                    else if (['text', 'email', 'url', 'tel', 'number', 'password', 'search'].indexOf(type) !== -1 || el.tagName === 'TEXTAREA') { el.value = ''; }
                });
                // Appraisal pages: keep a single empty section.
                var sections = form.querySelectorAll('[data-section]');
                for (var i = sections.length - 1; i > 0; i--) { sections[i].remove(); }
                var first = form.querySelector('input:not([type=hidden]):not([type=file]):not([type=checkbox]), textarea');
                if (first) { first.focus(); }
                toast('success', 'Fields cleared');
            });
        });
    });

    // Flash messages from the server: success -> toast, errors -> dialog. The plain boxes stay as the fallback.
    document.querySelectorAll('[data-flash]').forEach(function (el) {
        var kind = el.getAttribute('data-flash');
        if (window.Swal) {
            var items = [].map.call(el.querySelectorAll('li'), function (li) { return li.textContent.trim(); });
            var text = el.textContent.replace(/\s+/g, ' ').trim();
            el.hidden = true;
            if (kind === 'ok') { toast('success', text); }
            else {
                Swal.fire({
                    icon: 'error', title: items.length ? 'Please fix the following' : 'Something went wrong',
                    html: items.length ? '<ul style="text-align:left;margin:0;padding-left:20px">' + items.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join('') + '</ul>' : esc(text),
                    confirmButtonColor: NAVY, confirmButtonText: 'OK'
                });
            }
        } else if (kind === 'ok') {
            setTimeout(function () { el.style.transition = 'opacity .4s'; el.style.opacity = '0'; setTimeout(function () { el.remove(); }, 400); }, 4500);
        }
    });
})();
