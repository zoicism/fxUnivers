$(document).ready(function() {
  setInterval(function() {
    jQuery.ajax({
      type: 'POST',
      url: '/php/notif_icon.php',
      data: {notif_userId: notifUserId},
      success: function(response) {
            //var json=$.parseJSON(response);
            //alert(json.last_notif);
            //alert(response);
            if(response>0) {
                $('#notif-bar').show();
                $('#notif-bar').html(response);
            }

            jQuery.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg-bar').show();
                        $('#msg-bar').html(result);
                    }
              }
            });
      }
    });
  }, 2000);
});
