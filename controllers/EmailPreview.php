<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Email\Controllers;

use Arikaim\Core\Controllers\Controller;

/**
 * Email prewview pages controler
*/
class EmailPreview extends Controller
{
    /**
     * Email preview page
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function emailPreview($request, $response, $data) 
    { 
        $language = $this->getPageLanguage($data);       
        $theme = $data->get('theme'); 
        $component = $data->get('component'); 
        $componentName = $theme . ':' . $component;
        
        $mailView = $this->get('email')->render($componentName,[],$language);
        $response->getBody()->write($mailView->getHtmlCode());

        return $response;        
    }
}
