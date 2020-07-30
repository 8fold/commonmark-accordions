<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use Eightfold\CommonMarkAccordions\Accordion;
use Eightfold\CommonMarkAccordions\AccordionParser;
use Eightfold\CommonMarkAccordions\AccordionRenderer;

use Eightfold\CommonMarkAccordions\AccordionGroup;
use Eightfold\CommonMarkAccordions\AccordionGroupParser;
use Eightfold\CommonMarkAccordions\AccordionGroupRenderer;

class AccordionGroupExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        // Single
        $environment->addBlockParser(new AccordionParser(), 1);
        $environment->addBlockRenderer(Accordion::class, new AccordionRenderer());

        // Group
        $environment->addBlockParser(new AccordionGroupParser(), 2);
        $environment->addBlockRenderer(AccordionGroup::class, new AccordionGroupRenderer());
    }
}
