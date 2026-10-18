(function () {
  var PREFIX = '+375 (';
  var VALID_CODES = ['17', '25', '29', '33', '44'];

  function extractDigits(str) {
    return str.replace(/\D/g, '');
  }

  function formatPhone(digits) {
    var r = PREFIX;
    for (var i = 0; i < digits.length && i < 9; i++) {
      if (i === 2) r += ') ';
      if (i === 5) r += '-';
      if (i === 7) r += '-';
      r += digits[i];
    }
    return r;
  }

  function getLocalDigits(value) {
    var all = extractDigits(value);
    if (all.indexOf('375') === 0) return all.substring(3);
    return all;
  }

  function validatePhone(value) {
    var digits = extractDigits(value);
    if (digits.length !== 12) return false;
    if (digits.substring(0, 3) !== '375') return false;
    return VALID_CODES.indexOf(digits.substring(3, 5)) !== -1;
  }

  window.validateBelarusPhone = validatePhone;

  function initPhoneMask(input) {
    input.addEventListener('focus', function () {
      if (!input.value) {
        input.value = PREFIX;
        setTimeout(function () { input.setSelectionRange(PREFIX.length, PREFIX.length); }, 0);
      }
    });

    input.addEventListener('blur', function () {
      if (input.value === PREFIX) input.value = '';
    });

    input.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace') {
        var pos = input.selectionStart;
        if (pos <= PREFIX.length) {
          e.preventDefault();
          return;
        }
        var ch = input.value[pos - 1];
        if (ch === ' ' || ch === ')' || ch === '-' || ch === '(') {
          e.preventDefault();
          var local = getLocalDigits(input.value);
          if (local.length === 0) return;
          local = local.substring(0, local.length - 1);
          input.value = formatPhone(local);
          var newPos = input.value.length;
          input.setSelectionRange(newPos, newPos);
        }
      }
      if (e.key === 'Delete' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
        return;
      }
    });

    input.addEventListener('input', function () {
      var local = getLocalDigits(input.value);
      if (local.length > 9) local = local.substring(0, 9);
      input.value = formatPhone(local);
      var pos = input.value.length;
      input.setSelectionRange(pos, pos);

      input.classList.remove('input-text--error');
      var wrapper = input.closest('.input-wrapper');
      if (wrapper) {
        var err = wrapper.querySelector('.input-error-message');
        if (err) err.remove();
      }
    });

    input.addEventListener('paste', function (e) {
      e.preventDefault();
      var pasted = (e.clipboardData || window.clipboardData).getData('text');
      var digits = extractDigits(pasted);
      if (digits.indexOf('80375') === 0) digits = digits.substring(2);
      else if (digits.indexOf('375') === 0) digits = digits.substring(3);
      else if (digits.indexOf('80') === 0) digits = digits.substring(2);
      if (digits.length > 9) digits = digits.substring(0, 9);
      input.value = formatPhone(digits);
      var pos = input.value.length;
      input.setSelectionRange(pos, pos);
    });

    input.addEventListener('mouseup', function () {
      if (input.selectionStart < PREFIX.length) {
        input.setSelectionRange(PREFIX.length, PREFIX.length);
      }
    });

    input.addEventListener('keyup', function () {
      if (input.selectionStart < PREFIX.length && input.value.length >= PREFIX.length) {
        input.setSelectionRange(PREFIX.length, PREFIX.length);
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var inputs = document.querySelectorAll('input[name="cb_phone"]');
    for (var i = 0; i < inputs.length; i++) {
      initPhoneMask(inputs[i]);
    }
  });
})();
