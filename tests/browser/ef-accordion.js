let efToggleAccordion = function(e) {
  if (e !== undefined) {
      console.log(e);
    e.preventDefault();
    b = e.target;
    p = b.parentElement.nextElementSibling;
    ex = (b.getAttribute("aria-expanded") === 'true');
    b.setAttribute("aria-expanded", (!ex).toString());
    p.setAttribute("aria-hidden", ex.toString());
    if (!ex) { p.focus(); }
  }
}

document.addEventListener("DOMContentLoaded", function() {
  Array.from(document.querySelectorAll('[is="accordion"]')).forEach(a => {
    efToggleAccordion(a.querySelector('button:first-of-type').click());
  });
});
