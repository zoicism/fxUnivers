<?php

session_start();
require('../../../../../register/connect.php');
if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
    
}

require('../../../../../php/get_user.php');

if(isset($_POST['courseId'])) {
    $course_id=$_POST['courseId'];
    $class_id=$_POST['classId'];
    require('../../../../../php/get_course.php');
    require('../../../../../php/get_user_type.php');
}


?>
<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0, user-scalable=no">

	<script src="/js/jquery-3.4.1.min.js"></script>

	<title>fxUniversity</title>
    

	<meta name="author" content="neo">
</head>
<body>
<script src="canvas-designer-widget.js"></script>

<style>
<?php if($user_type!='instructor') {
    echo 'body {
        pointer-events: none;
    }';
}
    ?>
* {
    -webkit-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
input[type=text] {
    -webkit-user-select: initial;
    -moz-user-select: initial;
    -o-user-select: initial;
    -ms-user-select: initial;
    user-select: initial;
}

button, input {
    font-family: Myriad, Arial, Verdana;
    font-weight: normal;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    padding: 4px 12px;
    text-decoration: none;
    color: rgb(27, 26, 26);
    display: inline-block;
    box-shadow: rgb(255, 255, 255) 1px 1px 0px 0px inset;
    text-shadow: none;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0.05, rgb(241, 241, 241)), to(rgb(230, 230, 230)));
    font-size: 20px;
    border: 1px solid red;
    outline:none;
}
button:hover, button:hover, input:focus {
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(5%, rgb(221, 221, 221)), to(rgb(250, 250, 250)));
    border: 1px solid rgb(142, 142, 142);
}
button[disabled], input[disabled] {
    background: rgb(249, 249, 249);
    border: 1px solid rgb(218, 207, 207);
    color: rgb(197, 189, 189);
}

input {
    background: white;
}

.extra-controls {
    position: fixed;
    right: 21%;
}

#room-id {
    width: 55%;
    margin-right: 2px;
}

/* popup box */
.black_overlay {
    display: none;
    position: absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: black;
    z-index:1001;
    -moz-opacity: 0.8;
    opacity:.80;
    filter: alpha(opacity=80);
}
.white_content {
    display: none;
    position: absolute;
    top: 30%;
    left: 40%;
    width: 16%;
    height: 15%;
    padding: 16px;
    border: 10px solid rgb(9, 159, 243);
    background-color: rgba(255, 255, 255, 0.94);
    z-index:1002;
    overflow: hidden;
    border-radius: 5px;
    min-width: 300px;
    min-height: 120px;
}

.white_content hr {
    border-top: 4px solid rgb(9, 159, 243);
    margin: 9px -20px;
}

#btn-undo, #btn-close-undo-popup, #btn-close-dataURL-popup, #btn-close-comments-popup, #btn-getDataURL {
    font-size: 1.2em;
    padding: 2px 9px;
}

#btn-close-undo-popup, #btn-close-dataURL-popup, #btn-close-comments-popup {
    padding: 0 6px;
    border-radius: 50%;
    padding-bottom: 1px;
    color: red;
}

.white_content select {
    font-size: 1.2em;
    border: 1px solid;
    padding: 0;
    outline: none!important;
    border: 1px solid black !important;
    float: left;
}
.white_content select option {
    padding: 2px 5px;
    border-bottom: 1px solid black;
}
.white_content select option:last-child {
    border-bottom: 0;
}

.white_content option:checked, .white_content option[selected] {
    background-color: #06CDFF!important;
    background:linear-gradient(#06CDFF, #06CDFF)!important;
    color: white!important;
}

.white_content select[disabled] {
    background-color: rgba(232, 229, 229, 0.17);
    color: rgb(84, 82, 82);
}

div#comments-popup {
    width: 100%;
    left: 0;
    top: 0;
    height: 100%;
    border: 0;
    padding: 0;
	border-radius: 0;
    overflow: auto;
}

