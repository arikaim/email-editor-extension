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

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Controllers\Traits\Base\Multilanguage;
use Arikaim\Core\Utils\File;

/**
 * Email editor control panel controller
*/
class EmailControlPanel extends ControlPanelApiController
{
    use Multilanguage;

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('email::admin.messages');
    }

    /**
     * Get email source
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getEmailSourceController($request, $response, $data) 
    {  
        $theme = $data->get('theme',null);
        $component = $data->get('component');
        $language = $data->get('language',$this->getPageLanguage($data));
        $componentName = $theme . ':' . $component;
       
        $mailView = $this->get('email')->render($componentName,[],$language);
        
        $this->setResponse(\is_object($mailView),function() use($theme,$component,$mailView) {      
            $code = $mailView->getHtmlCode();                          
            $this
                ->message('source')
                ->field('theme',$theme)               
                ->field('source',$code)     
                ->field('library',$mailView->getLibraryName())
                ->field('inlineCss',$mailView->inlineCssOption())              
                ->field('component',$component);                                       
        },'errors.source');
    }

    /**
     *  Read email file
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function loadEmailFileController($request, $response, $data) 
    {       
        $theme = $data->get('theme',null);
        $component = $data->get('component');
        $language = $data->get('language',$this->getPageLanguage($data));

        $packageManager = $this->get('packages')->create('template');
        $package = $packageManager->createPackage($theme);
        if (\is_object($package) == false) {
            $this->error('errors.theme_name');
            return false;
        }

        // read subject
        $translation = $package->readTranslation(\str_replace('_','.',$component),$language,'emails');
        $subject = $translation['subject'] ?? null;
       
        $path = $package->getComponentPath($component,'emails');
        $fileName = $path . DIRECTORY_SEPARATOR . $this->getComponentFileName($component);
        if (empty($path) == true) {
            $this->error('errors.path');
            return false;
        }
        if (File::exists($fileName) == false) {
            $this->error('errors.code');
            return false;
        }
        
        $fileContent = File::read($fileName);

        $this->setResponse(true,function() use($theme,$component,$fileContent,$subject) {                                
            $this
                ->message('load')
                ->field('theme',$theme)
                ->field('subject',$subject)     
                ->field('content',$fileContent)                         
                ->field('component',$component);                                       
        },'errors.load');
    }

    /**
     *  Save email file
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function saveEmailFileController($request, $response, $data) 
    {  
        $this->onDataValid(function($data) {     
            $theme = $data->get('theme');                     
            $componentName = $data->get('component');
            $component = \str_replace('_','.',$componentName);
            $content = $data->get('content');
            $language = $data->get('language',$this->getPageLanguage($data));
            $subject = $data->get('subject');

            $packageManager = $this->get('packages')->create('template');
            $package = $packageManager->createPackage($theme);
            if (\is_object($package) == false) {
                $this->error('errors.theme_name');
                return false;
            }

            $path = $package->getComponentPath($componentName,'emails');
            $fileName = $path . DIRECTORY_SEPARATOR . $this->getComponentFileName($componentName);

            if (File::exists($fileName) == false) {
                $this->error('errors.file');
                return false;
            }
            if (File::isWritable($fileName) == false) {
                File::setWritable($fileName);
            }
            // email content
            $result = File::write($fileName,$content);
            if ($result == false) {
                $this->error('errors.file');
                return false;
            }

            // save email subject
            $translation = $package->readTranslation($component,$language,'emails');
            $translation = $package->setTranslationProperty($translation,'subject',$subject,'_');
            $result = $package->saveTranslation($translation,$component,$language,'emails');           
            if ($result == false) {
                $fileName = $package->getTranslationFileName($component,$language,'emails');
                if (File::isWritable($fileName) == false) {
                    $this->error('errors.save');
                    return false;
                }
            }

            $this->setResponse($result,function() use($theme,$component) {                                
                $this
                    ->message('save')
                    ->field('theme',$theme)                                
                    ->field('component',$component);                                       
            },'errors.save');
        });
        $data
            ->addRule('text:min=2','theme')             
            ->validate();   
    }

    /**
     * Get component file name.
     *
     * @param string $componentName
     * @return string
     */
    protected function getComponentFileName($componentName)
    {
        $tokens = \explode('.',$componentName);

        return \last($tokens) . '.html';
    }
}
