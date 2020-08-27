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
 * single pattern:
 * |+ {header element}\n
 * {markdown content}\n
 * +accorion-id|\n
 *
 * wrap pattern:
 * ...\n
 * \n
 * |++\n
 * |+ {header element}\n
 * {markdown content}\n
 * +|\n
 * ++{id}|\n
 * \n
 *
 * Note: If a `single pattern` inside a `wrap pattern` has an id applied, it will be ignored. To handle counting??
 */
class Accordion extends AbstractBlock
{
    private $context;

    private $headerElement = 2;
    private $headerContent = "";

    private $accordionId = "";

    public function __construct(
        ContextInterface $context,
        Cursor $cursor
    )
    {
        $this->context = $context;
        $this->setStartLine($this->context->getLineNumber());
        $this->setLastLineBlank(true);

        $preHeader = substr($cursor->getLine(), 3);
        list($element, $content) = explode(" ", $preHeader, 2);

        $this->headerContent = $content;
        $this->headerElement = "h". strlen($element);
    }

    public function element(ElementRendererInterface $htmlRenderer)
    {
        $hElem   = $this->headerElement;
        $hFormat = '<%s is="accordion">%s</%s>';

        $bId      = $this->accordionId;
        $bContent = $this->headerContent;
        $bFormat  = '<button id="%s" onclick="efToggleAccordion(event)" aria-controls="%s" aria-expanded="true">%s</button>';


        $pId      = $bId ."-panel";
        $pContent = $htmlRenderer->renderBlocks($this->children());
        $pFormat  = '<div is="accordion-panel" role="region" id="%s" tabindex="-1" aria-hidden="false" aria-labelledby="%s">%s</div>';


        $bString = sprintf($bFormat, $bId, $pId, $bContent);
        $hString = sprintf($hFormat, $hElem, $bString, $hElem);
        $pString = sprintf($pFormat, $pId, $bId, $pContent);

        return $hString . $pString;
    }

    public function canContain(AbstractBlock $block): bool
    {
        // Can't have child accordion
        return ! $block instanceof Accordion;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        // block closer
        $endContainerRegex = "/^\+[^\+][[:print:]]+\|/";
        $containerEnd = $cursor->match($endContainerRegex);
        if (empty($containerEnd)) {
            return true;
        }
        $this->accordionId = substr($cursor->getLine(), 1, -1);
        return false;
    }
}
