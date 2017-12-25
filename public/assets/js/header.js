$(document).ready(function(){
  
    // Sidebar collapse on high res
    $('.sidebar-collapse-li').click(function(){
        if($('#sidebar').hasClass('sidebar-small')) {
            $(function(){
                $('#sidebar').removeClass('sidebar-small');
                $('#main-content').removeClass('main-expanded');
                $('.brand').removeClass('only-logo');
                $('.sidebar-toggle li i').removeClass('small');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: window.location.protocol + '//' + location.host + '/header/xhrMenuChanged'
                });
            });
        }
        else {
            $(function(){
                $('#sidebar').addClass('sidebar-small');
                $('#main-content').addClass('main-expanded');
                $('.brand').addClass('only-logo');
                $('.sidebar-toggle li i').addClass('small');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: window.location.protocol + '//' + location.host + '/header/xhrMenuChanged'
                });
            });
        }
    });
    
    // Sidebar collapse on small res
    $('.sidebar-collapse-li-small-res').click(function(){
        if($('#sidebar').hasClass('show-sidebar')) {
            $(function(){
                $('#sidebar').removeClass('show-sidebar');
            });
        }
        else {
            $(function(){
                $('#sidebar').addClass('show-sidebar');
            });
        }
    });
    
    /* Left sidebar scroll */
    if($.fn.niceScroll){
        $(".leftside-navigation").niceScroll({
            railalign: "right",
            cursorcolor: "#0D47A1",
            cursorborder: "0px solid #fff",
            cursorborderradius: "0px",
            cursorwidth: "5px"
        });
    }
    
});


