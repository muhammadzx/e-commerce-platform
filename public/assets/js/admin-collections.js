(() => {
  'use strict';
  const form = document.getElementById('collection-form');
  if (!form) return;
  const rows = [...form.querySelectorAll('[data-collection-product]')];
  const search = document.getElementById('collection-product-search');
  const discount = document.getElementById('collection-discount');
  const filters = document.getElementById('collection-product-filters');
  const categoryFilter = document.getElementById('collection-filter-category');
  const stockFilter = document.getElementById('collection-filter-stock');
  const minFilter = document.getElementById('collection-filter-min');
  const maxFilter = document.getElementById('collection-filter-max');
  const selectionFilter = document.getElementById('collection-filter-selection');
  const sortFilter = document.getElementById('collection-filter-sort');
  filters.hidden = false;
  const money = value => `${value.toFixed(2)} JOD`;
  function update() {
    let count = 0, subtotal = 0, available = Infinity, valid = true;
    rows.forEach(row => {
      const selected = row.querySelector('input[type=checkbox]').checked;
      const field = row.querySelector('input[type=number]');
      field.disabled = !selected;
      row.classList.toggle('is-selected', selected);
      if (!selected) return;
      count++;
      const quantity = Number(field.value);
      if (!Number.isInteger(quantity) || quantity < 1 || quantity > 999) { valid = false; return; }
      subtotal += Number(row.dataset.price) * quantity;
      available = Math.min(available, Math.floor(Number(row.dataset.stock) / quantity));
    });
    const percent = Number(discount.value);
    valid = valid && discount.value !== '' && Number.isFinite(percent) && percent >= 0 && percent <= 99;
    const final = Math.round(subtotal * (1 - percent / 100) * 100) / 100;
    document.getElementById('collection-selected-count').textContent = String(count);
    document.getElementById('collection-subtotal').textContent = valid ? money(subtotal) : 'Check quantities';
    document.getElementById('collection-discount-total').textContent = valid ? money(subtotal - final) : 'Check discount';
    document.getElementById('collection-final-price').textContent = valid ? money(final) : 'Check details';
    document.getElementById('collection-available').textContent = valid && count ? String(available) : '0';
    document.getElementById('collection-summary-status').textContent = !valid ? 'Check quantities and discount before saving.' : !count ? 'Select at least one product.' : available === 0 ? 'This package is currently out of stock. It can be saved, but customers cannot buy it until stock is available.' : `${count} products selected. ${available} complete packages available.`;
  }
  function filter() {
    const term = search.value.trim().toLocaleLowerCase();
    const min = minFilter.value.trim() === '' ? 0 : Number(minFilter.value);
    const max = maxFilter.value.trim() === '' ? Infinity : Number(maxFilter.value);
    const invalid = !Number.isFinite(min) || (maxFilter.value.trim() !== '' && !Number.isFinite(max)) || min < 0 || max < 0 || min > max;
    let visible = 0;
    rows.forEach(row => {
      const stock = Number(row.dataset.stock), price = Number(row.dataset.price);
      const selected = row.querySelector('input[type=checkbox]').checked;
      const stockMatches = !stockFilter.value || (stockFilter.value === 'in' && stock > 0) || (stockFilter.value === 'low' && stock > 0 && stock <= 5) || (stockFilter.value === 'out' && stock === 0);
      const selectionMatches = !selectionFilter.value || (selectionFilter.value === 'selected' ? selected : !selected);
      row.hidden = invalid || !row.dataset.name.toLocaleLowerCase().includes(term) || (categoryFilter.value !== '' && row.dataset.category !== categoryFilter.value) || !stockMatches || !selectionMatches || price < min || price > max;
      if (!row.hidden) visible++;
    });
    const sorted = [...rows].sort((a,b) => {
      const tie = a.dataset.name.localeCompare(b.dataset.name);
      if (sortFilter.value === 'price_low') return Number(a.dataset.price) - Number(b.dataset.price) || tie;
      if (sortFilter.value === 'price_high') return Number(b.dataset.price) - Number(a.dataset.price) || tie;
      if (sortFilter.value === 'stock_low') return Number(a.dataset.stock) - Number(b.dataset.stock) || tie;
      return tie;
    });
    const list = form.querySelector('.collection-product-list');
    const current = [...list.children];
    if (sorted.some((row,index) => row !== current[index])) {
      const focused = list.contains(document.activeElement) ? document.activeElement : null;
      sorted.forEach(row => list.appendChild(row));
      if (focused && !focused.closest('[data-collection-product]').hidden) focused.focus({ preventScroll: true });
    }
    document.getElementById('collection-product-search-status').textContent = invalid ? 'Enter valid non-negative prices; minimum must not exceed maximum.' : `${visible} products shown. Selected products and their quantities remain in your package when filtered.`;
  }
  function resetFilters() {
    search.value = ''; categoryFilter.value = ''; stockFilter.value = '';
    minFilter.value = ''; maxFilter.value = ''; selectionFilter.value = ''; sortFilter.value = 'name';
    filter();
  }
  form.addEventListener('input', update);
  form.addEventListener('change', update);
  filters.addEventListener('input', filter);
  filters.addEventListener('change', filter);
  document.getElementById('collection-filter-reset').addEventListener('click', resetFilters);
  form.addEventListener('change', event => {
    if (event.target.matches('input[name="selected[]"]')) filter();
  });
  form.addEventListener('invalid', event => {
    if (event.target.closest('[data-collection-product]')) resetFilters();
  }, true);
  form.addEventListener('submit', event => {
    if (!rows.some(row => row.querySelector('input[type=checkbox]').checked)) {
      event.preventDefault();
      resetFilters();
      document.getElementById('collection-summary-status').textContent = 'Select at least one product before saving a package.';
      rows[0]?.querySelector('input[type=checkbox]').focus();
    }
  });
  const image = document.getElementById('collection-image');
  const preview = document.getElementById('collection-image-preview');
  const removeImage = form.querySelector('[name="remove_image"]');
  preview.addEventListener('error', () => { preview.hidden = true; });
  if ((preview.complete && preview.hasAttribute('src') && preview.naturalWidth === 0) || removeImage?.checked) preview.hidden = true;
  removeImage?.addEventListener('change', () => {
    if (image.files.length) return;
    preview.hidden = removeImage.checked || !preview.dataset.existingImage;
    if (!preview.hidden) preview.src = preview.dataset.existingImage;
  });
  let previewUrl = null;
  image.addEventListener('change', () => {
    if (previewUrl) URL.revokeObjectURL(previewUrl);
    preview.hidden = true;
    image.setCustomValidity('');
    const file = image.files[0];
    if (!file) { if (preview.dataset.existingImage && !form.querySelector('[name="remove_image"]:checked')) { preview.src = preview.dataset.existingImage; preview.hidden = false; } return; }
    if (!['image/jpeg','image/png','image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) {
      image.setCustomValidity('Choose a JPG, PNG or WebP image up to 5 MB.');
      image.reportValidity(); return;
    }
    previewUrl = URL.createObjectURL(file);
    preview.src = previewUrl; preview.hidden = false;
  });
  filter(); update();
})();