#btn-comments {
	color: red;
	margin-top: 5px;
	font-size: 24px;
	text-shadow: 1px 1px white;
}

#h2-close-popup {
	background: yellow;
	padding: 5px 10px;
	border-bottom: 1px solid red;
	margin: 0;
	color: red;
}
</style>

<div id="widget-container" style="position: fixed;bottom: 0;right: 20%;left: 20%;height: 100%;border: 1px solid black; border-top:0; border-bottom: 0;"></div>

<div id="fade" class="black_overlay"></div>
<div id="action-controls" style="width: 19%; padding: 1%;position: absolute;left:0;">
    <video controls autoplay playsinline style="width: 105%;margin-left: -15px;margin-top: -23px; display: none;"></video>

    <div id="select-tools">
    <h2>Select Tools</h2>
    <input type="checkbox" id="pencil" checked>
    <label for="pencil">pencil</label><br>

    <input type="checkbox" id="marker" checked>
    <label for="marker">marker</label><br>

    <input type="checkbox" id="eraser" checked>
    <label for="eraser">eraser</label><br>

    <input type="checkbox" id="text" checked>
    <label for="text">text</label><br>

    <input type="checkbox" id="image" checked>
    <label for="image">image</label><br>

    <input type="checkbox" id="pdf" checked>
    <label for="pdf">pdf</label><br>

    <input type="checkbox" id="line" checked>
    <label for="line">line</label><br>

    <input type="checkbox" id="arrow" checked>
    <label for="arrow">arrow</label><br>

	<input type="checkbox" id="zoom">
    <label for="zoom">zoom</label><br>

    <input type="checkbox" id="dragSingle" checked>
    <label for="dragSingle">dragSingle</label><br>

    <input type="checkbox" id="dragMultiple" checked>
    <label for="dragMultiple">dragMultiple</label><br>

    <input type="checkbox" id="arc" checked>
    <label for="arc">arc</label><br>

    <input type="checkbox" id="rectangle" checked>
    <label for="rectangle">rectangle</label><br>

    <input type="checkbox" id="quadratic" checked>
    <label for="quadratic">quadratic</label><br>

    <input type="checkbox" id="bezier" checked>
    <label for="bezier">bezier</label><br>

    <input type="checkbox" id="undo" checked>
    <label for="undo">undo</label><br>

    <input type="checkbox" id="lineWidth" checked>
    <label for="lineWidth">lineWidth</label><br>

    <input type="checkbox" id="colorsPicker" checked>
    <label for="colorsPicker">colorsPicker</label><br>

    <input type="checkbox" id="extraOptions" checked>
    <label for="extraOptions">extraOptions</label><br>

    <input type="checkbox" id="code" checked>
    <label for="code">code</label><br><br>
    </div>

    <hr>
    <div>
        Online users: <b id="number-of-connected-users">0</b>

        <br><br>

        <div id="hide-on-datachannel-opened" style="display:none">
            You can open a private WebRTC room to sync dashboard with private users.

            <br><br>

            <input type="text" id="room-id" placeholder="room-id">
            <button id="open-room">Open</button>
        </div>
    </div>
<?php if($user_type=='instructor') { ?>
    <hr>
    <h2>Shortcut Keys</h2>
    ctrl+t (to display text-fonts box)<br>
    ctrl+z (to undo last-single shape)<br>
    ctrl+a (to select all shapes)<br>
    ctrl+c (copy last-selected shape)<br>
    ctrl+v (paste last-copied shape)<br><br>
    ctrl+mousedown (to copy/paste all shapes)
<?php } ?>
</div>

<div class="extra-controls">
    <button id="export-as-image">Export as Image</button>
    <button id="btn-display-undo-popup">Undo</button>
</div>

