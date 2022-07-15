<?php

namespace DigraphCMS_Plugins\byjoby\blog;

use DigraphCMS\Context;
use DigraphCMS\DB\DB;
use DigraphCMS\Plugins\AbstractPlugin;
use DigraphCMS\UI\Format;
use DigraphCMS\UI\Pagination\PaginatedList;
use DigraphCMS\UI\Sidebar\SidebarEvent;
use DigraphCMS\URL\URL;
use DigraphCMS\Users\Permissions;
use DigraphCMS\Users\User;

class Blog extends AbstractPlugin
{
    public static function onSidebar_top(SidebarEvent $s)
    {
        if (!Context::pageUUID()) return;
        $posts = Blog::forPage(Context::pageUUID());
        if ($posts->count()) {
            $list = new PaginatedList(
                $posts,
                function (BlogPost $post) {
                    return sprintf(
                        '<strong>%s</strong> <small>%s</small>',
                        $post->url()->html(),
                        Format::date($post->time())
                    );
                }
            );
            $s->add('<h1>Blog posts</h1>' . $list);
        }
    }

    public static function select(): BlogSelect
    {
        return (new BlogSelect(
            DB::query()->from('page')
        ))
            ->where('class = "blog"')
            ->where('COALESCE(${data.time}, created) <= ?', [time()])
            ->order('sort_weight ASC')
            ->order('COALESCE(${data.time}, created) DESC');
    }

    public static function forPage(string $uuid): BlogSelect
    {
        return (new BlogSelect(
            DB::query()
                ->from('page_link')
                ->leftJoin('page on page_link.end_page = page.uuid')
                ->select('page.*')
                ->where('start_page = ?', [$uuid])
                ->where('page.class = "blog"')
        ))
            ->where('COALESCE(${data.time}, page.created) <= ?', [time()])
            ->order('sort_weight ASC')
            ->order('COALESCE(${data.time}, page.created) DESC');;
    }

    public function onStaticUrlPermissions_blog(URL $url, User $user)
    {
        if ($url->action() == 'new_post') return Permissions::inMetaGroup('blog__edit', $user);
        else return null;
    }
}
