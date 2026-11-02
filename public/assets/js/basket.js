(() => {
  'use strict';
  // Both views edit the same basket; keep pending quantities together before saving.
  document.addEventListener('input', event => {
    const input = event.target.closest('[data-basket-quantity]');
    if (!input) return;
    document.querySelectorAll('[data-basket-quantity]').forEach(other => {
      if (other !== input && other.dataset.basketQuantity === input.dataset.basketQuantity) other.value = input.value;
    });
  });
})();