<div id="light" class="white_content">
    <button id="btn-close-undo-popup" style="float:right;">x</button>

    <select id="undo-options" size="4">
        <option>Last Shape</option>
        <option>All Shapes</option>
        <option>Last Multiple</option>
        <option disabled>Specific Range</option>
    </select>

    <div style="display: none;margin-top: 20px;margin-bottom: 20px;margin-right: 12px;float: right;">
        Digit/Number:<br>
        <input type="text" id="number-of-shapes-to-undo" style="padding: 0;width: 90px;text-align: center;border-radius: 0;margin-top: 6px;">
    </div>

    <br><br><br><br><br>

    <button id="btn-undo" style="float:right;">Undo</button>
</div>

<div id="dataURL-popup" class="white_content">
    <button id="btn-close-dataURL-popup" style="float:right;">x</button>

    <select id="data-url-format" size="4">
        <option>image/png</option>
        <option>image/jpeg</option>
        <option>image/gif</option>
        <option>image/webp</option>
    </select>

		<a id="link-to-image" target="_blank" download="image.png"></a>

    <br><br><br><br><br>

    <button id="btn-getDataURL" style="float:right;">Get DataURL</button>
</div>

<div id="comments-popup" class="white_content">
    <button id="btn-close-comments-popup" style="float:right;">x</button>

		<h2 id="h2-close-popup">Click right-side "x" button to close this popup.</h2>
		<section class="experiment">
        <h2 class="header" id="feedback">Feedback</h2>
        <div>
            <textarea id="message" style="height: 8em; margin: .2em; width: 98%; border: 1px solid rgb(189, 189, 189); outline: none; resize: vertical;" placeholder="Have any message? Suggestions or something went wrong?"></textarea>
        </div>
        <button id="send-message" style="font-size: 1em;">Send Message</button><small style="margin-left:1em;">Enter your email too; if you want "direct" reply!</small>
    </section>
</div>



<script>
document.getElementById('room-id').onkeyup = document.getElementById('room-id').onblur = function() {
    localStorage.setItem('canvas-designer-roomid', this.value);
};

if (localStorage.getItem('canvas-designer-roomid')) {
    document.getElementById('room-id').value = localStorage.getItem('canvas-designer-roomid');
}

window.onload = function() {
    var roomid = '<?php echo $class_id ?>';//document.getElementById('room-id').value;
    //if (!roomid.length) return alert('Please enter roomid.');

    this.disabled = true;

    connection.open(roomid, onOpenRoom);

    this.parentNode.innerHTML = '<a href="#' + roomid + '" target="_blank">Please share this link</a>';
};

var designer = new CanvasDesigner();

// you can place widget.html anywhere
designer.widgetHtmlURL = 'widget.html';
designer.widgetJsURL = 'widget.min.js'

designer.addSyncListener(function(data) {
    connection.send(data);
});

designer.setSelected('pencil');

designer.setTools({
    pencil: true,
    text: true,
    image: true,
    pdf: true,
    eraser: true,
    line: true,
    arrow: true,
    dragSingle: true,
    dragMultiple: true,
    arc: true,
    rectangle: true,
    quadratic: true,
    bezier: true,
    marker: true,
    zoom: true,
    lineWidth: true,
    colorsPicker: true,
    extraOptions: true,
    code: true,
    undo: true
});

designer.appendTo(document.getElementById('widget-container'));

Array.prototype.slice.call(document.getElementById('action-controls').querySelectorAll('input[type=checkbox]')).forEach(function(checkbox) {
    checkbox.onchange = function() {
        designer.destroy();

        designer.addSyncListener(function(data) {
            connection.send(data);
        });

        var tools = {};
        Array.prototype.slice.call(document.getElementById('action-controls').querySelectorAll('input[type=checkbox]')).forEach(function(checkbox2) {
            if (checkbox2.checked) {
                tools[checkbox2.id] = true;
            }
        });
        designer.setTools(tools);
        designer.appendTo(document.getElementById('widget-container'));
    };
});

var undoOptions = document.getElementById('undo-options');

document.getElementById('btn-display-undo-popup').onclick = function() {
    document.getElementById('light').style.display = 'block';
    document.getElementById('fade').style.display = 'block';
};

