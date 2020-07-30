<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;

class AccordionRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (! ($block instanceof Accordion)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }
        return $block->element($htmlRenderer);
    }
}
