var chat = {};

//get all messages for this chat
chat.fetchMessages = function ()
    {
        var key1 = $('#form_key').val();
       // var message = $('#message').val();

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

/*
 function message_submit()
 {
 //$("#messageId").submit();
 }
 ;
 
 function message_clear_text()
 {
 //$("#list_search").val("");
 //manage_filter_list_submit();
 }
 
 
 function updateMessages()
 {
 alert("Javascript fired!!!!");
 
 var chat = $('#messageId').val();
 var key1 = $('#form_key').val();
 // $.getJSON("/app/controllers/add/?jsoncallback=?",
 $.getJSON("/public/chats/add/?jsoncallback=?",
 {chat: chat, key1: key1},
 function (data)
 {
 console.log(data);
 if (data.r === 1)
 {
 $('header_sec').append(data.d);
 $('contact_sec').append(data);
 }
 else
 {
 //$('#messId').append("<p>Error</p>");
 // $("#modal-title").html(data.title);
 // $("#modal-body").html(data.html);
 }
 });
 }
 
 
 function updateChatMessage(message)
 {
 var chat = $('#messageId').val();
 var key1 = $('#form_key').val();
 
 $.getJSON("/public/chats/add/?jsoncallback=?",
 {chat: chat, key1: key1},
 function (data)
 {
 if (data.r == 1)
 {
 
 }
 });
 
 }
 
 
 */

function showModal(modalTitle, modalBody)
    {
        $("#modal-general-title").html(modalTitle);
        $("#modal-general-content").html(modalBody);
        //$("#modal-general-buttons").html(data.button);
        //$('#modal-general').modal().trigger('focus');
    }