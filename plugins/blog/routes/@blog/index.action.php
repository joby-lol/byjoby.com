<?php

use DigraphCMS\Context;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

/** @var BlogPost */
$post = Context::page();

echo $post->richContent('body');
