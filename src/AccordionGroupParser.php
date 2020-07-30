<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

use Eightfold\CommonMarkAccordions\AccordionGroup;

use Eightfold\Shoop\Shoop;
use Eightfold\Markup\UIKit;

class AccordionGroupParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $c = $cursor->getCharacter();
        $cPlus = $cursor->peek();
        $cPlusPlus = $cursor->peek(2);
        if ($c !== "|" and $c !== "+" and $cPlus !== "|" and $cPlus !== "+" and $cPlusPlus !== "+") {
            // only pipe or plus can start
            return false;
        }

        $startGroupRegex = "/^\|\+\+\s?$/";
        $groupStart = $cursor->match($startGroupRegex);
        if (empty($groupStart)) {
            return false;
        }

        $accordion = new AccordionGroup($context, $cursor);
        $context->addBlock($accordion);

        return true;
    }
}
