'use strict';

arikaim.component.onLoaded(function() {   
    arikaim.ui.button('.preview-email',function(element) {
        var componentName = $('#component_name').val();
        var theme = $('#templates_dropdown').dropdown('get value');

        arikaim.page.loadContent({
            id: 'email_preview_content',
            component: 'email::admin.editor.preview',
            params: { 
                theme_name: theme,
                theme_component: componentName,
                type: type
            }
        });
    });
}); 