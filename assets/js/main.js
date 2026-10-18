// ——— Form submission ———
if (typeof custom !== 'undefined') {
  document.querySelectorAll('.js-callback-form').forEach(function (form) {
    // Снимаем ошибку чекбокса при отметке
    form.querySelectorAll('.checkbox__input').forEach(function (cb) {
      cb.addEventListener('change', function () {
        var lbl = cb.closest('.checkbox');
        if (lbl) lbl.classList.remove('checkbox--error');
        var msg = lbl && lbl.nextElementSibling;
        if (msg && msg.classList.contains('input-error-message')) msg.remove();
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var existingFormErr = form.querySelector('.form__error');
      if (existingFormErr) existingFormErr.remove();

      var phoneInput = form.querySelector('input[name="cb_phone"]');
      if (phoneInput && typeof window.validateBelarusPhone === 'function') {
        var wrapper = phoneInput.closest('.input-wrapper');
        if (!window.validateBelarusPhone(phoneInput.value)) {
          phoneInput.classList.add('input-text--error');
          if (wrapper && !wrapper.querySelector('.input-error-message')) {
            var errMsg = document.createElement('span');
            errMsg.className = 'input-error-message';
            errMsg.textContent = 'Введите корректный белорусский номер';
            wrapper.appendChild(errMsg);
          }
          phoneInput.focus();
          return;
        }
        phoneInput.classList.remove('input-text--error');
        if (wrapper) {
          var oldErr = wrapper.querySelector('.input-error-message');
          if (oldErr) oldErr.remove();
        }
      }

      var selectHasError = false;
      form.querySelectorAll('.custom-select[data-required="1"]').forEach(function (select) {
        var trigger = select.querySelector('.custom-select__trigger');
        var hidden  = select.querySelector('input[type="hidden"]');
        var wrapper = select.closest('.input-wrapper');
        var oldErr  = wrapper && wrapper.querySelector('.input-error-message');
        if (oldErr) oldErr.remove();
        trigger.classList.remove('input-text--error');

        if (!hidden.value) {
          selectHasError = true;
          trigger.classList.add('input-text--error');
          if (wrapper) {
            var errMsg = document.createElement('span');
            errMsg.className = 'input-error-message';
            errMsg.textContent = 'Выберите тип работ';
            wrapper.appendChild(errMsg);
          }
        }
      });
      if (selectHasError) return;

      var consentCb = form.querySelector('.checkbox__input');
      if (consentCb && !consentCb.checked) {
        var consentLbl = consentCb.closest('.checkbox');
        if (consentLbl) {
          consentLbl.classList.add('checkbox--error');
          if (!consentLbl.nextElementSibling || !consentLbl.nextElementSibling.classList.contains('input-error-message')) {
            var cErr = document.createElement('span');
            cErr.className = 'input-error-message';
            cErr.textContent = 'Необходимо согласие с политикой обработки данных';
            consentLbl.after(cErr);
          }
        }
        return;
      }

      var btn      = form.querySelector('[type="submit"]');
      if (!btn) return;
      var origText = btn.textContent;

      btn.textContent = 'Отправляем...';
      btn.disabled    = true;
      btn.classList.add('is-loading');

      var data = new FormData(form);
      data.append('action', 'custom_submit');
      data.append('nonce',  custom.nonce);
      data.append('source', window.location.href);

      fetch(custom.ajax_url, { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            btn.classList.remove('is-loading');
            btn.classList.add('is-sent');
            btn.textContent = 'Отправлено!';
            setTimeout(function () {
              window.location.href = custom.thanks_url;
            }, 800);
          } else {
            btn.textContent = origText;
            btn.disabled    = false;
            btn.classList.remove('is-loading', 'is-sent');
            var formErr = document.createElement('p');
            formErr.className = 'form__error';
            formErr.textContent = (res.data && res.data.message) ? res.data.message : 'Произошла ошибка. Попробуйте ещё раз.';
            form.appendChild(formErr);
          }
        })
        .catch(function () {
          btn.textContent = origText;
          btn.disabled    = false;
          btn.classList.remove('is-loading', 'is-sent');
          var formErr = document.createElement('p');
          formErr.className = 'form__error';
          formErr.textContent = 'Ошибка соединения. Попробуйте ещё раз.';
          form.appendChild(formErr);
        });
    });
  });
}

document.addEventListener("click", (event) => {
  const btn = event.target.closest("[data-open]");
    let is_flag = false;

  const closable = document.querySelectorAll("[data-closable]");

  for (const it of closable) {
    const targetId      = it.dataset.closable;
    const targetElement = document.getElementById(targetId);
    let btnTargetId     = null;

    

    if (targetElement && !it.contains(event.target)) {
        if (btn) {
            btnTargetId = btn.dataset.open;
              if (btnTargetId !== targetId) {
                targetElement.classList.remove("open");
              }
        } else {
                targetElement.classList.remove("open");
        }
      
    }
  }

  if (btn) {
    const targetId      = btn.dataset.open;
    const targetElement = document.getElementById(targetId);
    if (targetElement) {
      targetElement.classList.toggle("open");
    }
  }
});

// ——— Кастомный select («Тип работ» и т.п.) ———
document.querySelectorAll('.custom-select').forEach(function (select) {
  var trigger = select.querySelector('.custom-select__trigger');
  var valueEl = select.querySelector('.custom-select__value');
  var hidden  = select.querySelector('input[type="hidden"]');
  var options = select.querySelectorAll('.custom-select__option');

  function closeSelect() {
    select.classList.remove('is-open');
    trigger.setAttribute('aria-expanded', 'false');
  }

  function openSelect() {
    document.querySelectorAll('.custom-select.is-open').forEach(function (other) {
      if (other !== select) other.classList.remove('is-open');
    });
    select.classList.add('is-open');
    trigger.setAttribute('aria-expanded', 'true');
  }

  trigger.addEventListener('click', function (e) {
    e.stopPropagation();
    select.classList.contains('is-open') ? closeSelect() : openSelect();
  });

  options.forEach(function (option) {
    option.addEventListener('click', function () {
      var value = option.dataset.value || '';
      hidden.value = value;
      valueEl.textContent = option.textContent;
      select.classList.toggle('has-value', value !== '');
      trigger.classList.remove('input-text--error');
      var wrapper = select.closest('.input-wrapper');
      var errMsg  = wrapper && wrapper.querySelector('.input-error-message');
      if (errMsg) errMsg.remove();
      options.forEach(function (o) { o.classList.remove('is-selected'); });
      option.classList.add('is-selected');
      closeSelect();
      hidden.dispatchEvent(new Event('change', { bubbles: true }));
    });
  });

  document.addEventListener('click', function (e) {
    if (!select.contains(e.target)) closeSelect();
  });
});

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document.querySelectorAll('.custom-select.is-open').forEach(function (select) {
      select.classList.remove('is-open');
      select.querySelector('.custom-select__trigger').setAttribute('aria-expanded', 'false');
    });
  }
});