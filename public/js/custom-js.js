
$(document).ready(function() {
    // bind event handlers when the page loads.
    $('#newpost').on("input", function(e){
        $('#text-length').text($('#newpost').val().length+'/250');
        if($('#newpost').val().length > 250){
            $('#text-length').css('color','red');
        }
        else{
            $('#text-length').css('color','#636b6f');
        }
    });
    $('#post-edit').on("input", function(e){
        $('#text-length-modal').text($('#post-edit').val().length+'/250');
        if($('#post-edit').val().length > 250){
            $('#text-length-modal').css('color','red');
        }
        else{
            $('#text-length-modal').css('color','#636b6f');
        }
    });

    var postId = 0;
    var contentElement = null;
    $(document).on('click','.edit' ,function(e){
        e.preventDefault();
        contentElement = e.target.parentNode.parentNode.parentNode.parentNode.childNodes[4];
        var postContent = contentElement.textContent;
        if(jQuery.trim(postContent).length == 0){
            contentElement = e.target.parentNode.parentNode.parentNode.parentNode.childNodes[5];
            postContent = contentElement.textContent;
        }
        postId = e.target.parentNode.parentNode.parentNode.parentNode.dataset['postid'];
        //console.log(postContent);
        $('#post-edit').val(jQuery.trim(postContent));
        $('#text-length-modal').text($('#post-edit').val().length+'/250');
        $('#edit-modal').modal();
    });
    
    $(document).on('click','#modal-save', function(e){
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                content: $('#post-edit').val(),
                postId: postId,
                _token: token
            },
            error: function(message){
                //console.log(JSON.stringify(message));
                var errors = message.responseJSON.errors.content;
                var messageContent = '<div class="row"><div class="col-md-12"><div class="alert alert-danger">'+errors+'</div></div></div>';
                $("#modal-message").html(messageContent);
                setTimeout(function(){
                    $('#modal-message .row').remove();
                }, 3000);
                
            },
            success: function(message){
                //console.log(JSON.stringify(message));
                $(contentElement).text(message['new-content']);
                $('#edit-modal').modal('hide');
                var messageContent = '<div class="row"><div class="col-md-12"><div class="alert alert-success">'+message['message']+'</div></div></div>';
                $("#messages").html(messageContent);
            }
        })
        /*.done(function(message){
            
        });*/
    });
    $(document).on('click','.delete', function(e){
        e.preventDefault();
        var parent = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
        postId = e.target.parentNode.parentNode.parentNode.parentNode.dataset['postid'];
        $.ajax({
            method: 'POST',
            url: deleteUrl,
            data:{
                postId: postId,
                _token: token
            }
        })
        .done(function(message){
            var postdiv = document.querySelector('[data-postid="'+postId+'"]');        
            parent.removeChild(postdiv);
            var messageContent = '<div class="row"><div class="col-md-12"><div class="alert alert-success">'+message['message']+'</div></div></div>';
            $("#messages").html(messageContent);
        });
    });
    
    $('#btn-post').on('click', function(e){
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: postUrl,
            data: {
                newpost: $('#newpost').val(),
                postId: postId,
                _token: token
            },
            success: function(message){
                //console.log(JSON.stringify(message));
                var messageContent = '<div class="row"><div class="col-md-12"><div class="alert alert-success">'+message['message']+'</div></div></div>';
                $("#messages").html(messageContent);
                $('.show-post').load('/ #posts-container');
                $("#newpost").val('');
            },
            error: function(message){
            var errors = message.responseJSON.errors.newpost;
            var messageContent = '<div class="row"><div class="col-md-12"><div class="alert alert-danger">'+errors+'</div></div></div>';
            $("#messages").html(messageContent);
            }
        })
    });
});