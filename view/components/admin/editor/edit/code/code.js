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

    arikaim.ui.button('.send-test-email',function(element) {
        var theme = $(element).attr('theme');
        var component = $(element).attr('component');

        modal.confirm({ 
            title: 'Confirm',
            description: 'Confirm send email to site admin.'
        },function() {
            arikaim.get('/core/api/mailer/test/email/' + theme + ':' + component,function(result) {         
                arikaim.page.toastMessage(result.message);
            },function(error) {
                arikaim.page.toastMessage({
                    class: 'error',
                    message: error
                })
            });
        });       
    });
}); 