var txtNumberOfShapesToUndo = document.getElementById('number-of-shapes-to-undo');
txtNumberOfShapesToUndo.onkeyup = function() {
    localStorage.setItem('number-of-shapes-to-undo', txtNumberOfShapesToUndo.value);
}

if (localStorage.getItem('number-of-shapes-to-undo')) {
    txtNumberOfShapesToUndo.value = localStorage.getItem('number-of-shapes-to-undo');
    txtNumberOfShapesToUndo.onkeyup();
}

undoOptions.onchange = function() {
    txtNumberOfShapesToUndo.parentNode.style.display = 'none';

    if (undoOptions.value === 'Specific Range') {
        //
    } else if (undoOptions.value === 'Last Multiple') {
        txtNumberOfShapesToUndo.parentNode.style.display = 'block';
    }

    localStorage.setItem('undo-options', undoOptions.value);
};

undoOptions.onclick = undoOptions.onchange;

if (localStorage.getItem('undo-options')) {
    undoOptions.value = localStorage.getItem('undo-options');
    undoOptions.onchange();
}

document.getElementById('btn-undo').onclick = function() {
    if (undoOptions.value === 'All Shapes') {
        designer.undo('all');
    } else if (undoOptions.value === 'Specific Range') {
        designer.undo({
            specificRange: {
                start: -1,
                end: -1
            }
        });
    } else if (undoOptions.value === 'Last Shape') {
        designer.undo(-1);
    } else if (undoOptions.value === 'Last Multiple') {
        var numberOfLastShapes = txtNumberOfShapesToUndo.value;
        numberOfLastShapes = parseInt(numberOfLastShapes || 0) || 0;
        designer.undo({
            numberOfLastShapes: numberOfLastShapes
        });
    }

    closeUndoPopup();
};

function closeUndoPopup() {
    document.getElementById('light').style.display = 'none';
    document.getElementById('fade').style.display = 'none';

    undoOptions.onchange();
}
document.getElementById('btn-close-undo-popup').onclick = closeUndoPopup;

function closeDataURLPopup() {
    document.getElementById('dataURL-popup').style.display = 'none';
    document.getElementById('fade').style.display = 'none';

    dataURLFormat.onchange();
}
document.getElementById('btn-close-dataURL-popup').onclick = closeDataURLPopup;

document.getElementById('export-as-image').onclick = function() {
    linkToImage.innerHTML = linkToImage.href = linkToImage.style = '';

    document.getElementById('dataURL-popup').style.display = 'block';
    document.getElementById('fade').style.display = 'block';

    getDataURL();
};

function getDataURL(callback) {
    callback = callback || function() {};
    var format = dataURLFormat.value;
    designer.toDataURL(format || 'image/png', function(dataURL) {
        linkToImage.style = 'margin-left: 10px;display: block;text-align: center;margin-bottom: -50px;';
        linkToImage.href = dataURL;
        linkToImage.innerHTML = 'Click to Download Image';
        linkToImage.download = 'image.' + (format || 'image/png').split('/')[1];

        callback(dataURL, format);
    });
}

var dataURLFormat = document.getElementById('data-url-format');
var linkToImage = document.getElementById('link-to-image');

dataURLFormat.onchange = function() {
    localStorage.setItem('data-url-format', dataURLFormat.value);
    getDataURL();
};
dataURLFormat.onclick = dataURLFormat.onchange;

if (localStorage.getItem('data-url-format')) {
    dataURLFormat.value = localStorage.getItem('data-url-format');
    dataURLFormat.onchange();
}

document.getElementById('btn-getDataURL').onclick = function() {
    getDataURL(function(dataURL, format) {
        window.open(dataURL);
    });

    // closeDataURLPopup();
};

document.getElementById('btn-close-comments-popup').onclick = function() {
    document.getElementById('comments-popup').style.display = 'none';
    document.getElementById('fade').style.display = 'none';

    dataURLFormat.onchange();
};

