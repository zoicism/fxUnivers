// (c) Neo Abramson <neo@fxunivers.com> //
var userType = sessionStorage.getItem("userType");

window.onload = function() {
    var liveClassRoomId = sessionStorage.getItem("liveClassId");
    if(userType.localeCompare("instructor")==0) {
	this.disabled = true;
	connection.open(liveClassRoomId);
    } else if(userType.localeCompare("student")==0) {
	this.disabled = true;
	connection.join(liveClassRoomId);
    } else {
    }
};
/*
document.getElementById('open-or-join-room').onclick = function() {
    this.disabled = true;
    connection.openOrJoin(document.getElementById('room-id').value);
};*/

// File-sharing, text chat 
document.getElementById('share-file').onclick = function() {
    var fileSelector = new FileSelector();
    fileSelector.selectSingleFile(function(file) {
        connection.send(file);
    });
};
document.getElementById('input-text-chat').onkeyup = function(e) {
    if(e.keyCode != 13) return;
    
    // removing trailing/leading whitespace
    this.value = this.value.replace(/^\s+|\s+$/g, '');
    if (!this.value.length) return;
    
    connection.send(this.value);
    appendDIV(this.value);
    this.value =  '';
};
var chatContainer = document.querySelector('.chat-output');
function appendDIV(event) {
    var div = document.createElement('div');
    div.innerHTML = event.data || event;
    chatContainer.insertBefore(div, chatContainer.firstChild);
    div.tabIndex = 0; div.focus();
    
    document.getElementById('input-text-chat').focus();
}
// RTCMultiCon
var connection = new RTCMultiConnection();
connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
connection.enableFileSharing = true; // by default "false"
connection.session = {
    audio: true,
    video: true,
    data : true
};
connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: true,
    OfferToReceiveVideo: true
};
connection.onstream = function(event) {
    var vidNum = document.getElementById("liveVid").childElementCount;
    if(vidNum==0) {
	document.getElementById("liveVid").appendChild(event.mediaElement);
    } else {
	document.getElementById("liveVidStu").appendChild(event.mediaElement);
	//document.getElementsByTagName("VIDEO")[0].setAttribute("style", "width: 20%");
    }
};


connection.onmessage = appendDIV;
connection.filesContainer = document.getElementById('file-container');
connection.onopen = function() {
    document.getElementById('share-file').disabled      = false;
    document.getElementById('input-text-chat').disabled = false;
};
