let efToggleAccordion = function(b) {
  p = b.parentElement.nextElementSibling;
  e = (b.getAttribute("aria-expanded") === 'true');
  b.setAttribute("aria-expanded", (!e).toString());
  p.setAttribute("aria-hidden", e.toString());
  if (e) { p.focus(); }
}

document.addEventListener("DOMContentLoaded", function() {
  Array.from(document.querySelectorAll('[is="accordion"]')).forEach(a => {
    b = a.querySelector('button:first-of-type');
    efToggleAccordion(b);
    b.onclick = function(e) {
      e.preventDefault();
      efToggleAccordion(e.target);
    }
  });
});
