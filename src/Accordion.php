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

        $preHeader = Shoop::string($cursor->getLine())->minus("|+ ");
        $this->headerElement = $preHeader->divide(" ", false, 2)->first()->count()
            ->string()->startUnfolded("h");
        $this->headerContent = $preHeader->divide(" ", false, 2)->last;
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


        // $header =
        // $header = UIKit::{$this->headerElement}(
        //     UIKit::button(
        //         $this->headerContent
        //     )->attr(
        //         "id {$this->accordionId}",
        //         "aria-controls {$this->accordionId}-panel",
        //         "aria-expanded true",
        //         "onclick efToggleAccordion(event)"
        //     )
        // )->attr("is accordion");

        // $panel = UIKit::div(
        //     $htmlRenderer->renderBlocks($this->children())
        // )->attr(
        //     "is accordion-panel",
        //     "id {$this->accordionId}-panel",
        //     "tabindex -1",
        //     "role region",
        //     "aria-hidden false",
        //     "aria-labelledby {$this->accordionId}"
        // );

        // return $header . $panel;
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
        $this->accordionId = Shoop::string($cursor->getLine())->dropFirst()->dropLast;
        return false;
    }
}
