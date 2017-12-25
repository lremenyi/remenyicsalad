/* CUSTOM JAVASCRIPT PLUGINS */

/* ADD/REMOVE EMPTY CLASS FOR MATERIAL INPUTS */
+function($){
    'use strict';
    
    var materialInput = '.form-control-wrapper input.form-control';
    
    /* Plugin constructor */
    var materialInputEmpty = function(el){
        // Add empty class on load
        $(el).addClass('empty');
        // Change empty class on keyup change
        $(el).on('keyup change', this.changeInputEmpty);    
    };
    
    /* Version number */
    materialInputEmpty.VERSION = '1.0.0';
    
    /* Prototype changeEmpty function */
    materialInputEmpty.prototype.changeInputEmpty = function() {
        var $this = $(this);
        
        if ($this.val() === '') {
            $this.addClass('empty');
        } 
        else {
            $this.removeClass('empty');
        }
    };
    
    /* Plugin  definition*/
    function Plugin(){
        
        return this.each(function(){
            new materialInputEmpty(this);
        });
        
    }
    
    /* Plugin setup */
    var old = $.fn.materialInputEmpty;
    
    $.fn.materialInputEmpty = Plugin;
    $.fn.materialInputEmpty.Constructor = materialInputEmpty;
    
    /* No conflict */
    $.fn.materialInputEmpty.noConflict = function () {
        $.fn.materialInputEmpty = old;
        return this;
    };
    
    /* Load plugin for all inputs declared in the plugin variable */
    $(window).on('load', function(){
        $(materialInput).each(function(){
           Plugin.call($(this));
        });
    });
    
}(jQuery);