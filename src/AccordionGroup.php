<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Environment;

use League\CommonMark\Renderer\Block\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;

/**
 * group pattern:
 * ...\n
 * \n
 * |++\n
 * |+ {header element}\n
 * {markdown content}\n
 * +|\n
 * ++{id}|\n
 * \n
 */
class AccordionGroup extends AbstractBlock
{
    public function element(ElementRendererInterface $htmlRenderer)
    {
        $gContent = $htmlRenderer->renderBlocks($this->children());
        $gFormat  = '<div is="accordion-group">%s</div>';
        return sprintf($gFormat, $gContent);
    }

    public function canContain(AbstractBlock $block): bool
    {
        // only accordions as children
        return $block instanceof Accordion;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        // block closer
        $endContainerRegex = "/^\+\+\|/";
        $containerEnd = $cursor->match($endContainerRegex);
        if (empty($containerEnd)) {
            return true;
        }
        return false;
    }
}
