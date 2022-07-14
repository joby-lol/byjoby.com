<?php
// this route just redirects to a dedicated adder page in the plugin route

use DigraphCMS\Context;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\URL\URL;

throw new RedirectException(new URL('/blog/new_post.html?parent=' . Context::pageUUID()));
