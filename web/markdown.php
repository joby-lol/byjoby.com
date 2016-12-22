<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../core.php";

$url  = $_GET['url'];
$url  = preg_replace('/\.+/', '.', $url);
$file = __DIR__ . $url;
if (is_dir($file)) {
    $file = preg_replace('/([^\/])$/', '$1/', $file);
    $file .= 'index.md';
}
if (!preg_match('/\.md$/i', $file) || !is_file($file) || !is_readable($file)) {
    byjoby\Templates\TwigPage::abort('404');
}

//parse file
$parser      = new Mni\FrontYAML\Parser();
$document    = $parser->parse(file_get_contents($file));
$frontMatter = $document->getYAML();
$content     = $document->getContent();

//send front matter into Template and echo content
byjoby\Templates\TwigPage::set($frontMatter);
echo $content;
