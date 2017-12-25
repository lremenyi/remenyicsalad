$(window).load(function(){
    
    /* Hash password before send */
    $('form').on('submit', function(){
        
        var $pass = $(this).find('#pass');
        var $password = $(this).find('#password');
        
        $password.val(hex_sha512($pass.val()));
        $pass.val('');
        
    });
    
});


