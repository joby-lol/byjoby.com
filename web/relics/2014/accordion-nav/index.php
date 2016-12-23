<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../core.php";
byjoby\Templates\TwigPage::set(array(
    'page_title' => 'Colorful accordion navigation',
));
?>

<link rel="stylesheet" href="color-accordion-nav.css" />
<style>
    .color-accordion-nav {
        font-family:"Roboto",sans-serif;
        font-weight:600;
        text-align:center;
    }
    .color-accordion-nav a.blog {
        background-color:#00aeef!important;
        border-right-color:#00aeef!important;
    }
    .color-accordion-nav a.art {
        background-color:#ffc60b!important;
        border-right-color:#ffc60b!important;
    }
    .color-accordion-nav a.design {
        background-color:#f15a22!important;
        border-right-color:#f15a22!important;
    }
    .color-accordion-nav a.development {
        background-color:#25b34b!important;
        border-right-color:#25b34b!important;
    }
    .color-accordion-nav > ul a {
        line-height:40px;
        padding:10px;
    }
</style>

<h1>Colorful Accordion Navigation</h1>
<div class="color-accordion-nav">
    <ul>
        <li><a href="#" class="home">Home</a></li>
        <li class="current"><a href="#" class="blog current">Blog</a></li>
        <li><a href="#" class="art">Art</a></li>
        <li><a href="#" class="design">Design</a></li>
        <li><a href="#" class="development">Development</a></li>
    </ul>
</div>

<h2>Browser support</h2>
<p>Works great with any modern browser. Offers basic functionality (missing or less-smooth animations) in IE8, and with Javascript enabled. Ugly, but still works as a menu in IE7 and below.</p>
<p>For small screens <code>.color-accordion-nav</code> elements scroll side-to-side with touch events. This means that if you have other navbar elements to display side-by-side with this menu, your best bet is to include them in the <code>.color-accordion-nav</code> element. Either floated or inline-blocked will work. You just have to make sure to define a font size for them, because the root element is set to zero so that inline-block parts fit right up against each other. On small-screened, non-touch devices a horizontal scrollbar will appear if necessary.</p>

<h2>Usage</h2>
<p>It's MIT License, so knock yourself out using and modifying this code! Just remember to leave the copyright/license headers intact. First download these files:</p>
<ul>
    <li><a href="color-accordion-nav.css" target="_blank">color-accordion-nav.css</a></li>
    <li><a href="color-accordion-nav.js" target="_blank">color-accordion-nav.js</a></li>
    <li><a href="http://jquery.com/" target="_blank">jQuery 2.x (older versions may work too)</a></li>
    <li><a href="http://cherne.net/brian/resources/jquery.hoverIntent.html" target="_blank">hoverIntent</a></li>
</ul>
<p>Then have a look at <a href="https://gist.github.com/jobyone/7fc79e6bed37f78fac44" target="_blank">this gist</a> to see how it should be used:</p>
<script src="https://gist.github.com/jobyone/7fc79e6bed37f78fac44.js"></script>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="hoverintent.js"></script>
<script src="color-accordion-nav.js"></script>
