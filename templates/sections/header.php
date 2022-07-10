<?php

use DigraphCMS\Context;
use DigraphCMS\Session\Session;
use DigraphCMS\UI\UserMenu;

?>
<header id="header">
    <div class="header__branding">
        <span class="header__branding__machine"><?php echo Session::uuid(); ?>@jobys_site</span>:
        <span class="header__branding__path"><?php echo Context::url()->path(); ?></span>
        <span style="white-space:nowrap;">
            $<span class="header__branding__cursor">&#x2588;</span>
        </span>
    </div>
    <div class="header__usermenu">
        <?php echo new UserMenu; ?>
    </div>
</header>