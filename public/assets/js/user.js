$(window).load(function() {
   
    
    // Hash passwords before send
    $('form#pass-change-form').on('submit', function(e) {
       
        // Declare objects
        var $old = $(this).find('#old_pass');
        var $new = $(this).find('#new_pass');
        var $renew = $(this).find('#new_pass_re');
        var $old_hash = $(this).find('#old_pass_hash');
        var $new_hash = $(this).find('#new_pass_hash');
        var $renew_hash = $(this).find('#new_pass_re_hash');
        
        // Check for to short password
        if($new.val().length < 5) {
            $(this).before('<div class="alert alert-danger fade in text-center">' +
                                '<button data-dismiss="alert" class="close" type="button">' +
                                    '<i class="fa fa-times"></i>' +
                                '</button>' +
                                'Az új jelszónak <strong>legalább öt</strong> karakternek kell lennie!' +
                            '</div>');
            e.preventDefault();
        }
        
        // Fill hash values
        $old_hash.val(hex_sha512($old.val()));
        $new_hash.val(hex_sha512($new.val()));
        $renew_hash.val(hex_sha512($renew.val()));
        
        // Empty password containers !DO NOT SEND!
        $old.val('');
        $new.val('');
        $renew.val('');
        
        
    });
    
    // Scroll to alert
    if($('.alert').length > 0) {
        $('html, body').animate({
            scrollTop: $('.alert').offset().top-150
        }, 500);
    }
    
});


