<h1>Draft and pending posts</h1>
<?php

use DigraphCMS\UI\Format;
use DigraphCMS\UI\Pagination\PaginatedTable;
use DigraphCMS_Plugins\byjoby\blog\Blog;
use DigraphCMS_Plugins\byjoby\blog\BlogPost;

$posts = Blog::draftsAndPending();
$table = new PaginatedTable(
    $posts,
    function (BlogPost $post): array {
        return [
            $post->url()->html(),
            $post['draft'] ? 'DRAFT' : 'SCHEDULED',
            Format::datetime($post->time()),
            Format::datetime($post->updated())
        ];
    },
    [
        'Post',
        'Status',
        'Published',
        'Updated'
    ]
);
echo $table;
