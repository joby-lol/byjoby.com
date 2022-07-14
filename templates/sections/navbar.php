<?php

use DigraphCMS\Content\Pages;
use DigraphCMS\UI\MenuBar\MenuBar;
use DigraphCMS\URL\URL;

$menu = (new MenuBar)
    ->setID('main-nav');
$menu->addURL(new URL('/'), 'Home');
$menu->addURL(new URL('/blog/'), 'Blog');
if ($home = Pages::get('home')) {
    foreach ($home->children() as $child) {
        $menu->addPage($child);
    }
}
echo $menu;
