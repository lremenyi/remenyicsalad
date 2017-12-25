$(document).ready(function() {
    
    if($('#active-image').length > 0) {
        var id = $('#active-image').html();
        $('.image-container#' + id).click();
    }
    
    $('#add-gallery').click(function() {
        
        $('#new-gallery').modal('show');
        
    });
    
    var template = '<div class="preview col-md-3 text-center">' +
                        '<span class="image-holder">' +
                            '<img src="" />' +
                            '<span class="uploaded"></span>' +
                        '</span>' +
                        '<div class="progress-holder">' +
                            '<div class="progress"></div>' +
                        '</div>' +
                        '<div class="form-group">' +
                            '<div class="form-control-wrapper">' +
                                '<input type="text" id="" class="form-control image_name text-center" autocomplete="off" maxlength="30">' +
                                '<span class="material-input-bar"></span>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
    
    var upload_images = [];
    
    function createImage(file){

        var preview = $(template),
            image = $('img', preview);

        var reader = new FileReader();

        image.width = 400;
        image.height = 400;

        reader.onload = function(e){
            image.attr('src',e.target.result);
        };

        // Reading the file as a DataURL. When finished,
        // this will trigger the onload function above:
        reader.readAsDataURL(file);
        
        if(($('.preview').length % 4) === 0 && $('.preview').length !== 0) {
            $('.uploads-here').append('<div class="row"></div>');
        }
        
        preview.appendTo('.uploads-here .row:last-child');

        // Associating a preview container
        // with the file, using jQuery's $.data():
        $.data(file,preview);
    }
    
    $(function(){

        var dropbox = $('#dropbox'),
            message = $('.uploads-here');

        dropbox.filedrop({
            // The name of the $_FILES entry:
            paramname:'pictures',

            maxfiles: 200,
            maxfilesize: 10, // in mb
            url: window.location.protocol + '//' + location.host + '/gallery/xhrGalleryUpload',

            uploadFinished:function(i,file,response){
                if(response.status === 'Hiba! Rossz HTTP metódus!') {
                    $.data(file).remove();
                }
                else if(response.status === 'Csak képfájlok fájlok engedélyezettek!') {
                    $.data(file).remove();
                }
                else if(response.status === 'Valami hiba történt a feltöltés közben!') {
                    $.data(file).remove();
                }
                else {
                    $.data(file).addClass('done');
                    $.data(file).find('.image_name').attr('id',upload_images.length);
                    $.data(file).find('.image_name').attr('value',response.name);
                    upload_images.push(response);
                }
            },

            error: function(err, file) {
                switch(err) {
                    case 'BrowserNotSupported':
                        showMessage('A böngésződ nem támodagtja ezt a fajta fájlfeltöltést');
                        break;
                    case 'TooManyFiles':
                        showMessage('Túl sok fájl egyszerre. Maximum 200 képet tudsz egyszerre feltölteni');
                        break;
                    case 'FileTooLarge':
                        showMessage(file.name+' túl nagy. Egyik kép sem lehet nagyobb 10MB-nál');
                        break;
                    default:
                        break;
                }
            },

            // Called before each upload is started
            beforeEach: function(file){
                if(!file.type.match(/^image\//)){
                    showMessage('Csak képeket tudsz feltölteni!');
                    return false;
                }
            },

            uploadStarted:function(i, file, len){
                createImage(file);
            },

            progressUpdated: function(i, file, progress) {
                $.data(file).find('.progress').width(progress);
            }

        });

        function showMessage(msg){
            $('#dropbox .message').html(msg);
        }

    });

    $('#drop-changes').click(function(e) {
        var $this = $(this);
        e.preventDefault();
        
        var answer = confirm('Biztosan eldobod a módosításokat?');
        if(answer) {
            $.ajax({
                type: "POST",
                beforeSend: function(){
                    $this.html('<i class="fa fa-spinner fa-pulse">');
                },
                data: {
                    must_delete: JSON.stringify(upload_images)
                },
                url: window.location.protocol + '//' + location.host + '/gallery/xhrDropChanges',
                error: function(e) {
                    alert('AJAX HIBA!');
                },
                success: function() {
                    window.location = $this.attr('href');
                    $this.html('Eldobás');
                }
            });
        }
        else {
            return false;
        }
    });
    
    $('#save-changes').click(function(e) {
        var $this = $(this);
        e.preventDefault();
        
        for(var i = 0; i < upload_images.length; i++) { 
            var id = '.image_name#' + i;
            upload_images[i]['name'] = $(id).val();
        }
        
        if($('#gallery-id-container')) {
            var gallery_id = $('#gallery-id-container').html();
        }
        var gallery_name = $('#gallery-name-container').html();
        var gallery_desc = $('#gallery-desc-container').html();
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $this.html('<i class="fa fa-spinner fa-pulse">');
            },
            data: {
                gallery_id: gallery_id,
                gallery_name: gallery_name,
                gallery_desc: gallery_desc,
                images: JSON.stringify(upload_images)
            },
            url: window.location.protocol + '//' + location.host + '/gallery/xhrSaveChanges',
            error: function(e) {
                alert('AJAX HIBA!');
            },
            success: function(e) {
                if(typeof e.status === 'undefined') {
                    $.each(e, function(key,value) {
                       alert(value.error); 
                    });
                }
                else {
                   window.location = $this.attr('href'); 
                }
                $this.html('Mentés');
            }
        });
        
    });
    
    $('.delete-image').click(function(){
        var $this = $(this);
        if($('.delete-checkbox').css('display') === 'none') {
            $('.delete-checkbox').css('display', 'inline-block');
            $('#delete-these').css('display', 'inline-block');
            $this.html('Mégse');
        }
        else {
            $('.delete-checkbox').css('display', 'none');
            $('#delete-these').css('display', 'none');
            $this.html('Kép törlése');
        }       
    });
    
    $('#open-modal').click(function() {
        $('#edit-gallery-name').removeClass('empty');
        $('#edit-gallery-desc').removeClass('empty');
    });
    
});


