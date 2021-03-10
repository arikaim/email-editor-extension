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
        // Control Panel
        $this->addApiRoute('PUT','/api/email/admin/file/load','EmailControlPanel','loadEmailFile','session'); 
        $this->addApiRoute('PUT','/api/editor/admin/file/save','EmailControlPanel','saveEmailFile','session');   
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
