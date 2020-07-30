# 8fold Accordions for CommonMark

Inspired by accessible accordion patterns described by [Graham Armfield](https://www.hassellinclusion.com/blog/accessible-accordion-pattern/) and the [USWDS](https://designsystem.digital.gov/components/accordion/) (and preparing for a hopeful futre where `<details>` or some other native element is the answer) this extension is as much about centralizing the pattern as anything else.

## The syntax

Inspired by conversations in the [CommonMark Spec board](https://talk.commonmark.org/t/html-details-tag/759) we wanted to maintain or principle that Markdown is not HTML that happens to be human-readable, plain-text; rather, it's human-readable, plain-text that can be converted to a rich text format. It just happens the most popular rich-text medium is HTML. Therefore, the following pattern is for a single accordion element (collapsable section):

```markdown
|+ ## Heading
...markdown content (not another accordion; no nesting)
+accordion-id|
```

In an HTML context, an `id` is needed to generate various attributes for interaction handling via client-side scripting languages such as JavaScript. Without the `id` a fully functional and accessible component could not be rendered. However, given the aforementioned principle and the fact the `id` is not required for reading the document content, the `id` is declared as part of the closing.

Each according starts with a heading with a level of `h2` to `h6`. `h1` was not considered as viable as in HTML there can be only one per document and conceptually if one could collaps an entire document, the document is closed.

The above would render the following HTML:

```html
<h2 is="accordion">
  <button id="accordion" aria-controls="accordion-panel" aria-expanded="true">Header</button>
</h2>
<div is="accordion-panel" role="region" id="accordion-panel" tabindex="-1" aria-hidden="false" aria-labelledby="accordion">
  <p>...markdown content (not another accordion; no nesting)</p>
</div>
```

Because one of our primary concerns is always around accessibility (particularly technological accessibility), the rendering of the accordions presumes they will not be collapsed on initial load - allowing you to collapse them with client-side scripting.

We use the `is` attribute over placing custom class names or `data-*` attributes to identify the accordion as an accordion.

## Roadmap

- [ ] Accordion block, which would allow the creation of a croup of accordions (similar to `fieldset` and `input`).
- [ ] Supply a generic JS file (or use inline javascript) with a working implementation for both single and multiple accordions.
- [ ] When singular, users can expand and collapse a single accordion. When grouped, only one accordion will be open at a time.
