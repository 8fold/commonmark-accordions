let efToggleAccordion = function(e) {
  e.preventDefault();
  b = e.target;
  p = b.parentElement.nextElementSibling;
  e = (b.getAttribute("aria-expanded") === 'true');
  b.setAttribute("aria-expanded", (!e).toString());
  p.setAttribute("aria-hidden", e.toString());
  if (e) { p.focus(); }
}

document.addEventListener("DOMContentLoaded", function() {
  Array.from(document.querySelectorAll('[is="accordion"]')).forEach(a => {
    efToggleAccordion(a.querySelector('button:first-of-type'));
  });
});
