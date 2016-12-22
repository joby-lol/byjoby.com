<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../core.php";

//parse file
$parser      = new Mni\FrontYAML\Parser();
$document    = $parser->parse(file_get_contents(__DIR__ . '/index.md'));
$frontMatter = $document->getYAML();
$content     = $document->getContent();

//send front matter into Template and echo content
byjoby\Templates\TwigPage::set($frontMatter);
echo $content;
