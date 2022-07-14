<h1>Blog</h1>
<?php

use DigraphCMS\UI\Pagination\PaginatedSection;
use DigraphCMS_Plugins\byjoby\blog\Blog;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

$posts = Blog::select();
$list = new PaginatedSection(
    $posts,
    function (BlogPost $post) {
        return $post->summaryCard();
    }
);
echo $list;
