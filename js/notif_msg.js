$(document).ready(function() {
        
    if(!Notification) {
	//console.log('Browser does not support web notif.');
    } else {
	if(Notification.permission !== "granted") {
	    Notification.requestPermission();
	}
    }

    var userId = $('#notmsg').attr('nmuid');

    
    setInterval(function() {
	jQuery.ajax({
	    type: 'POST',
	    url: '/php/notif_icon.php',
	    data: {notif_userId: userId},
	    success: function(response) {
		if(response>0) {
                    $('#notif-bar').show();
                    $('#notif-bar').html(response);
		}
		
		jQuery.ajax({
		    type: 'POST',
		    url: '/php/msg_icon.php',
		    data: {msg_userId: userId},
		    dataType: 'json',
		    success: function(result) {
			//console.log(result);

			var msgCount = result[0];
			var lastText = result[1];
			var lastFrom = result[2];
			var msgTime = result[3];

			//console.log(msgCount);
			if(msgCount>0) {
			    //console.log('msg count > 0');
			    $('#msg-bar').show();
			    $('#msg-bar').html(msgCount);

			    if(msgTime<5) {
				//console.log('last msg < 5s ago');
				var newMsgNotif = new Notification('New Message from @'+lastFrom, {
				    icon: '/images/icons/toolbar/msg.png',
				    body: lastText
				});

				
				newMsgNotif.onclick = function() {
				    //console.log('clicked');
				    window.open('/msg/'+lastFrom);
				    newMsgNotif.close();
				}
			    }
			}
			
//			if(msgCount>0) {
  //                        $('#msg-bar').show();
   //                       $('#msg-bar').html(msgCount);
			    
			    /*var notif = new Notification('title', {
				icon: '/images/icons/toolbar/msg.png',
				body: 'message body'
			    });*/
//			}
  		    }
		});
	    }
	});
    }, 4000);

});
