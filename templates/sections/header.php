<?php

use DigraphCMS\Context;
use DigraphCMS\Session\Session;
use DigraphCMS\UI\UserMenu;

?>
<header id="header">
    <div class="header__branding">
        <span class="header__branding__machine"><span style="font-weight:200;"><?php echo Session::uuid(); ?></span>@<span style="font-weight:800;">byjoby</span></span>:
        <span class="header__branding__path"><?php echo Context::url()->path(); ?></span>
        <span class="header__branding__prompt">
            $&nbsp;<span class="header__branding__cursor">&#x2588;</span>
        </span>
    </div>
    <div class="header__usermenu">
        <?php echo new UserMenu; ?>
    </div>
</header>