<?php

namespace Eightfold\CommonMarkAccordions\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAccordions\AccordionExtension;
use Eightfold\CommonMarkAccordions\AccordionGroupExtension;

class AccordionTest extends TestCase
{
    public function testParser()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AccordionExtension());
        $converter = new CommonMarkConverter([], $environment);

        $doc = <<<EOD
        # Hello

        |+ ## Header
        Content
        +accordion|

        Closing paragraph.
        EOD;
        $expected = '<h1>Hello</h1>'."\n".'<h2 is="accordion"><button id="accordion" onclick="efToggleAccordion(event)" aria-controls="accordion-panel" aria-expanded="true">Header</button></h2><div is="accordion-panel" role="region" id="accordion-panel" tabindex="-1" aria-hidden="false" aria-labelledby="accordion"><p>Content</p></div>'."\n".'<p>Closing paragraph.</p>'."\n";
        $actual = $converter->convertToHtml($doc);
        $this->assertEquals($expected, $actual);
    }

    public function testGroupParser()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AccordionGroupExtension());
        $converter = new CommonMarkConverter([], $environment);

        $doc = <<<EOD
        # Hello

        |++
        |+ ## Header
        Content
        +accordion|
        |+ ## Header 2
        Content
        +accordion2|
        ++|

        Closing paragraph.
        EOD;
        $expected = '<h1>Hello</h1>'."\n".'<div is="accordion-group"><h2 is="accordion"><button id="accordion" onclick="efToggleAccordion(event)" aria-controls="accordion-panel" aria-expanded="true">Header</button></h2><div is="accordion-panel" role="region" id="accordion-panel" tabindex="-1" aria-hidden="false" aria-labelledby="accordion"><p>Content</p></div>'."\n".'<h2 is="accordion"><button id="accordion2" onclick="efToggleAccordion(event)" aria-controls="accordion2-panel" aria-expanded="true">Header 2</button></h2><div is="accordion-panel" role="region" id="accordion2-panel" tabindex="-1" aria-hidden="false" aria-labelledby="accordion2"><p>Content</p></div></div>'."\n".'<p>Closing paragraph.</p>'."\n";
        $actual = $converter->convertToHtml($doc);
        $this->assertEquals($expected, $actual);
    }
}
