$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value);
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                opcion: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Ingresa el Nombre",
                    minlength: "El nombre debe de ser al menos de mas de dos caracteres"
                },
                opcion: {
                    required: "Ingresa una opcion por favor"
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    //dataType: 'jsonp',
                    url:"contact_process.php",
                    success: function(data) {
                        //debugger;
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo( "slow", 0.15, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').html(data);
                            $('#success').fadeIn();
                            console.log('Se creo la opinon correctamente', data);
                        });
                    },
                    error: function(data) {
                        $('#contactForm').fadeTo( "slow", 0.15, function() {
                            $('#success').html(data);
                            $('#error').fadeIn();
                            console.log('error al crear la opinon',data);
                        });
                    }
                })
            }
        })
    })
        
 })(jQuery)
})