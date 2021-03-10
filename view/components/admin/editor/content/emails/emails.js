'use strict';

arikaim.component.onLoaded(function() {  
    safeCall('emailEditor',function(obj) {
        obj.initRows();
    },true);   
}); 