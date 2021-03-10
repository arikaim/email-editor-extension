'use strict';

arikaim.component.onLoaded(function() {  
    var theme = $('#theme').val();
    var componentName = $('#component_name').val();
   
    emailEditorApi.loadEmailFile(theme,componentName,function(result) {          
        emailEditor.loadCodeEditor(result.content,function() {        
            $('#code_loader').remove();
        });                     
    },function(error) {
        arikaim.page.loadContent({
            id: 'file_content',
            component: "email::admin.editor.edit.code.form.message"                       
        });  
    });        
}); 