/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function EmailEditorApi() {
    this.editor = null;

    this.loadEmailSource = function(theme, componentName, onSuccess, onError)  {
        return arikaim.get('/api/admin/email/source/' + theme + '/' + componentName,onSuccess,onError);
    };

    this.loadEmailFile = function(theme, componentName, onSuccess, onError) {
        var data = {
            theme: theme,
            component: componentName        
        };

        return arikaim.put('/api/admin/email/load',data,onSuccess,onError);
    };   
    
    this.saveEmailFile = function(theme, componentName, subject, content, onSuccess, onError) {    
        var data = {
            theme: theme,
            component: componentName,   
            subject: subject,
            content: content    
        };

        return arikaim.post('/api/admin/email/save',data,onSuccess,onError);
    };     
}

var emailEditorApi = new EmailEditorApi();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab();   
});