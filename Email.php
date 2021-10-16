<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Email;

use Arikaim\Core\Extension\Extension;

/**
 * Email editor extension
*/
class Email extends Extension
{
    /**
     * Install extension routes, events, jobs ..
     *
     * @return void
    */
    public function install()
    {
        // Preview Page
        $this->addPageRoute('/email/preview/{theme}/{component}','EmailPreview','emailPreview','email::preview','session','email.preview');
        // Control Panel
        $this->addApiRoute('PUT','/api/admin/email/load','EmailControlPanel','loadEmailFile','session'); 
        $this->addApiRoute('POST','/api/admin/email/save','EmailControlPanel','saveEmailFile','session');   
        $this->addApiRoute('GET','/api/admin/email/source/{theme}/{component}','EmailControlPanel','getEmailSource','session'); 
        // Options
        $this->createOption('email.editor.current.theme',null);   
    }
    
    /**
     * UnInstall
     *
     * @return void
     */
    public function unInstall()
    {         
    }
}
