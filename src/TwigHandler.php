<?php
namespace jobyone\PersonalSite;

use jobyone\Plaster\ContentHandlers\AbstractContentHandler;
use jobyone\Plaster\Interfaces\ContentHandler;
use jobyone\Plaster\Interfaces\Response;

class TwigHandler extends AbstractContentHandler implements ContentHandler
{
    public function transform(Response $response)
    {
        // var_dump($this->config->get('TemplateManager.current'));
        $response->setHeaders(array(
            'Content-Type' => 'text/html',
        ));
        return $response;
    }
}
