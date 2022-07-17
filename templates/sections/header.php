<?php

use DigraphCMS\Cache\Cache;
use DigraphCMS\Context;
use DigraphCMS\Search\SearchForm;
use DigraphCMS\UI\UserMenu;
use DigraphCMS\URL\URL;
use DigraphCMS\Users\Users;

$breadcrumb = Cache::get(
    'header/breadcrumb' . md5(Context::url()->path()),
    function () {
        $breadcrumb = [];
        $path = '';
        foreach (explode('/', Context::url()->path()) as $part) {
            if ($part) {
                $path .= '/' . $part;
                if (strpos($part, '.') === false) $url = new URL($path . '/');
                else $url = new URL($path);
                $part = sprintf('<a href="%s">%s</a>', $url, $part);
            }
            $breadcrumb[] = $part;
        }
        return implode('<span style="font-size:0;"> </span>/', $breadcrumb);
    }
);

if ($user = Users::current()) {
    $user = sprintf(
        '<a href="%s">%s</a>',
        $user->profile(),
        preg_replace('/[^a-z]+/', '_', strtolower($user->name()))
    );
} else {
    $user = 'guest';
}

$userMenu = new UserMenu;

if (Context::url()->route() == 'search') {
    $search = '';
} else {
    $search = new SearchForm;
    $search->queryField()->setAttribute('placeholder', 'search');
}

?>
<header id="header">
    <div class="header__branding">
        <span class="header__branding__machine"><span style="font-weight:200;"><?php echo $user; ?></span>@<a href="<?php echo new URL("/"); ?>" style="font-weight:800;">byjoby</a></span>:
        <span class="header__branding__path"><?php echo $breadcrumb; ?></span>
        <span class="header__branding__prompt">
            $&nbsp;<span class="header__branding__cursor">&#x2588;</span>
        </span>
    </div>
    <div class="header__search">
        <?php echo $search; ?>
    </div>
    <div class="header__usermenu">
        <?php echo $userMenu; ?>
    </div>
</header>