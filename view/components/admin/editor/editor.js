/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function EmailEditor() {
    var self = this;

    this.loadCodeEditor = function(code, onSuccess) {
        arikaim.component.loadLibrary('codemirror:eclipse',function() {
            var textArea = document.getElementById('code_content');

            arikaim.component.loadLibrary('codemirror:template',function() {
                editorControlPanel.editor = CodeMirror.fromTextArea(textArea, {
                    lineNumbers: true,
                    styleActiveLine: true,
                    lineWrapping: true,
                    htmlMode: true,                  
                    mode: "xml"
                });
                editorControlPanel.editor.setValue(code);     
                editorControlPanel.editor.setSize('100%','800px');  
                editorControlPanel.editor.on('change',function(CodeMirror,changeObj) {
                    $('.save-file').removeClass('disabled');                   
                }); 
                callFunction(onSuccess);          
            });
        });                              
    };

    this.loadEmailsEdit = function(theme) {
        arikaim.page.loadContent({
            id: 'editor',
            component: "email::admin.editor.content",
            params: { 
                theme_name: theme
            },
            useHeader: true
        },function(result) {
            self.initRows()
        });     
    };

    this.init = function() {
        $('#templates_dropdown').dropdown({
            onChange: function(name) {
                self.loadEmailsEdit(name);                
            }
        });              
    };

    this.editFile = function(theme, componentName, type) {
        arikaim.page.loadContent({
            id: 'edit_file',
            component: 'email::admin.editor.edit',
            params: { 
                theme_name: theme,
                component_name: componentName,
                type: type
            }
        });
    };

    this.initRows = function() {
        arikaim.ui.button('.edit-file',function(element) {
            var theme = $(element).attr('theme');
            var type = $(element).attr('type');
            var id = $(element).attr('component-id');
            
            $('.component-title').removeClass('green');
            $('#component_title_' + id).addClass('green');

            var componentName = $(element).attr('component');
          
            self.editFile(theme,componentName,type);            
        });    
    };
}

var emailEditor = new EmailEditor();

arikaim.component.onLoaded(function() {
    emailEditor.init();    
});