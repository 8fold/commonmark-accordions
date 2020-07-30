# 8fold Accordions for CommonMark

Inspired by accessible accordion patterns described by [Graham Armfield](https://www.hassellinclusion.com/blog/accessible-accordion-pattern/) and the [USWDS](https://designsystem.digital.gov/components/accordion/) (and preparing for a hopeful futre where `<details>` or some other native element is the answer) this extension is as much about centralizing the pattern as anything else.

## Installation

```bash
composer require 8fold/commonmark-accordions
```

## Usage

```markdown
|+ ## Markdown accordions by 8fold
- **Pro:** Simple syntax to achieve richer output.
- **Con:** One more package to keep up to date.

The accordion can accept any markdown that is parsable by your implementation of the CommonMark processor from The PHP League.

The accordions can be used independently, or grouped.

When grouped and using the provided JavaScript, only one accordion will be allowed to be open at a time.
+markdown-accordions-by-ef|
```

## The syntax

Inspired by conversations in the [CommonMark Spec board](https://talk.commonmark.org/t/html-details-tag/759) we wanted to maintain our principle that Markdown is not HTML that happens to be human-readable, plain-text; rather, it's human-readable, plain-text that can be converted intto a rich text format. It just happens, the most popular rich-text format is HTML. Therefore, the following pattern is for a single accordion element (collapsable section):

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

For an accordion group, the individual accorions are wrapped simlarly to the individual accordions (trying to reduce cognitive load):

```markdown
|++
++|
```

When rendered, the opening and closing group signifiers are opening and closing `div` tags, respectively.

Because one of our primary concerns is always accessibility (particularly technological accessibility), the rendering of the accordions presumes they will be expanded on initial load - you can then collapse using with client-side scripting.

We use the `is` attribute over placing custom class names or `data-*` attributes to identify the accordion as an accordion.
