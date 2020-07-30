<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

use Eightfold\CommonMarkAccordions\Accordion;

use Eightfold\Shoop\Shoop;
use Eightfold\Markup\UIKit;

class AccordionParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $c = $cursor->getCharacter();
        $cPlus = $cursor->peek();
        if ($c !== "|" and $c !== "+" and $cPlus !== "|" and $cPlus !== "+") {
            // only pipe or plus can start
            return false;
        }
// var_dump("regex checks");
//         // may need to bail and rewind
//         $previousCursor = $cursor->saveState();

//         $startContainerRegex = "/^\|\+\+\s?$/";
//         $container = $cursor->match($startContainerRegex);
//         if (empty($container)) {
//             $cursor->restoreState($previousCursor);
//             return false;
//         }
// var_dump($context->getDocument());
//         $lineContent = $context->getLine();
//         $opening = UIKit::div();
// die("instantiate accordion");

        $startAccordionRegex = "/^\|\+ #{2,6} [[:print:]]+/";
        $accordionStart = $cursor->match($startAccordionRegex);
        if (empty($accordionStart)) {
            return false;
        }
        $accordion = new Accordion($context, $cursor);
        // $accordion->handleRemainingContents($context, $cursor);

        $context->addBlock($accordion);
        return true;
// die($accordion->getStringContent());

        // $endAccordionRegex = "/^\+\|/";
        // $isAccordionClose = $cursor->match($endAccordionRegex);
        // if ($isAccordionClose) {
        //     var_dump("process close accordion");
        //     return true;
        // }

        // $endContainerRegex = "/^\+\+[[:print:]]+|/";
        // $isContainerClose = $cursor->match($endContainerRegex);
        // if ($isContainerClose) {
        //     $context = $context->setBlocksParsed(true);
        //     var_dump("process close container");
        //     return true;
        // }

        // if ($context->getBlocksParsed()) {
        //     die("parsed");
        // }
        // return false;
    }
}
