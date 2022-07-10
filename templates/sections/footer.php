<?php

use DigraphCMS\URL\URL;

?>
<footer id="footer">
    <p>
        This website is a pet project of Joby Elliott.
        For more stuff by me check out:
        <a href="https://github.com/jobyone" target="_blank">github/jobyone</a>
        | <a href="https://twitter.com/jobyone" target="_blank">@jobyone</a>
    </p>
    <p>
        This website respects your privacy.
    </p>
    <p>
        It isn't doing any wild behavioral tracking or sharing your browsing data with creepy ad networks.
        It doesn't even use any CDNs for things like fonts or JS libraries.
        No Google Analytics either, or any client-side analytics at all.
        If I want to know how much traffic I get I just look at the Apache access logs.
    </p>
    <p>
        Yes. All that is actually possible. You just have to care about it.
    </p>
    <p>
        For a detailed breakdown of what cookies this site might set and what they are used for, see the
        <a href="<?php echo new URL('/~privacy/'); ?>">privacy and cookie information page</a>.
    </p>
</footer>