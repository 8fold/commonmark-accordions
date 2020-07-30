<?php

namespace Eightfold\CommonMarkAccordions;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use Eightfold\CommonMarkAccordions\Accordion;
use Eightfold\CommonMarkAccordions\AccordionParser;
use Eightfold\CommonMarkAccordions\AccordionRenderer;

class AccordionExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new AccordionParser(), 1);
        $environment->addBlockRenderer(Accordion::class, new AccordionRenderer());
    }
}
