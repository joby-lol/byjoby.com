<?php

use DigraphCMS\Context;
use DigraphCMS\UI\Format;
use DigraphCMS\UI\Sidebar\Sidebar;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

/** @var BlogPost */
$post = Context::page();

echo $post->richContent('body');

Sidebar::addTop(function () use ($post) {
    $out = [];
    $out[] = 'posted ' . Format::datetime($post->time());
    $out[] = 'by ' . $post->createdBy();
    if ($post->time() != $post->updated()) {
        $out[] = 'updated ' . Format::datetime($post->updated());
        if ($post->updatedByUUID() != $post->createdByUUID()) {
            $out[] = 'by ' . $post->createdBy();
        }
    }
    return '<h1>Post metadata</h1>'
        . implode('<br>', $out);
});
