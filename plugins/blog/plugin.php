<?php

namespace DigraphCMS_Plugins\byjoby\blog;

use DigraphCMS\DB\DB;
use DigraphCMS\Plugins\AbstractPlugin;
use DigraphCMS\URL\URL;
use DigraphCMS\Users\Permissions;
use DigraphCMS\Users\User;

class Blog extends AbstractPlugin
{
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
