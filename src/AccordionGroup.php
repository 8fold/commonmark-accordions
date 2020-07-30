<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Environment;

use League\CommonMark\Renderer\Block\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;

use Eightfold\Shoop\Shoop;
use Eightfold\Markup\UIKit;

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
        $group = UIKit::div(
            $htmlRenderer->renderBlocks($this->children())
        )->attr("is accordion-group")->unfold();
        return $group;
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
