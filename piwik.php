<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class piwikPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onAssetsInitialized' => ['onAssetsInitialized', 0]
        ];
    }

    /**
     * Add piwik JS
     */
    public function onAssetsInitialized()
    {
        if ($this->isAdmin()) {
            return;
        }

        $siteId = trim($this->config->get('plugins.piwik.siteId'));
        $sitePiWikURL = trim($this->config->get('plugins.piwik.sitePiWikURL'));

        if ($siteId && $sitePiWikURL) {
            $init = "
//<!-- Piwik -->
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=\"{$sitePiWikURL}/\";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', {$siteId}]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src=\"{$sitePiWikURL}/piwik.php?idsite={$siteId}\" style=\"border:0;\" alt=\"\" /></p></noscript>
<!-- End Piwik Code -->
<script type=\"text/javascript\">
            ";
            $this->grav['assets']->addInlineJs($init);
        }
    }
}
?>
