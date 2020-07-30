<!DOCTYPE html>
<html>
<head>
    <title>Testing CommonMark Accordions</title>
    <script type="text/javascript" src="./ef-accordions.js"></script>
    <style type="text/css">
        [is="accordion"] > button:first-of-type {
            display: block;
            width: 100%;
            border: none;
            padding: 4rem;
            font-size: 2rem;
            background-color: darkcyan;
            cursor: pointer;
        }

        [is="accordion"] > button:first-of-type:hover {
            background-color: cadetblue;
        }

        [is="accordion"] > button:first-of-type:before {
          content: "+";
          font-size: 32px;
          margin-right: 8px;
        }

        [is="accordion"] > button:first-of-type[aria-expanded="true"]:before {
            content: "−";
        }

        [aria-hidden="true"] {
            display: none;
        }

        [aria-hidden="false"] {
            display: block;
        }
    </style>
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../vendor/autoload.php");

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;

use Eightfold\CommonMarkAccordions\AccordionExtension;

$environment = \League\CommonMark\Environment::createCommonMarkEnvironment();
$environment->addExtension(new AccordionExtension());
$converter = new CommonMarkConverter([], $environment);

$markdown = <<<EOD
|+ ## Markdown accordions by 8fold
- **Pro:** Simple syntax to achieve richer output.
- **Con:** One more package to keep up to date.

The accordion can accept any markdown that is parsable by your implementation of the CommonMark processor from The PHP League.
+markdown-accordions-by-ef|
EOD;

print $converter->convertToHtml($markdown);
?>
</body>
</html>
