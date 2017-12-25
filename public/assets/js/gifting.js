$(document).ready(function(){
   
    //Collapse panels
    $('a.collapse-panel-button').click(function(){
           
        $(this).parents('.panel').find('.panel-body.collapse-panel').slideToggle(300);
        $(this).toggleClass('rotate-collapse-button');
        
        if($(this).is('#show-birthday')) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: window.location.protocol + '//' + location.host + '/gifting/xhrShowHideBirthday'
            });
        }
        
        if($(this).is('#show-christmas')) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: window.location.protocol + '//' + location.host + '/gifting/xhrShowHideChristmas'
            });
        }
        
        return false;

    });
    
    
    // On available date button click
    $('.available').click(function(){
        askDate($(this).attr('id'),$(this));
    });
    
    // Date picker
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    $('#add-date').datepicker({
        language: 'hu',
        autoclose: true,
        startDate: today
    });
    
    $('#add-christmas-date').datepicker({
        language: 'hu',
        autoclose: true,
        startDate: today
    });
    
    // Clock picker
    $('.clockpicker').clockpicker({
        default: 'now',
        autoclose: true,
        vibrate: true
    });
    
    // Send date ajax
    $('.send-date-form').submit(function() {
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                id: $('.send-date-form').attr('id'),
                date: $('.send-date-form').find('#add-date').val(),
                start_time: $('.send-date-form').find('#add-date-time-from').val(),
                end_time: $('.send-date-form').find('#add-date-time-to').val()
            },
            url: window.location.protocol + '//' + location.host + '/gifting/xhrSendDate',
            error: function() {
                alert('AJAX HIBA!');
            },
            success: function(o) {
                if(o !== 'undefined' && o !== null && o.length !== 0) {
                    $('#available-modal .modal-body .new-date-content').after('<div class="date-alert alert alert-danger fade in text-center">'
                                + '<button data-dismiss="alert" class="close" type="button">'
                                + '<i class="fa fa-times"></i></button>'
                                + o.desc + '</div>');
                }
                else {
                    var button = $('.birthday').find('.available' + '#' + $('.send-date-form').attr('id'));
                    askDate($('.send-date-form').attr('id'),button);
                }
            }
        });
        
        return false;
    });
    
    
    // Pad date for correct format
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
    
    // Load questioned dates
    function askDate(id,object) {
       $('.send-date-form').attr('id',id);
       $('.send-date-form').find('#add-date').val('');
       $('.send-date-form').find('#add-date').addClass('empty');
       $('.send-date-form').find('#add-date-time-from').val('');
       $('.send-date-form').find('#add-date-time-from').addClass('empty');
       $('.send-date-form').find('#add-date-time-to').val('');
       $('.send-date-form').find('#add-date-time-to').addClass('empty');
       $('.date-alert').remove();
       $('#available-modal .modal-header h4 .modal-header-image').remove();
       $('#available-modal .modal-header h4').prepend('<img src="' + object.siblings('a').find('img').attr('src') +'" class="modal-header-image">');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                id: $('.send-date-form').attr('id')
            },
            beforeSend: function() {
                $('#available-modal .modal-body .show-dates').html('<h2>Válaszok</h2><span class="loading-data"><i class="fa fa-refresh fa-spin"></i></span>');
            },
            url: window.location.protocol + '//' + location.host + '/gifting/xhrGetDatesForBirthday',
            error: function() {
                alert('AJAX HIBA!');
            },
            success: function(o) {
                $('.loading-data').remove();
                if(o === 'undefined' || o === null || o.length === 0) {
                    $('#available-modal .modal-body .show-dates').append('<h3 class="text-center">Nincs még megkérdezett időpont</h3>');
                }
                else {
                    $.each(o,function(i,val) {
                        var answer;
                        if(parseInt(val.answered) === 1) {
                            if(parseInt(val.answer) === 1)
                                answer = 'check';
                            else
                                answer = 'close';
                        }
                        else {
                            answer = 'question';
                        }
                        var row = '<div class="row"><div class="col-md-6 text-center">'
                                +   val.start_year + '. ' + pad(val.start_month,2) + '. ' + pad(val.start_day,2) + '. ' 
                                + pad(val.start_hour,2) + ':' + pad(val.start_min,2) + " - " + pad(val.end_hour,2) + ':' 
                                + pad(val.end_min,2)
                                +'</div><div class="col-md-4 text-center"><i class="fa fa-' + answer + '"></i>'
                                + '</div><div class="col-md-2 text-center"><a class="delete-asked-date" href="#" id="' + val.id +'"><i class="fa fa-close"></i></a></div></div>';
                        $('#available-modal .modal-body .show-dates').append(row);
                    });
                }
            }
        });
    }
    
    // On available date button click
    $('.available-group').click(function(){
        askChristmasDate();
    });
    
    // Send christmas date ajax
    $('.send-christmas-date-form').submit(function() {
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                id: $('.send-christmas-date-form').attr('id'),
                date: $('.send-christmas-date-form').find('#add-christmas-date').val(),
                start_time: $('.send-christmas-date-form').find('#add-christmas-date-time-from').val(),
                end_time: $('.send-christmas-date-form').find('#add-christmas-date-time-to').val()
            },
            url: window.location.protocol + '//' + location.host + '/gifting/xhrSendChristmasDate',
            error: function() {
                alert('AJAX HIBA!');
            },
            success: function(o) {
                if(o !== 'undefined' && o !== null && o.length !== 0) {
                    $('#christmas-available-modal .modal-body .new-christmas-date-content').after('<div class="christmas-date-alert alert alert-danger fade in text-center">'
                                + '<button data-dismiss="alert" class="close" type="button">'
                                + '<i class="fa fa-times"></i></button>'
                                + o.desc + '</div>');
                }
                else {
                    askChristmasDate();
                }
            }
        });
        
        return false;
    });
    
    // Load questioned dates
    function askChristmasDate() {
       $('.send-christmas-date-form').find('#add-christmas-date').val('');
       $('.send-christmas-date-form').find('#add-christmas-date').addClass('empty');
       $('.send-christmas-date-form').find('#add-christmas-date-time-from').val('');
       $('.send-christmas-date-form').find('#add-christmas-date-time-from').addClass('empty');
       $('.send-christmas-date-form').find('#add-christmas-date-time-to').val('');
       $('.send-christmas-date-form').find('#add-christmas-date-time-to').addClass('empty');
       $('.christmas-date-alert').remove();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                id: $('.send-christmas-date-form').attr('id')
            },
            beforeSend: function() {
                $('#christmas-available-modal .modal-body .show-dates').html('<h2>Válaszok</h2><span class="loading-christmas-data"><i class="fa fa-refresh fa-spin"></i></span>');
            },
            url: window.location.protocol + '//' + location.host + '/gifting/xhrGetDatesForChristmas',
            error: function() {
                alert('AJAX HIBA!');
            },
            success: function(o) {
                $('.loading-christmas-data').remove();
                if(o === 'undefined' || o === null || o.length === 0) {
                    $('#christmas-available-modal .modal-body .show-dates').append('<h3 class="text-center">Nincs még megkérdezett időpont</h3>');
                }
                else {
                    $.each(o,function(i,val) {
                        var answer;
                        if(parseInt(val.answered) === 1) {
                            if(parseInt(val.answer) === 1)
                                answer = 'check';
                            else
                                answer = 'close';
                        }
                        else {
                            answer = 'question';
                        }
                        var row = '<div class="row"><div class="col-md-6 text-center">'
                                +   val.start_year + '. ' + pad(val.start_month,2) + '. ' + pad(val.start_day,2) + '. ' 
                                + pad(val.start_hour,2) + ':' + pad(val.start_min,2) + " - " + pad(val.end_hour,2) + ':' 
                                + pad(val.end_min,2)
                                +'</div><div class="col-md-4 text-center"><i class="fa fa-' + answer + '"></i>'
                                + '</div><div class="col-md-2 text-center"><a class="delete-asked-christmas-date" href="#" id="' + val.id +'"><i class="fa fa-close"></i></a></div></div>';
                        $('#christmas-available-modal .modal-body .show-dates').append(row);
                    });
                }
            }
        });
    }
    
    // Change answer for dates
    $('.change-answer').click(function() {
        var $this = $(this);
        var id = $(this).attr('id');
        $.ajax({
           type: 'POST',
           dataType: 'json',
           beforeSend: function() {
               $this.find('i').remove();
               $this.html('<i class="fa fa-spin fa-spinner">');
           },
           error: function() {
               alert('AJAX HIBA!');
           },
           data: {
               id: id
           },
           url: window.location.protocol + '//' + location.host + '/gifting/xhrChangeAnswer',
           success: function(o) {
               $this.find('i').remove();
               $this.html('<i class="fa fa-' + o + '">');
           } 
        });
        
        return false;
        
    });
    
    
    // Delete asked dates
    $(document).on('click', "a.delete-asked-date", function() {
        var $this = $(this);
        var id = $(this).attr('id');
        $.ajax({
           type: 'POST',
           beforeSend: function() {
               $this.find('i').remove();
               $this.html('<i class="fa fa-spin fa-spinner">');
           },
           error: function() {
               alert('AJAX HIBA!');
           },
           data: {
               id: id
           },
           url: window.location.protocol + '//' + location.host + '/gifting/xhrDeleteAskedDate',
           success: function() {
               $this.parent('.col-md-2').parent('.row').remove();
               if($('#available-modal .show-dates .row').length === 0) {
                   $('#available-modal .show-dates h2').after('<h3>Nincs még megkérdezett időpont</h3>');
               }
           } 
        });
        
        return false;
    });
    // Delete asked christmas dates
    $(document).on('click', "a.delete-asked-christmas-date", function() {
        var $this = $(this);
        var id = $(this).attr('id');
        $.ajax({
           type: 'POST',
           beforeSend: function() {
               $this.find('i').remove();
               $this.html('<i class="fa fa-spin fa-spinner">');
           },
           error: function() {
               alert('AJAX HIBA!');
           },
           data: {
               id: id
           },
           url: window.location.protocol + '//' + location.host + '/gifting/xhrDeleteAskedChristmasDate',
           success: function() {
               $this.parent('.col-md-2').parent('.row').remove();
               if($('#christmas-available-modal .show--dates .row').length === 0) {
                   $('#christmas-available-modal .show-dates h2').after('<h3>Nincs még megkérdezett időpont</h3>');
               }
           } 
        });
        
        return false;
    });
    
});