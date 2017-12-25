$(window).load(function() {
   
    $('#calendar').fullCalendar({
        lang: 'hu',
        events: {
            url: window.location.protocol + '//' + location.host + '/events/xhrFetchEventsToCalendar',
            type: 'POST',
            error: function() {
                alert('Hiba történt az események letöltése közben!');
            }
        },
        dayClick: function(date) {
            
            var formatDate = moment(date).format('YYYY.MM.DD');
            var today = moment(new Date()).format('YYYY.MM.DD');
            
            if(!(formatDate < today)) {
                $('#new-event-modal #new-event-date').removeClass('empty');
                $('#new-event-modal #new-event-date').val(moment(date).format('YYYY.MM.DD'));

                // Date picker
                $('#new-event-modal #new-event-date').datepicker({
                    language: 'hu',
                    autoclose: true
                });

                // Clock picker
                $('#new-event-modal #new-event-time').clockpicker({
                    default: 'now',
                    autoclose: true,
                    vibrate: true
                });

                $('#new-event-modal').modal('show');  
            }
            
        },
        eventClick: function(event) {
             
            $('#event-modal #event-title').html(event.title);
            
            $('#event-modal #event-id').val(event.id);
            
            if(event.title !== '') {
                $('#event-modal #event-name').removeClass('empty');
            }
            $('#event-modal #event-name').val(event.title);
            
            if(event.start !== '') {
                $('#event-modal #event-date').removeClass('empty');
                $('#event-modal #event-time').removeClass('empty');
            }
            $('#event-modal #event-date').val(moment(event.start).format('YYYY.MM.DD'));
            $('#event-modal #event-time').val(moment(event.start).format('hh:mm'));
            
            if(event.description !== '') {
                $('#event-modal #event-desc').removeClass('empty');
            }
            $('#event-modal #event-desc').val(event.description);
            
            $('#event-modal #event-host').val(event.host);
            
            // Date picker
            $('#event-modal #event-date').datepicker({
                language: 'hu',
                autoclose: true
            });

            // Clock picker
            $('#event-modal #event-time').clockpicker({
                default: 'now',
                autoclose: true,
                vibrate: true
            });
            
            var today = new Date().getTime();
            
            if(today > event.start) {
                $('form#event-form :input').each(function(){
                    $(this).attr('disabled', 'true');
                });
            }
            
            
            $('#event-modal').modal('show');

        },
        loading: function (bool) { 
            if (bool) {
                // Loading
            }
            else {
                if($('#called-event').length > 0) {
                    var events = $('#calendar').fullCalendar('clientEvents', $('#called-event').html());
                    var event = events[0];
                    
                    $('#event-modal #event-title').html(event.title);
            
                    $('#event-modal #event-id').val(event.id);

                    if(event.title !== '') {
                        $('#event-modal #event-name').removeClass('empty');
                    }
                    $('#event-modal #event-name').val(event.title);

                    if(event.start !== '') {
                        $('#event-modal #event-date').removeClass('empty');
                        $('#event-modal #event-time').removeClass('empty');
                    }
                    $('#event-modal #event-date').val(moment(event.start).format('YYYY.MM.DD'));
                    $('#event-modal #event-time').val(moment(event.start).format('hh:mm'));

                    if(event.description !== '') {
                        $('#event-modal #event-desc').removeClass('empty');
                    }
                    $('#event-modal #event-desc').val(event.description);

                    $('#event-modal #event-host').val(event.host);

                    // Date picker
                    $('#event-modal #event-date').datepicker({
                        language: 'hu',
                        autoclose: true
                    });

                    // Clock picker
                    $('#event-modal #event-time').clockpicker({
                        default: 'now',
                        autoclose: true,
                        vibrate: true
                    });

                    var today = new Date().getTime();

                    if(today > event.start) {
                        $('form#event-form :input').each(function(){
                            $(this).attr('disabled', 'true');
                        });
                    }

                    $('#event-modal').modal('show');
                }
            }  
        },
        eventLimit: 3
    });
    
});


