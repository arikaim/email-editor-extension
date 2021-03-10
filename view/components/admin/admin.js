/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function EmailEditorApi() {
    this.editor = null;

    this.loadEmailFile = function(theme, componentName, onSuccess, onError) {
        var data = {
            theme: theme,
            component: componentName        
        };

        return arikaim.put('/api/email/admin/file/load',data,onSuccess,onError);
    };   
    
    this.saveEmailFile = function(theme, componentName, content, onSuccess, onError) {    
        var data = {
            theme: theme,
            component: componentName,   
            content: content    
        };

        return arikaim.put('/api/email/admin/file/save',data,onSuccess,onError);
    }; 

    this.init = function() {
        arikaim.ui.tab();        
    };
}

var emailEditorApi = new EmailEditorApi();

arikaim.component.onLoaded(function() {
    emailEditorApi.init();
});