var chat = {};

chat.fetchMessages = function ()
    {
        var key1 = $('#form_key').val();

        $.ajax({
            url: '/chats/fetch/',
            type: 'post',
            data: {method: 'fetch',message: message, key1: key1},
            success: function (data) {
                    $('#message').val("");
                    $('ul#chatMessage').append(data);
                    //  $('div').animate({scrollBottom: $("ul#chatMessage").last().offset().top}, '500','slow');
                }
        });
    };

chat.entry = $('#message');
chat.entry.bind("keyup", function(event)
    {
       // var key = e.which;
        if (event.which == 13)
            {
                chat.throwMessage($(this).val());
                event.preventDefault();
            }
            event.stopPropagation();
    });

chat.throwMessage = function (message)
    {
        if ($.trim(message).length !== 0)
            {
                 var key1 = $('#form_key').val();
                 var message = $('#message').val();
                
                $.ajax({
                    url: '/public/chats/add/',
                    type: 'post',
                    data: {method: 'throw', message: message, key1: key1},
                    success: function (data)
                        {
                            $('#message').val('');
                            $('ul#chatMessage').append(data);
                             $('div').animate({scrollBottom: $("ul#chatMessage").last().offset().top}, '500','slow');
                            //$('#chat_area').animate({scrollTop: $('ul#chatMessage').last().offset().top - $(window).scrollTop()},'slow');
                            //('#chat_area').scrollTop(30);
                            
                           // console.log("scrolltop = " + {scrollTop: $('ul#chatMessage').last().offset().top});
                        }
                        
                });
            }

    };


function startChatConnection()
    {
        chat.interval = setInterval(chat.fetchMessages, 6000);
        chat.fetchMessages();
    }


function updateChatMessage2()
    {
        var message = $('#message').val();
        var key1 = $('#form_key').val();

        $.ajax({
            url: '/public/chats/add/',
            type: 'post',
            data: {message: message, key1: key1},
            success: function (data)
                {
                    $('#message').val("");
                    $('ul#chatMessage').append(data);

                }
        });
    }


function showModal(modalTitle, modalBody)
    {
        $("#modal-general-title").html(modalTitle);
        $("#modal-general-content").html(modalBody);
    }
