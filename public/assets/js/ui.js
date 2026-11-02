/* Shared interaction contracts: modal focus, form feedback and resilient media. */
(() => {
  'use strict';
  let active = null;
  const focusable = root => [...root.querySelectorAll('a[href], button:not(:disabled), input:not(:disabled):not([type=hidden]), select:not(:disabled), textarea:not(:disabled), [tabindex="0"]')]
    .filter(el => el.getClientRects().length && getComputedStyle(el).visibility !== 'hidden');
  function release(root) {
    if (!active || active.root !== root) return;
    const previous = active;
    active = null;
    previous.inert.forEach(([el, value]) => { el.inert = value; });
    if (previous.opener?.isConnected) previous.opener.focus({ preventScroll: true });
  }
  function activate(root) {
    if (active?.root === root) return;
    if (active) release(active.root);
    const state = { root, opener: document.activeElement, inert: [] };
    root.setAttribute('role', 'dialog');
    root.setAttribute('aria-modal', 'true');
    root.tabIndex = -1;
    for (let branch = root; branch.parentElement; branch = branch.parentElement) {
      for (const sibling of branch.parentElement.children) {
        if (sibling !== branch && !['SCRIPT', 'STYLE', 'LINK'].includes(sibling.tagName)) {
          state.inert.push([sibling, sibling.inert]);
          sibling.inert = true;
        }
      }
      if (branch.parentElement === document.body) break;
    }
    active = state;
    requestAnimationFrame(() => {
      if (active === state) root.focus({ preventScroll: true });
    });
  }
  document.addEventListener('toggle', event => {
    if (!event.target.matches?.('[popover]')) return;
    if (event.newState === 'open') activate(event.target);
    else release(event.target);
  }, true);
  document.querySelectorAll('.cx-modal').forEach(root => {
    new MutationObserver(() => {
      if (root.classList.contains('is-open')) activate(root);
      else release(root);
    }).observe(root, { attributes: true, attributeFilter: ['class'] });
  });
  document.addEventListener('keydown', event => {
    if (!active || event.defaultPrevented) return;
    const root = active.root;
    if (event.key === 'Escape') {
      if (root.matches('[popover]')) root.hidePopover();
      else root.querySelector('#review-edit, [data-modal-close]')?.click();
      event.preventDefault();
    }
    if (event.key !== 'Tab') return;
    const items = focusable(root);
    const first = items[0], last = items[items.length - 1];
    if (!first) { event.preventDefault(); root.focus(); return; }
    if (event.shiftKey && (document.activeElement === first || document.activeElement === root)) {
      event.preventDefault(); last.focus();
    } else if (!event.shiftKey && (document.activeElement === last || !root.contains(document.activeElement) || document.activeElement === root)) {
      event.preventDefault(); first.focus();
    }
  });
  document.addEventListener('focusin', event => {
    if (active && !active.root.contains(event.target)) active.root.focus({ preventScroll: true });
  });
  document.querySelector('.skip')?.addEventListener('click', () => {
    const target = document.getElementById('main');
    if (target) { target.tabIndex = -1; target.focus({ preventScroll: true }); }
  });
  document.addEventListener('invalid', event => {
    const field = event.target;
    if (!field.matches('input, select, textarea') || field.type === 'hidden') return;
    field.setAttribute('aria-invalid', 'true');
    if (!field.id) field.id = 'field-' + Math.random().toString(36).slice(2);
    const id = field.id + '-error';
    let message = document.getElementById(id);
    if (!message) {
      message = document.createElement('p');
      message.id = id;
      message.className = 'field-error';
      message.setAttribute('role', 'alert');
      field.closest('.field, .cx-field, label')?.append(message);
      field.setAttribute('aria-describedby', [...new Set(((field.getAttribute('aria-describedby') || '') + ' ' + id).trim().split(/\s+/))].join(' '));
    }
    message.textContent = field.validationMessage;
  }, true);
  document.addEventListener('input', event => {
    const field = event.target;
    if (field.validity?.valid) {
      field.removeAttribute('aria-invalid');
      const message = document.getElementById(field.id + '-error');
      if (message) message.textContent = '';
    }
  });
  const syncProductGallery = () => {
    const gallery = document.querySelector('.nd-gallery');
    if (!gallery) return;
    const all = [...gallery.querySelectorAll('.nd-thumbnail')];
    if (!all.length) return;
    const visible = all.filter(item => !item.hidden);
    let active = visible.find(item => item.classList.contains('active'));
    if (!active && visible.length) {
      active = visible[0];
      const main = gallery.querySelector('#main-product-image');
      if (main) {
        main.removeAttribute('srcset');
        main.removeAttribute('data-fallback');
        main.src = active.dataset.image;
      }
    }
    all.forEach(item => {
      item.classList.toggle('active', item === active);
      item.setAttribute('aria-pressed', String(item === active));
    });
    visible.forEach((item, index) => {
      item.dataset.index = String(index + 1);
      item.setAttribute('aria-label', 'View product image ' + (index + 1));
    });
    const counter = gallery.querySelector('#image-counter');
    if (counter) counter.textContent = String(active ? visible.indexOf(active) + 1 : 0).padStart(2, '0') + ' / ' + String(visible.length).padStart(2, '0');
  };
  document.addEventListener('product-gallery-change', syncProductGallery);
  const showImageFailure = img => {
    if (!(img instanceof HTMLImageElement)) return;
    if (img.hasAttribute('data-managed-preview')) return;
    img.dataset.fallbackApplied = 'true';
    const thumbnail = img.closest('.nd-thumbnail');
    if (thumbnail) { thumbnail.hidden = true; syncProductGallery(); return; }
    if (img.dataset.fallback && img.src !== img.dataset.fallback) { img.removeAttribute('srcset'); img.src = img.dataset.fallback; }
    else {
      const placeholder = document.createElement('span');
      placeholder.className = 'image-fallback';
      placeholder.textContent = img.alt ? 'Image unavailable: ' + img.alt : 'Image unavailable';
      img.replaceWith(placeholder);
    }
  };
  document.addEventListener('error', event => showImageFailure(event.target), true);
  document.querySelectorAll('img[src]').forEach(img => {
    if (img.complete && img.naturalWidth === 0 && img.getAttribute('src')) showImageFailure(img);
  });
})();
