'use strict';

arikaim.component.onLoaded(function() {   
    arikaim.ui.button('.save-file',function(element) {
        var content = emailEditorApi.editor.getValue();
        var theme = $('#theme').val();
        var componentName = $('#component_name').val();
        var subject = $('#subject').val();

        emailEditorApi.saveEmailFile(theme,componentName,subject,content,function(result) {          
            arikaim.page.toastMessage(result.message);    
            $('.save-file').addClass('disabled');          
        },function(error) {           
            arikaim.page.toastMessage({
                class: 'error',
                message: error
            });       
        });       
    });
}); 