function showCommentsPopup(e) {
    document.getElementById('comments-popup').style.display = 'block';
    document.getElementById('fade').style.display = 'block';
}
document.getElementById('btn-comments').onclick = showCommentsPopup;
if (location.hash.length && location.hash.indexOf('comment') !== -1) {
    showCommentsPopup();
}
</script>

<script src="RTCMultiConnection.min.js"></script>
<script src="socket.io.js"></script>

<script>
var connection = new RTCMultiConnection();

connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
connection.socketMessageEvent = 'canvas-designer';

connection.enableFileSharing = false;
connection.session = {
    audio: true,
    video: true,
    data: true
};
connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: true,
    OfferToReceiveVideo: true
};
connection.dontCaptureUserMedia = true;
if (location.hash.replace('#', '').length) {
    var roomid = location.hash.replace('#', '');
    connection.join(roomid);
}

connection.onUserStatusChanged = function(event) {
    var infoBar = document.getElementById('hide-on-datachannel-opened');
    if (event.status == 'online') {
        infoBar.innerHTML = event.userid + ' is <b>online</b>.';
    }

    if (event.status == 'offline') {
        infoBar.innerHTML = event.userid + ' is <b>offline</b>.';
    }

    numberOfConnectedUsers.innerHTML = connection.getAllParticipants().length;
};

var numberOfConnectedUsers = document.getElementById('number-of-connected-users');
connection.onopen = function(event) {
    var infoBar = document.getElementById('hide-on-datachannel-opened');
    infoBar.innerHTML = '<b>' + event.userid + '</b> is ready to collaborate with you.';

    if (designer.pointsLength <= 0) {
        // make sure that remote user gets all drawings synced.
        setTimeout(function() {
            connection.send('plz-sync-points');
        }, 1000);
    }

    numberOfConnectedUsers.innerHTML = connection.getAllParticipants().length;

    if(connection.isInitiator) {
        setTimeout(function() {
            designer.renderStream();
        }, 1000);
    }
};

connection.onclose = connection.onerror = connection.onleave = function() {
    numberOfConnectedUsers.innerHTML = connection.getAllParticipants().length;
};

connection.onmessage = function(event) {
    if (event.data === 'plz-sync-points') {
        designer.sync();
        return;
    }

    designer.syncData(event.data);
};
</script>

<script src="dev/webrtc-handler.js"></script>
<script>
function onOpenRoom() {
    // capture canvas-2d stream
    // and share in realtime using RTCPeerConnection.addStream
    // requires: dev/webrtc-handler.js
    designer.captureStream(function(stream) {
        connection.attachStreams = [stream];
        connection.onstream({
            stream: stream
        });
    });
}

var video = document.querySelector('video');

connection.onstream = function(event) {
    if (connection.isInitiator && event.mediaElement) return;

    video.style.display = '';
    video.srcObject = event.stream;

    document.getElementById('select-tools').style.display = 'none';
};

connection.onstreamended = function() {
    video.src = null;
    video.style.display = 'none';
};
</script>

<?php if($user_type=='instructor') { ?>
<script>
 $.ajax({
     url: '/php/set_wb_db_on.php',
     type: 'POST',
     data: {classId: '<?php echo $class_id ?>'},
     success: function(response) {
	 console.log(response);
     }
 });
 
</script>

<script>
 //window.addEventListener('beforeunload', function(event) {
 window.addEventListener('unload', function(event) {
     jQuery.ajax({
	 url: '/php/set_wb_db_off.php',
	 type: 'POST',
	 data: {classId: '<?php echo $class_id ?>'},
	 success: function(response) {
	     //console.log(response);
	     return response;
	 }
     });
 });
</script>

<script>
 window.addEventListener('beforeunload', function(event) {
     jQuery.ajax({
	 url: '/php/set_wb_db_off.php',
	 type: 'POST',
	 data: {classId: '<?php echo $class_id ?>'},
	 success: function(response) {
	     //console.log(response);
	     return response;
	 }
     });
 });
</script>
<?php } ?>


<script src="common.js" async></script>
</body>
</html>
