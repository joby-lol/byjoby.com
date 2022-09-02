<?php

namespace DigraphCMS_Plugins\byjoby\analytics;

use DigraphCMS\Plugins\AbstractPlugin;

class Analytics extends AbstractPlugin
{

  public static function onCookieName($type, $name)
  {
    if (substr($name, 0, 7) == '_pk_id_') return "Matomo ID";
    else return null;
  }

  public static function onCookieDescribe($type, $name)
  {
    if (substr($name, 0, 7) == '_pk_id_') return "Used to identify this browser session for my self-hosted Matomo analytics server. Is not linked to your identity or persisted once you close your browser.";
    else return null;
  }

  public static function onRenderHeadHtml()
  {
    echo <<<EOD
<!-- Matomo -->
<script>
var _paq = window._paq = window._paq || [];
/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
_paq.push(["setDomains", ["*.byjoby.com"]]);
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function() {
  var u="//interloper.byjoby.com/";
  _paq.push(['setTrackerUrl', u+'matomo.php']);
  _paq.push(['setSiteId', '1']);
  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
  g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
})();
</script>
<noscript><p><img src="//interloper.byjoby.com/matomo.php?idsite=1&amp;rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->
EOD;
  }
}
