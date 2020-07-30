var efAccordionGroup = {
  initialized: false,
  closeAll: function(g) {
    Array.from(g.querySelectorAll('[is="accordion"]')).forEach(a => {
      b = a.querySelector('button:first-of-type');
      expanded = b.getAttribute("aria-expanded") === 'true';
      if (expanded) {
        b.setAttribute("aria-expanded","false");
        b.parentElement.nextElementSibling.setAttribute("aria-hidden","true");
      }
    });
  }
}

let efCloseAccordion = function(b) {
  expanded = b.getAttribute("aria-expanded") === 'true';
  if (expanded) {
    b.setAttribute("aria-expanded","false");
    b.parentElement.nextElementSibling.setAttribute("aria-hidden","true");
  }
}

let efOpenAccordion = function(b) {
  expanded = b.getAttribute("aria-expanded") === 'true';
  if (!expanded) {
    g = b.parentElement.parentElement;
    if (g.hasAttribute('is') && g.getAttribute('is') === 'accordion-group') {
      efAccordionGroup.closeAll(g);
    }
    b.setAttribute("aria-expanded","true");
    p = b.parentElement.nextElementSibling
    p.setAttribute("aria-hidden","false");
    p.focus();
  }
}

let efToggleAccordion = function(e) {
  if (e !== undefined) {
    e.preventDefault();
    b = e.target;
    expanded = b.getAttribute("aria-expanded") === 'true';
    if (expanded) {
      efCloseAccordion(b);
    } else {
      efOpenAccordion(b);
    }
  }
}

document.addEventListener("DOMContentLoaded", function() {
  Array.from(document.querySelectorAll('[is="accordion"]')).forEach(a => {
    b = a.querySelector('button:first-of-type');
    if (a.parentElement.hasAttribute('is') && a.parentElement.getAttribute('is') === 'accordion-group') {
      efAccordionGroup.closeAll(a.parentElement);
    } else {
      efCloseAccordion(b);
    }
  });
});
