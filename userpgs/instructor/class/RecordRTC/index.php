<?php
if(isset($_GET['classId'])) $class_id = $_GET['classId'];
?>

<!DOCTYPE html>
<html lang="en">

    <head>
	<title>fxUniversity Record</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/icons.css">
	<link rel="stylesheet" href="/css/logo.css">
	<link href="/css/getHTMLMediaElement.css" rel="stylesheet">

	<style>

	 article {
	     padding:20px;
	     background:white;
	     border: 1px solid black;
	     margin:20px;
	 }
         li {
             border-bottom: 1px solid rgb(189, 189, 189);
             border-left: 1px solid rgb(189, 189, 189);
             padding: .5em;
         }
         label {
             display: inline-block;
             width: 8em;
         }

         h1 span {
             background: yellow;
             border: 2px solid #8e1515;
             padding: 2px 8px;
             margin: 2px 5px;
             border-radius: 7px;
             color: #8e1515;
             display: inline-block;
         }

         .recordrtc button {
             font-size: inherit;
         }

         .recordrtc button, .recordrtc select {
             vertical-align: middle;
             line-height: 1;
             padding: 2px 5px;
             height: auto;
             font-size: inherit;
             margin: 0;
         }

         .recordrtc, .recordrtc .header {
             display: block;
             text-align: center;
             padding-top: 0;
         }

         .recordrtc video, .recordrtc img {
             max-width: 100%!important;
             vertical-align: top;
         }

         .recordrtc audio {
             vertical-align: bottom;
         }

         .recordrtc option[disabled] {
             display: none;
         }

         .recordrtc select {
             font-size: 17px;
         }
	</style>

	<script src="/js/jquery-3.4.1.min.js"></script>

	<script src="RecordRTC.js"></script>
	
	<!-- web streams API polyfill to support Firefox -->
	<!--<script src="https://unpkg.com/@mattiasbuelens/web-streams-polyfill/dist/polyfill.min.js"></script>-->
	<script src="/js/webrtc/polyfill.min.js"></script>

	<!-- ../libs/DBML.js to fix video seeking issues -->
	<!--<script src="https://www.webrtc-experiment.com/EBML.js"></script>-->
	<script src="/js/webrtc/EBML.js"></script>
	
	<!-- for Edge/FF/Chrome/Opera/etc. getUserMedia support -->
	<!--<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
	     <script src="https://www.webrtc-experiment.com/DetectRTC.js"> </script>-->
	<script src="../DetectRTC/DetectRTC.js"></script>
	<script src="../js/adapter-latest.js"></script>
	<script src="../RecordRTC/RecordRTC.js"></script>
	
	<!-- video element -->
	
	<!--<script src="https://www.webrtc-experiment.com/getHTMLMediaElement.js"></script>-->
	<script src="/js/webrtc/getHTMLMediaElement.js"></script>
    </head>

    <body>
	<article>
            <header style="text-align: center;">
		<h1>
                    fxUniversity Record
		</h1>

            </header>



	    <div class="add-box" id="video-add-box"><input type="checkbox" class="toggle-btn" id="video-audio-r-toggle">Video & Audio Record</div>
	    <div class="add-box" id="screen-add-box"><input type="checkbox" class="toggle-btn" id="screen-audio-r-toggle">Screen & Audio Record</div>
	    

            <section class="experiment recordrtc">
		<div style="display:none">
		    <h2 class="header" style="margin: 0;">
			<select class="recording-media">
			    <option value="record-audio-plus-video">Microphone+Camera</option>
			    <option value="record-audio">Microphone</option>
			    <option value="record-screen">Full Screen</option>
			    <option value="record-audio-plus-screen">Microphone+Screen</option>
			</select>

			<span style="font-size: 15px;">into</span>

			<select class="media-container-format">
			    <option>default</option>
			    <option>vp8</option>
			    <option>vp9</option>
			    <option>h264</option>
			    <option>mkv</option>
			    <option>opus</option>
			    <option>ogg</option>
			    <option>pcm</option>
			    <option>gif</option>
			    <option>whammy</option>
			    <option>WebAssembly</option>
			</select>

			<input type="checkbox" id="chk-timeSlice" style="margin:0;width:auto;" title="Use intervals based recording">
			<label for="chk-timeSlice" style="font-size: 15px;margin:0;width: auto;cursor: pointer;-webkit-user-select:none;user-select:none;" title="Use intervals based recording">Use timeSlice?</label>

			<br>

			<button id="btn-start-recording">Start Recording</button>
			

			<div style="display: inline-block;">
			    <input type="checkbox" id="chk-fixSeeking" style="margin:0;width:auto;" title="Fix video seeking issues?">
			    <label for="chk-fixSeeking" style="font-size: 15px;margin:0;width: auto;cursor: pointer;-webkit-user-select:none;user-select:none;" title="Fix video seeking issues?">Fix Seeking Issues?</label>
			</div>

			<hr style="border-top: 0;border-bottom: 1px solid rgb(189, 189, 189);margin: 4px -12px;margin-top: 8px;">
			<select class="media-resolutions">
			    <option value="default">Default resolutions</option>
			    <option value="1920x1080">1080p</option>
			    <option value="1280x720">720p</option>
			    <option value="640x480">480p</option>
			    <option value="3840x2160">4K Ultra HD (3840x2160)</option>
			</select>

			<select class="media-framerates">
			    <option value="default">Default framerates</option>
			    <option value="5">5 fps</option>
			    <option value="15">15 fps</option>
			    <option value="24">24 fps</option>
			    <option value="30">30 fps</option>
			    <option value="60">60 fps</option>
			</select>

			<select class="media-bitrates">
			    <option value="default">Default bitrates</option>
			    <option value="8000000000">1 GB bps</option>
			    <option value="800000000">100 MB bps</option>
			    <option value="8000000">1 MB bps</option>
			    <option value="800000">100 KB bps</option>
			    <option value="8000">1 KB bps</option>
			    <option value="800">100 Bytes bps</option>
			</select>
		    </h2>
		</div>
		<button id="new-rec-btn" style="display:none;font-size:15px;" >Set up New Recording</button>
		<button id="btn-pause-recording" style="display: none; font-size: 15px;">Pause</button>
		<button id="stop-button" style="display:none; font-size:15px;">Stop Recording</button>
		<button id="stop-screen-button" style="display:none; font-size:15px;">Stop Recording</button>
		<div style="text-align: center; display: none;">
		    
                    <button id="save-to-disk">Download</button>
                    <button id="upload-to-php">Upload as Session Video</button>
                    <button id="open-new-tab">Open in New Tab</button>

                    <div style="margin-top: 10px; display:none;">
			<span id="signinButton" class="pre-sign-in">
			    <span
				class="g-signin"
				data-callback="signinCallback"
				data-clientid="41556190767-115ifahd55lk4ln5pop4jus55cr4l7oh.apps.googleusercontent.com"
				data-cookiepolicy="single_host_origin"
				data-scope="https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube">
			    </span>
			</span>

			<button id="upload-to-youtube" style="vertical-align:top;">Upload to YouTube</button>
                    </div>
		</div>

		<div style="margin-top: 10px;" id="recording-player"></div>
            </section>

            <script>
             (function() {
                 var params = {},
                     r = /([^&=]+)=?([^&]*)/g;

                 function d(s) {
                     return decodeURIComponent(s.replace(/\+/g, ' '));
                 }

                 var match, search = window.location.search;
                 while (match = r.exec(search.substring(1))) {
                     params[d(match[1])] = d(match[2]);

                     if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                         params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                     }
                 }

                 window.params = params;
             })();

             function addStreamStopListener(stream, callback) {
                 stream.addEventListener('ended', function() {
                     callback();
                     callback = function() {};
                 }, false);
                 stream.addEventListener('inactive', function() {
                     callback();
                     callback = function() {};
                 }, false);
                 stream.getTracks().forEach(function(track) {
                     track.addEventListener('ended', function() {
                         callback();
                         callback = function() {};
                     }, false);
                     track.addEventListener('inactive', function() {
                         callback();
                         callback = function() {};
                     }, false);
                 });
             }
            </script>

            <script>
             var video = document.createElement('video');
             video.controls = false;
             var mediaElement = getHTMLMediaElement(video, {
                 title: 'Recording status: inactive',
                 buttons: ['full-screen'/*, 'take-snapshot'*/],
                 showOnMouseEnter: false,
                 width: 360,
                 onTakeSnapshot: function() {
                     var canvas = document.createElement('canvas');
                     canvas.width = mediaElement.clientWidth;
                     canvas.height = mediaElement.clientHeight;

                     var context = canvas.getContext('2d');
                     context.drawImage(recordingPlayer, 0, 0, canvas.width, canvas.height);

                     window.open(canvas.toDataURL('image/png'));
                 }
             });
             document.getElementById('recording-player').appendChild(mediaElement);

             var div = document.createElement('section');
             mediaElement.media.parentNode.appendChild(div);
             mediaElement.media.muted = false;
             mediaElement.media.autoplay = true;
             mediaElement.media.playsinline = true;
             div.appendChild(mediaElement.media);
             
             var recordingPlayer = mediaElement.media;
             var recordingMedia = document.querySelector('.recording-media');
             var mediaContainerFormat = document.querySelector('.media-container-format');
             var mimeType = 'video/webm';
             var fileExtension = 'webm';
             var type = 'video';
             var recorderType;
             var defaultWidth;
             var defaultHeight;

             var btnStartRecording = document.querySelector('#btn-start-recording');

             window.onbeforeunload = function() {
                 btnStartRecording.disabled = false;
                 recordingMedia.disabled = false;
                 mediaContainerFormat.disabled = false;

                 chkFixSeeking.parentNode.style.display = 'inline-block';
             };

             btnStartRecording.onclick = function(event) {
                 var button = btnStartRecording;

                 if(button.innerHTML === 'Stop Recording') {
                     btnPauseRecording.style.display = 'none';
                     button.disabled = true;
                     button.disableStateWaiting = true;
                     setTimeout(function() {
                         button.disabled = false;
                         button.disableStateWaiting = false;
                     }, 2000);

                     button.innerHTML = 'Start Recording';

                     function stopStream() {
                         if(button.stream && button.stream.stop) {
                             button.stream.stop();
                             button.stream = null;
                         }

                         if(button.stream instanceof Array) {
                             button.stream.forEach(function(stream) {
                                 stream.stop();
                             });
                             button.stream = null;
                         }

                         videoBitsPerSecond = null;
                         var html = 'Recording status: stopped';
                         html += '<br>Size: ' + bytesToSize(button.recordRTC.getBlob().size);
                         recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = html;
                     }

                     if(button.recordRTC) {
                         if(button.recordRTC.length) {
                             button.recordRTC[0].stopRecording(function(url) {
                                 if(!button.recordRTC[1]) {
                                     button.recordingEndedCallback(url);
                                     stopStream();

                                     saveToDiskOrOpenNewTab(button.recordRTC[0]);
                                     return;
                                 }

                                 button.recordRTC[1].stopRecording(function(url) {
                                     button.recordingEndedCallback(url);
                                     stopStream();
                                 });
                             });
                         }
                         else {
                             button.recordRTC.stopRecording(function(url) {
                                 if(button.blobs && button.blobs.length) {
                                     var blob = new File(button.blobs, getFileName(fileExtension), {
                                         type: mimeType
                                     });
                                     
                                     button.recordRTC.getBlob = function() {
                                         return blob;
                                     };

                                     url = URL.createObjectURL(blob);
                                 }

                                 if(chkFixSeeking.checked === true) {
                                     // to fix video seeking issues
                                     getSeekableBlob(button.recordRTC.getBlob(), function(seekableBlob) {
                                         button.recordRTC.getBlob = function() {
                                             return seekableBlob;
                                         };

                                         url = URL.createObjectURL(seekableBlob);

                                         button.recordingEndedCallback(url);
                                         saveToDiskOrOpenNewTab(button.recordRTC);
                                         stopStream();
                                     })
                                     return;
                                 }

                                 button.recordingEndedCallback(url);
                                 saveToDiskOrOpenNewTab(button.recordRTC);
                                 stopStream();
                             });
                         }
                     }

                     return;
                 }

                 if(!event) return;

                 button.disabled = true;

                 var commonConfig = {
                     onMediaCaptured: function(stream) {
                         button.stream = stream;
                         if(button.mediaCapturedCallback) {
                             button.mediaCapturedCallback();
                         }

                         button.innerHTML = 'Stop Recording';
                         button.disabled = false;

                         chkFixSeeking.parentNode.style.display = 'none';
                     },
                     onMediaStopped: function() {
                         button.innerHTML = 'Start Recording';

                         if(!button.disableStateWaiting) {
                             button.disabled = false;
                         }

                         chkFixSeeking.parentNode.style.display = 'inline-block';
                     },
                     onMediaCapturingFailed: function(error) {
                         console.error('onMediaCapturingFailed:', error);

                         if(error.toString().indexOf('no audio or video tracks available') !== -1) {
                             alert('RecordRTC failed to start because there are no audio or video tracks available.');
                         }
                         
                         if(error.name === 'PermissionDeniedError' && DetectRTC.browser.name === 'Firefox') {
                             alert('Firefox requires version >= 52. Firefox also requires HTTPs.');
                         }

                         commonConfig.onMediaStopped();
                     }
                 };

                 if(mediaContainerFormat.value === 'h264') {
                     mimeType = 'video/webm\;codecs=h264';
                     fileExtension = 'mp4';

                     // video/mp4;codecs=avc1    
                     if(isMimeTypeSupported('video/mpeg')) {
                         mimeType = 'video/mpeg';
                     }
                 }

                 if(mediaContainerFormat.value === 'mkv' && isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
                     mimeType = 'video/x-matroska;codecs=avc1';
                     fileExtension = 'mkv';
                 }

                 if(mediaContainerFormat.value === 'vp8' && isMimeTypeSupported('video/webm\;codecs=vp8')) {
                     mimeType = 'video/webm\;codecs=vp8';
                     fileExtension = 'webm';
                     recorderType = null;
                     type = 'video';
                 }

                 if(mediaContainerFormat.value === 'vp9' && isMimeTypeSupported('video/webm\;codecs=vp9')) {
                     mimeType = 'video/webm\;codecs=vp9';
                     fileExtension = 'webm';
                     recorderType = null;
                     type = 'video';
                 }

                 if(mediaContainerFormat.value === 'pcm') {
                     mimeType = 'audio/wav';
                     fileExtension = 'wav';
                     recorderType = StereoAudioRecorder;
                     type = 'audio';
                 }

                 if(mediaContainerFormat.value === 'opus' || mediaContainerFormat.value === 'ogg') {
                     if(isMimeTypeSupported('audio/webm')) {
                         mimeType = 'audio/webm';
                         fileExtension = 'webm'; // webm
                     }

                     if(isMimeTypeSupported('audio/ogg')) {
                         mimeType = 'audio/ogg; codecs=opus';
                         fileExtension = 'ogg'; // ogg
                     }

                     recorderType = null;
                     type = 'audio';
                 }

                 if(mediaContainerFormat.value === 'whammy') {
                     mimeType = 'video/webm';
                     fileExtension = 'webm';
                     recorderType = WhammyRecorder;
                     type = 'video';
                 }

                 if(mediaContainerFormat.value === 'WebAssembly') {
                     mimeType = 'video/webm';
                     fileExtension = 'webm';
                     recorderType = WebAssemblyRecorder;
                     type = 'video';
                 }

                 if(mediaContainerFormat.value === 'gif') {
                     mimeType = 'image/gif';
                     fileExtension = 'gif';
                     recorderType = GifRecorder;
                     type = 'gif';
                 }

                 if(mediaContainerFormat.value === 'default') {
                     mimeType = 'video/webm';
                     fileExtension = 'webm';
                     recorderType = null;
                     type = 'video';
                 }

                 if(recordingMedia.value === 'record-audio') {
                     captureAudio(commonConfig);

                     button.mediaCapturedCallback = function() {
                         var options = {
                             type: type,
                             mimeType: mimeType,
                             leftChannel: params.leftChannel || false,
                             disableLogs: params.disableLogs || false
                         };

                         if(params.sampleRate) {
                             options.sampleRate = parseInt(params.sampleRate);
                         }

                         if(params.bufferSize) {
                             options.bufferSize = parseInt(params.bufferSize);
                         }

                         if(recorderType) {
                             options.recorderType = recorderType;
                         }

                         if(videoBitsPerSecond) {
                             options.videoBitsPerSecond = videoBitsPerSecond;
                         }

                         if(DetectRTC.browser.name === 'Edge') {
                             options.numberOfAudioChannels = 1;
                         }

                         options.ignoreMutedMedia = false;
                         button.recordRTC = RecordRTC(button.stream, options);

                         button.recordingEndedCallback = function(url) {
                             setVideoURL(url);
                         };

                         button.recordRTC.startRecording();
                         btnPauseRecording.style.display = '';
			 
                     };
                 }

                 if(recordingMedia.value === 'record-audio-plus-video') {
                     captureAudioPlusVideo(commonConfig);

                     button.mediaCapturedCallback = function() {
                         if(typeof MediaRecorder === 'undefined') { // opera or chrome etc.
                             button.recordRTC = [];

                             if(!params.bufferSize) {
                                 // it fixes audio issues whilst recording 720p
                                 params.bufferSize = 16384;
                             }

                             var options = {
                                 type: 'audio', // hard-code to set "audio"
                                 leftChannel: params.leftChannel || false,
                                 disableLogs: params.disableLogs || false,
                                 video: recordingPlayer
                             };

                             if(params.sampleRate) {
                                 options.sampleRate = parseInt(params.sampleRate);
                             }

                             if(params.bufferSize) {
                                 options.bufferSize = parseInt(params.bufferSize);
                             }

                             if(params.frameInterval) {
                                 options.frameInterval = parseInt(params.frameInterval);
                             }

                             if(recorderType) {
                                 options.recorderType = recorderType;
                             }

                             if(videoBitsPerSecond) {
                                 options.videoBitsPerSecond = videoBitsPerSecond;
                             }

                             options.ignoreMutedMedia = false;
                             var audioRecorder = RecordRTC(button.stream, options);

                             options.type = type;
                             var videoRecorder = RecordRTC(button.stream, options);

                             // to sync audio/video playbacks in browser!
                             videoRecorder.initRecorder(function() {
                                 audioRecorder.initRecorder(function() {
                                     audioRecorder.startRecording();
                                     videoRecorder.startRecording();
                                     btnPauseRecording.style.display = '';
                                 });
                             });

                             button.recordRTC.push(audioRecorder, videoRecorder);

                             button.recordingEndedCallback = function() {
                                 var audio = new Audio();
                                 audio.src = audioRecorder.toURL();
                                 audio.controls = true;
                                 audio.autoplay = true;

                                 recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                                 recordingPlayer.parentNode.appendChild(audio);

                                 if(audio.paused) audio.play();
                             };
                             return;
                         }

                         var options = {
                             type: type,
                             mimeType: mimeType,
                             disableLogs: params.disableLogs || false,
                             getNativeBlob: false, // enable it for longer recordings
                             video: recordingPlayer
                         };

                         if(recorderType) {
                             options.recorderType = recorderType;

                             if(recorderType == WhammyRecorder || recorderType == GifRecorder || recorderType == WebAssemblyRecorder) {
                                 options.canvas = options.video = {
                                     width: defaultWidth || 320,
                                     height: defaultHeight || 240
                                 };
                             }
                         }

                         if(videoBitsPerSecond) {
                             options.videoBitsPerSecond = videoBitsPerSecond;
                         }

                         if(timeSlice && typeof MediaRecorder !== 'undefined') {
                             options.timeSlice = timeSlice;
                             button.blobs = [];
                             options.ondataavailable = function(blob) {
                                 button.blobs.push(blob);
                             };
                         }

                         options.ignoreMutedMedia = false;
                         button.recordRTC = RecordRTC(button.stream, options);

                         button.recordingEndedCallback = function(url) {
                             setVideoURL(url);
                         };

                         button.recordRTC.startRecording();
                         btnPauseRecording.style.display = '';
                         recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = '<img src="https://www.webrtc-experiment.com/images/progress.gif">';
                     };
                 }

                 if(recordingMedia.value === 'record-screen') {
                     captureScreen(commonConfig);

                     button.mediaCapturedCallback = function() {
                         var options = {
                             type: type,
                             mimeType: mimeType,
                             disableLogs: params.disableLogs || false,
                             getNativeBlob: false, // enable it for longer recordings
                             video: recordingPlayer
                         };

                         if(recorderType) {
                             options.recorderType = recorderType;

                             if(recorderType == WhammyRecorder || recorderType == GifRecorder || recorderType == WebAssemblyRecorder) {
                                 options.canvas = options.video = {
                                     width: defaultWidth || 320,
                                     height: defaultHeight || 240
                                 };
                             }
                         }

                         if(videoBitsPerSecond) {
                             options.videoBitsPerSecond = videoBitsPerSecond;
                         }

                         options.ignoreMutedMedia = false;
                         button.recordRTC = RecordRTC(button.stream, options);

                         button.recordingEndedCallback = function(url) {
                             setVideoURL(url);
                         };

                         button.recordRTC.startRecording();
                         btnPauseRecording.style.display = '';
                     };
                 }

                 // note: audio+tab is supported in Chrome 50+
                 // todo: add audio+tab recording
                 if(recordingMedia.value === 'record-audio-plus-screen') {
                     captureAudioPlusScreen(commonConfig);

                     button.mediaCapturedCallback = function() {
                         var options = {
                             type: type,
                             mimeType: mimeType,
                             disableLogs: params.disableLogs || false,
                             getNativeBlob: false, // enable it for longer recordings
                             video: recordingPlayer
                         };

                         if(recorderType) {
                             options.recorderType = recorderType;

                             if(recorderType == WhammyRecorder || recorderType == GifRecorder || recorderType == WebAssemblyRecorder) {
                                 options.canvas = options.video = {
                                     width: defaultWidth || 320,
                                     height: defaultHeight || 240
                                 };
                             }
                         }

                         if(videoBitsPerSecond) {
                             options.videoBitsPerSecond = videoBitsPerSecond;
                         }

                         options.ignoreMutedMedia = false;
                         button.recordRTC = RecordRTC(button.stream, options);

                         button.recordingEndedCallback = function(url) {
                             setVideoURL(url);
                         };

                         button.recordRTC.startRecording();
                         btnPauseRecording.style.display = '';
                     };
                 }
             };

             function captureVideo(config) {
                 captureUserMedia({video: true}, function(videoStream) {
                     config.onMediaCaptured(videoStream);

                     addStreamStopListener(videoStream, function() {
                         config.onMediaStopped();
                     });
                 }, function(error) {
                     config.onMediaCapturingFailed(error);
                 });
             }

             function captureAudio(config) {
                 captureUserMedia({audio: true}, function(audioStream) {
                     config.onMediaCaptured(audioStream);

                     addStreamStopListener(audioStream, function() {
                         config.onMediaStopped();
                     });
                 }, function(error) {
                     config.onMediaCapturingFailed(error);
                 });
             }

             function captureAudioPlusVideo(config) {
                 captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
                     config.onMediaCaptured(audioVideoStream);

                     if(audioVideoStream instanceof Array) {
                         audioVideoStream.forEach(function(stream) {
                             addStreamStopListener(stream, function() {
                                 config.onMediaStopped();
                             });
                         });
                         return;
                     }

                     addStreamStopListener(audioVideoStream, function() {
                         config.onMediaStopped();
                     });
                 }, function(error) {
                     config.onMediaCapturingFailed(error);
                 });
             }

             var MY_DOMAIN = 'fxunivers.com';

             function isMyOwnDomain() {
                 //return document.domain.indexOf(MY_DOMAIN) !== -1;
		 return 0;
             }

             function isLocalHost() {
                 // "chrome.exe" --enable-usermedia-screen-capturing
                 // or firefox => about:config => "media.getusermedia.screensharing.allowed_domains" => add "localhost"
                 return document.domain === 'localhost' || document.domain === '127.0.0.1';
             }

             var videoBitsPerSecond;

             function setVideoBitrates() {
                 var select = document.querySelector('.media-bitrates');
                 var value = select.value;

                 if(value == 'default') {
                     videoBitsPerSecond = null;
                     return;
                 }

                 videoBitsPerSecond = parseInt(value);
             }

             function getFrameRates(mediaConstraints) {
                 if(!mediaConstraints.video) {
                     return mediaConstraints;
                 }

                 var select = document.querySelector('.media-framerates');
                 var value = select.value;

                 if(value == 'default') {
                     return mediaConstraints;
                 }

                 value = parseInt(value);

                 if(DetectRTC.browser.name === 'Firefox') {
                     mediaConstraints.video.frameRate = value;
                     return mediaConstraints;
                 }

                 if(!mediaConstraints.video.mandatory) {
                     mediaConstraints.video.mandatory = {};
                     mediaConstraints.video.optional = [];
                 }

                 var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;
                 if(isScreen) {
                     mediaConstraints.video.mandatory.maxFrameRate = value;
                 }
                 else {
                     mediaConstraints.video.mandatory.minFrameRate = value;
                 }

                 return mediaConstraints;
             }

             function setGetFromLocalStorage(selectors) {
                 selectors.forEach(function(selector) {
                     var storageItem = selector.replace(/\.|#/g, '');
                     if(localStorage.getItem(storageItem)) {
                         document.querySelector(selector).value = localStorage.getItem(storageItem);
                     }

                     addEventListenerToUploadLocalStorageItem(selector, ['change', 'blur'], function() {
                         localStorage.setItem(storageItem, document.querySelector(selector).value);
                     });
                 });
             }

             function addEventListenerToUploadLocalStorageItem(selector, arr, callback) {
                 arr.forEach(function(event) {
                     document.querySelector(selector).addEventListener(event, callback, false);
                 });
             }

             setGetFromLocalStorage(['.media-resolutions', '.media-framerates', '.media-bitrates', '.recording-media', '.media-container-format']);

             function getVideoResolutions(mediaConstraints) {
                 if(!mediaConstraints.video) {
                     return mediaConstraints;
                 }

                 var select = document.querySelector('.media-resolutions');
                 var value = select.value;

                 if(value == 'default') {
                     return mediaConstraints;
                 }

                 value = value.split('x');

                 if(value.length != 2) {
                     return mediaConstraints;
                 }

                 defaultWidth = parseInt(value[0]);
                 defaultHeight = parseInt(value[1]);

                 if(DetectRTC.browser.name === 'Firefox') {
                     mediaConstraints.video.width = defaultWidth;
                     mediaConstraints.video.height = defaultHeight;
                     return mediaConstraints;
                 }

                 if(!mediaConstraints.video.mandatory) {
                     mediaConstraints.video.mandatory = {};
                     mediaConstraints.video.optional = [];
                 }

                 var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;

                 if(isScreen) {
                     mediaConstraints.video.mandatory.maxWidth = defaultWidth;
                     mediaConstraints.video.mandatory.maxHeight = defaultHeight;
                 }
                 else {
                     mediaConstraints.video.mandatory.minWidth = defaultWidth;
                     mediaConstraints.video.mandatory.minHeight = defaultHeight;
                 }

                 return mediaConstraints;
             }

             function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                 if(mediaConstraints.video == true) {
                     mediaConstraints.video = {};
                 }

                 setVideoBitrates();

                 mediaConstraints = getVideoResolutions(mediaConstraints);
                 mediaConstraints = getFrameRates(mediaConstraints);

                 var isBlackBerry = !!(/BB10|BlackBerry/i.test(navigator.userAgent || ''));
                 if(isBlackBerry && !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia)) {
                     navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                     navigator.getUserMedia(mediaConstraints, successCallback, errorCallback);
                     return;
                 }

                 navigator.mediaDevices.getUserMedia(mediaConstraints).then(function(stream) {
                     successCallback(stream);

                     setVideoURL(stream, true);
                 }).catch(function(error) {
                     if(error && (error.name === 'ConstraintNotSatisfiedError' || error.name === 'OverconstrainedError')) {
                         alert('Your camera or browser does NOT supports selected resolutions or frame-rates. \n\nPlease select "default" resolutions.');
                     }
                     else if(error && error.message) {
                         alert(error.message);
                     }
                     else {
                         alert('Unable to make getUserMedia request. Please check browser console logs.');
                     }

                     errorCallback(error);
                 });
             }

             function setMediaContainerFormat(arrayOfOptionsSupported) {
                 var options = Array.prototype.slice.call(
                     mediaContainerFormat.querySelectorAll('option')
                 );

                 var localStorageItem;
                 if(localStorage.getItem('media-container-format')) {
                     localStorageItem = localStorage.getItem('media-container-format');
                 }

                 var selectedItem;
                 options.forEach(function(option) {
                     option.disabled = true;

                     if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                         option.disabled = false;

                         if(localStorageItem && arrayOfOptionsSupported.indexOf(localStorageItem) != -1) {
                             if(option.value != localStorageItem) return;
                             option.selected = true;
                             selectedItem = option;
                             return;
                         }

                         if(!selectedItem) {
                             option.selected = true;
                             selectedItem = option;
                         }
                     }
                 });
             }

             function isMimeTypeSupported(mimeType) {
                 if(typeof MediaRecorder === 'undefined') {
                     return false;
                 }

                 if(typeof MediaRecorder.isTypeSupported !== 'function') {
                     return true;
                 }

                 return MediaRecorder.isTypeSupported(mimeType);
             }

             recordingMedia.onchange = function() {
                 if(recordingMedia.value === 'record-audio') {
                     var recordingOptions = [];
                     
                     if(isMimeTypeSupported('audio/webm')) {
                         recordingOptions.push('opus');
                     }

                     if(isMimeTypeSupported('audio/ogg')) {
                         recordingOptions.push('ogg');
                     }

                     recordingOptions.push('pcm');

                     setMediaContainerFormat(recordingOptions);
                     return;
                 }

                 var isChrome = !!window.chrome && !(!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0);

                 var recordingOptions = ['vp8']; // MediaStreamRecorder with vp8

                 if(isMimeTypeSupported('video/webm\;codecs=vp9')) {
                     recordingOptions.push('vp9'); // MediaStreamRecorder with vp9
                 }

                 if(isMimeTypeSupported('video/webm\;codecs=h264')) {
                     recordingOptions.push('h264'); // MediaStreamRecorder with h264
                 }

                 if(isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
                     recordingOptions.push('mkv'); // MediaStreamRecorder with mkv/matroska
                 }

                 recordingOptions.push('gif'); // GifRecorder

                 if(DetectRTC.browser.name == 'Chrome') {
                     recordingOptions.push('whammy'); // WhammyRecorder
                 }

                 if(DetectRTC.browser.name == 'Chrome') {
                     recordingOptions.push('WebAssembly'); // WebAssemblyRecorder
                 }

                 recordingOptions.push('default'); // Default mimeType for MediaStreamRecorder

                 setMediaContainerFormat(recordingOptions);
             };
             recordingMedia.onchange();

             if(typeof MediaRecorder === 'undefined' && (DetectRTC.browser.name === 'Edge' || DetectRTC.browser.name === 'Safari')) {
                 // webp isn't supported in Microsoft Edge
                 // neither MediaRecorder API
                 // so lets disable both video/screen recording options

                 console.warn('Neither MediaRecorder API nor webp is supported in ' + DetectRTC.browser.name + '. You cam merely record audio.');

                 recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
                 setMediaContainerFormat(['pcm']);
             }

             function stringify(obj) {
                 var result = '';
                 Object.keys(obj).forEach(function(key) {
                     if(typeof obj[key] === 'function') {
                         return;
                     }

                     if(result.length) {
                         result += ',';
                     }

                     result += key + ': ' + obj[key];
                 });

                 return result;
             }

             function mediaRecorderToStringify(mediaRecorder) {
                 var result = '';
                 result += 'mimeType: ' + mediaRecorder.mimeType;
                 result += ', state: ' + mediaRecorder.state;
                 result += ', audioBitsPerSecond: ' + mediaRecorder.audioBitsPerSecond;
                 result += ', videoBitsPerSecond: ' + mediaRecorder.videoBitsPerSecond;
                 if(mediaRecorder.stream) {
                     result += ', streamid: ' + mediaRecorder.stream.id;
                     result += ', stream-active: ' + mediaRecorder.stream.active;
                 }
                 return result;
             }

             function getFailureReport() {
                 var info = 'RecordRTC seems failed. \n\n' + stringify(DetectRTC.browser) + '\n\n' + DetectRTC.osName + ' ' + DetectRTC.osVersion + '\n';

                 if (typeof recorderType !== 'undefined' && recorderType) {
                     info += '\nrecorderType: ' + recorderType.name;
                 }

                 if (typeof mimeType !== 'undefined') {
                     info += '\nmimeType: ' + mimeType;
                 }

                 Array.prototype.slice.call(document.querySelectorAll('select')).forEach(function(select) {
                     info += '\n' + (select.id || select.className) + ': ' + select.value;
                 });

                 if (btnStartRecording.recordRTC) {
                     info += '\n\ninternal-recorder: ' + btnStartRecording.recordRTC.getInternalRecorder().name;
                     
                     if(btnStartRecording.recordRTC.getInternalRecorder().getAllStates) {
                         info += '\n\nrecorder-states: ' + btnStartRecording.recordRTC.getInternalRecorder().getAllStates();
                     }
                 }

                 if(btnStartRecording.stream) {
                     info += '\n\naudio-tracks: ' + getTracks(btnStartRecording.stream, 'audio').length;
                     info += '\nvideo-tracks: ' + getTracks(btnStartRecording.stream, 'video').length;
                     info += '\nstream-active? ' + !!btnStartRecording.stream.active;

                     btnStartRecording.stream.getTracks().forEach(function(track) {
                         info += '\n' + track.kind + '-track-' + (track.label || track.id) + ': (enabled: ' + !!track.enabled + ', readyState: ' + track.readyState + ', muted: ' + !!track.muted + ')';

                         if(track.getConstraints && Object.keys(track.getConstraints()).length) {
                             info += '\n' + track.kind + '-track-getConstraints: ' + stringify(track.getConstraints());
                         }

                         if(track.getSettings && Object.keys(track.getSettings()).length) {
                             info += '\n' + track.kind + '-track-getSettings: ' + stringify(track.getSettings());
                         }
                     });
                 }

                 if(timeSlice && btnStartRecording.recordRTC) {
                     info += '\ntimeSlice: ' + timeSlice;

                     if(btnStartRecording.recordRTC.getInternalRecorder().getArrayOfBlobs) {
                         var blobSizes = [];
                         btnStartRecording.recordRTC.getInternalRecorder().getArrayOfBlobs().forEach(function(blob) {
                             blobSizes.push(blob.size);
                         });
                         info += '\nblobSizes: ' + blobSizes;
                     }
                 }

                 else if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getBlob()) {
                     info += '\n\nblobSize: ' + bytesToSize(btnStartRecording.recordRTC.getBlob().size);
                 }

                 if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getInternalRecorder() && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder()) {
                     info += '\n\ngetInternalRecorder: ' + mediaRecorderToStringify(btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder());
                 }

                 return info;
             }

             function saveToDiskOrOpenNewTab(recordRTC) {
                 if(!recordRTC.getBlob().size) {
                     var info = getFailureReport();
                     console.log('blob', recordRTC.getBlob());
                     console.log('recordrtc instance', recordRTC);
                     console.log('report', info);

                     if(mediaContainerFormat.value !== 'default') {
                         alert('RecordRTC seems failed recording using ' + mediaContainerFormat.value + '. Please choose "default" option from the drop down and record again.');
                     }
                     else {
                         alert('RecordRTC seems failed. Unexpected issue. You can read the email in your console log. \n\nPlease report using disqus chat below.');
                     }

                     if(mediaContainerFormat.value !== 'vp9' && DetectRTC.browser.name === 'Chrome') {
                         alert('Please record using VP9 encoder. (select from the dropdown)');
                     }
                 }

                 var fileName = getFileName(fileExtension);

                 document.querySelector('#save-to-disk').parentNode.style.display = 'block';
                 document.querySelector('#save-to-disk').onclick = function() {
                     if(!recordRTC) return alert('No recording found.');

                     var file = new File([recordRTC.getBlob()], fileName, {
                         type: mimeType
                     });

                     invokeSaveAsDialog(file, file.name);
                 };

                 document.querySelector('#open-new-tab').onclick = function() {
                     if(!recordRTC) return alert('No recording found.');

                     var file = new File([recordRTC.getBlob()], fileName, {
                         type: mimeType
                     });

                     window.open(URL.createObjectURL(file));
                 };

                 // upload to PHP server
                 if(isMyOwnDomain()) {
                     document.querySelector('#upload-to-php').disabled = true;
                     document.querySelector('#upload-to-php').style.display = 'none';
                 }
                 else {
                     document.querySelector('#upload-to-php').disabled = false;
                 }
                 
                 document.querySelector('#upload-to-php').onclick = function() {
                     if(isMyOwnDomain()) {
                         alert('PHP Upload is not available on this domain.');
                         return;
                     }

                     if(!recordRTC) return alert('No recording found.');
                     this.disabled = true;

                     var button = this;


		     // new edit
		     fileName = "<?php echo $class_id.'.webm' ?>";

                     uploadToPHPServer(fileName, recordRTC, function(progress, fileURL) {
                         if(progress === 'ended') {
                             button.disabled = false;
                             button.innerHTML = 'Download from fxUnivers';
                             button.onclick = function() {
                                 SaveFileURLToDisk(fileURL, fileName);
                             };

                             setVideoURL(fileURL);

                             var html = 'Uploaded to fxUnivers.';
                             //html += '<a href="'+fileURL+'" download="'+fileName+'" style="color: yellow; display: block; margin-top: 15px;">'+fileName+'</a>';
                             recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = html;
                             return;
                         }
                         button.innerHTML = progress;
                         recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = progress;
                     });
                 };

                 // upload to YouTube!
                 document.querySelector('#upload-to-youtube').disabled = false;
                 document.querySelector('#upload-to-youtube').onclick = function() {
                     if(!recordRTC) return alert('No recording found.');
                     this.disabled = true;

                     if(isLocalHost()) {
                         alert('This feature is NOT available on localhost.');
                         return;
                     }

                     if(isMyOwnDomain() === false) {
                         var url = 'https://github.com/muaz-khan/RecordRTC/wiki/Upload-to-YouTube';
                         alert(' page: ' + url);

                         // check instructions on the wiki page
                         location.href = url;
                         return;
                     }

                     var button = this;
                     uploadToYouTube(fileName, recordRTC, function(percentageComplete, fileURL) {
                         if(percentageComplete == 'uploaded') {
                             button.disabled = false;
                             button.innerHTML = 'Uploaded. However YouTube is still processing.';
                             button.onclick = function() {
                                 window.open(fileURL);
                             };
                             return;
                         }
                         if(percentageComplete == 'processed') {
                             button.disabled = false;
                             button.innerHTML = 'Uploaded & Processed. Click to open YouTube video.';
                             button.onclick = function() {
                                 window.open(fileURL);
                             };

                             document.querySelector('h1').innerHTML = 'Your video has been uploaded.';
                             window.scrollTo(0, 0);

                             alert('Your video has been uploaded.');
                             return;
                         }
                         if(percentageComplete == 'failed') {
                             button.disabled = false;
                             button.innerHTML = 'YouTube failed transcoding the video.';
                             button.onclick = function() {
                                 window.open(fileURL);
                             };
                             return;
                         }
                         button.innerHTML = percentageComplete + '% uploaded to YouTube.';
                     });
                 };
             }

             function uploadToPHPServer(fileName, recordRTC, callback) {
                 var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.getBlob();
                 
                 blob = new File([blob], getFileName(fileExtension), {
                     type: mimeType
                 });

                 // create FormData
                 var formData = new FormData();
                 formData.append('video-filename', fileName);
                 formData.append('video-blob', blob);

                 callback('Uploading recorded-file to server.');

                 // var upload_url = 'https://your-domain.com/files-uploader/';
                 var upload_url = 'RecordRTC-to-PHP/save.php';

                 // var upload_directory = upload_url;
                 var upload_directory = '../live/uploads/';

                 makeXMLHttpRequest(upload_url, formData, function(progress) {
                     if (progress !== 'upload-ended') {
                         callback(progress);
                         return;
                     }
		     fileName = "<?php echo $class_id.'.webm'?>";
                     callback('ended', upload_directory + fileName);
                 });
             }

             function makeXMLHttpRequest(url, data, callback) {
                 var request = new XMLHttpRequest();
                 request.onreadystatechange = function() {
                     if (request.readyState == 4 && request.status == 200) {
                         if(request.responseText === 'success') {
                             callback('upload-ended');
                             return;
                         }

                         document.querySelector('.header').parentNode.style = 'text-align: left; color: red; padding: 5px 10px;';
                         document.querySelector('.header').parentNode.innerHTML = request.responseText;
                     }
                 };

                 request.upload.onloadstart = function() {
                     callback('Upload started...');
                 };

                 request.upload.onprogress = function(event) {
                     callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
                 };

                 request.upload.onload = function() {
                     callback('progress-about-to-end');
                 };

                 request.upload.onload = function() {
                     callback('Getting File URL..');
                 };

                 request.upload.onerror = function(error) {
                     callback('Failed to upload to server');
                 };

                 request.upload.onabort = function(error) {
                     callback('Upload aborted.');
                 };

                 request.open('POST', url);
                 request.send(data);
             }

             function getRandomString() {
                 if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
                     var a = window.crypto.getRandomValues(new Uint32Array(3)),
                         token = '';
                     for (var i = 0, l = a.length; i < l; i++) {
                         token += a[i].toString(36);
                     }
                     return token;
                 } else {
                     return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
                 }
             }

             function getFileName(fileExtension) {
                 var d = new Date();
                 var year = d.getUTCFullYear();
                 var month = d.getUTCMonth();
                 var date = d.getUTCDate();
                 return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
             }

             function SaveFileURLToDisk(fileUrl, fileName) {
                 var hyperlink = document.createElement('a');
                 hyperlink.href = fileUrl;
                 hyperlink.target = '_blank';
                 hyperlink.download = fileName || fileUrl;

                 (document.body || document.documentElement).appendChild(hyperlink);
                 hyperlink.onclick = function() {
                     (document.body || document.documentElement).removeChild(hyperlink);

                     // required for Firefox
                     window.URL.revokeObjectURL(hyperlink.href);
                 };

                 var mouseEvent = new MouseEvent('click', {
                     view: window,
                     bubbles: true,
                     cancelable: true
                 });

                 hyperlink.dispatchEvent(mouseEvent);
             }

             function getURL(arg) {
                 var url = arg;

                 if(arg instanceof Blob || arg instanceof File) {
                     url = URL.createObjectURL(arg);
                 }

                 if(arg instanceof RecordRTC || arg.getBlob) {
                     url = URL.createObjectURL(arg.getBlob());
                 }

                 if(arg instanceof MediaStream || arg.getTracks) {
                     // url = URL.createObjectURL(arg);
                 }

                 return url;
             }

             function setVideoURL(arg, forceNonImage) {
                 var url = getURL(arg);

                 var parentNode = recordingPlayer.parentNode;
                 parentNode.removeChild(recordingPlayer);
                 parentNode.innerHTML = '';

                 var elem = 'video';
                 if(type == 'gif' && !forceNonImage) {
                     elem = 'img';
                 }
                 if(type == 'audio') {
                     elem = 'audio';
                 }

                 recordingPlayer = document.createElement(elem);
                 
                 if(arg instanceof MediaStream) {
                     recordingPlayer.muted = true;
                 }

                 recordingPlayer.addEventListener('loadedmetadata', function() {
                     if(navigator.userAgent.toLowerCase().indexOf('android') == -1) return;

                     // android
                     setTimeout(function() {
                         if(typeof recordingPlayer.play === 'function') {
                             recordingPlayer.play();
                         }
                     }, 2000);
                 }, false);

                 recordingPlayer.poster = '';

                 if(arg instanceof MediaStream) {
                     recordingPlayer.srcObject = arg;
                 }
                 else {
                     recordingPlayer.src = url;
                 }

                 if(typeof recordingPlayer.play === 'function') {
                     recordingPlayer.play();
                 }

                 recordingPlayer.addEventListener('ended', function() {
                     url = getURL(arg);
                     
                     if(arg instanceof MediaStream) {
                         recordingPlayer.srcObject = arg;
                     }
                     else {
                         recordingPlayer.src = url;
                     }
                 });

                 parentNode.appendChild(recordingPlayer);
             }
            </script>

            <script>
             function captureScreen(config) {
                 if (navigator.getDisplayMedia) {
                     navigator.getDisplayMedia({
                         video: true
                     }).then(screenStream => {
                         config.onMediaCaptured(screenStream);

                         addStreamStopListener(screenStream, function() {
                             // config.onMediaStopped();

                             btnStartRecording.onclick();
                         });

                         setVideoURL(screenStream, true);
                     }).catch(function(error) {
                         config.onMediaCapturingFailed(error);
                     });
                 } else if (navigator.mediaDevices.getDisplayMedia) {
                     navigator.mediaDevices.getDisplayMedia({
                         video: true
                     }).then(screenStream => {
                         config.onMediaCaptured(screenStream);

                         addStreamStopListener(screenStream, function() {
                             // config.onMediaStopped();

                             btnStartRecording.onclick();
                         });

                         setVideoURL(screenStream, true);
                     }).catch(function(error) {
                         config.onMediaCapturingFailed(error);
                     });
                 } else {
                     var error = 'getDisplayMedia API are not supported in this browser.';
                     config.onMediaCapturingFailed(error);
                     alert(error);
                 }
             }

             function captureAudioPlusScreen(config) {
                 if (navigator.getDisplayMedia) {
                     navigator.getDisplayMedia({
                         video: true
                     }).then(screenStream => {
                         navigator.mediaDevices.getUserMedia({audio:true}).then(function(mic) {
                             screenStream.addTrack(mic.getTracks()[0]);

                             config.onMediaCaptured(screenStream);

                             addStreamStopListener(screenStream, function() {
                                 // config.onMediaStopped();

                                 btnStartRecording.onclick();
                             });

                             setVideoURL(screenStream, true);
                         });
                     }).catch(function(error) {
                         config.onMediaCapturingFailed(error);
                     });
                 } else if (navigator.mediaDevices.getDisplayMedia) {
                     navigator.mediaDevices.getDisplayMedia({
                         video: true
                     }).then(screenStream => {
                         navigator.mediaDevices.getUserMedia({audio:true}).then(function(mic) {
                             screenStream.addTrack(mic.getTracks()[0]);

                             config.onMediaCaptured(screenStream);

                             addStreamStopListener(screenStream, function() {
                                 // config.onMediaStopped();

                                 btnStartRecording.onclick();
                             });

                             setVideoURL(screenStream, true);
                         });
                     }).catch(function(error) {
                         config.onMediaCapturingFailed(error);
                     });
                 } else {
                     var error = 'getDisplayMedia API are not supported in this browser.';
                     config.onMediaCapturingFailed(error);
                     alert(error);
                 }
             }
            </script>

            <script>
             /* upload_youtube_video.js Copyright 2017 Google Inc. All Rights Reserved. */

             function uploadToYouTube(fileName, recordRTC, callback) {
                 var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.getBlob();
                 
                 blob = new File([blob], getFileName(fileExtension), {
                     type: mimeType
                 });

                 if(!uploadVideo) {
                     alert('YouTube API are not available.');
                     return;
                 }

                 uploadVideo.callback = callback;
                 uploadVideo.uploadFile(fileName, blob);
             }

             var uploadVideo;

             var signinCallback = function (result){
		 if(result.access_token) {
                     uploadVideo = new UploadVideo();
                     uploadVideo.ready(result.access_token);

                     document.querySelector('#signinButton').style.display = 'none';
		 }
		 else {
                     // console.error('YouTube error', result);
                     // document.querySelector('#upload-to-youtube').style.display = 'none';
		 }
             };

             var STATUS_POLLING_INTERVAL_MILLIS = 60 * 1000; // One minute.

             var UploadVideo = function() {
		 this.tags = ['recordrtc'];
		 this.categoryId = 28; // via: http://stackoverflow.com/a/35877512/552182
		 this.videoId = '';
		 this.uploadStartTime = 0;
             };


             UploadVideo.prototype.ready = function(accessToken) {
		 this.accessToken = accessToken;
		 this.gapi = gapi;
		 this.authenticated = true;
		 false && this.gapi.client.request({
                     path: '/youtube/v3/channels',
                     params: {
			 part: 'snippet',
			 mine: true
                     },
                     callback: function(response) {
			 if (!response.error) {
			     // response.items[0].snippet.title -- channel title
			     // response.items[0].snippet.thumbnails.default.url -- channel thumbnail
			 }
                     }.bind(this)
		 });
             };

             UploadVideo.prototype.uploadFile = function(fileName, file) {
		 var metadata = {
                     snippet: {
			 title: fileName,
			 description: fileName,
			 tags: this.tags,
			 categoryId: this.categoryId
                     },
                     status: {
			 privacyStatus: 'public'
                     }
		 };
		 var uploader = new MediaUploader({
                     baseUrl: 'https://www.googleapis.com/upload/youtube/v3/videos',
                     file: file,
                     token: this.accessToken,
                     metadata: metadata,
                     params: {
			 part: Object.keys(metadata).join(',')
                     },
                     onError: function(data) {
			 var message = data;
			 try {
			     var errorResponse = JSON.parse(data);
			     message = errorResponse.error.message;
			 } finally {
			     alert(message);
			 }
                     }.bind(this),
                     onProgress: function(data) {
			 var bytesUploaded = data.loaded;
			 var totalBytes = parseInt(data.total);
			 var percentageComplete = parseInt((bytesUploaded * 100) / totalBytes);

			 uploadVideo.callback(percentageComplete);
                     }.bind(this),
                     onComplete: function(data) {
			 var uploadResponse = JSON.parse(data);
			 this.videoId = uploadResponse.id;
			 this.videoURL = 'https://www.youtube.com/watch?v=' + this.videoId;
			 uploadVideo.callback('uploaded', this.videoURL);

			 setTimeout(this.pollForVideoStatus, 2000);
                     }.bind(this)
		 });
		 this.uploadStartTime = Date.now();
		 uploader.upload();
             };

             UploadVideo.prototype.pollForVideoStatus = function() {
		 this.gapi.client.request({
                     path: '/youtube/v3/videos',
                     params: {
			 part: 'status,player',
			 id: this.videoId
                     },
                     callback: function(response) {
			 if (response.error) {
			     uploadVideo.pollForVideoStatus();
			 } else {
			     var uploadStatus = response.items[0].status.uploadStatus;
			     switch (uploadStatus) {
				 case 'uploaded':
				     uploadVideo.callback('uploaded', uploadVideo.videoURL);
				     uploadVideo.pollForVideoStatus();
				     break;
				 case 'processed':
				     uploadVideo.callback('processed', uploadVideo.videoURL);
				     break;
				 default:
				     uploadVideo.callback('failed', uploadVideo.videoURL);
				     break;
			     }
			 }
                     }.bind(this)
		 });
             };

            </script>

            <script>
             /* cors_upload.js Copyright 2015 Google Inc. All Rights Reserved. */

             var DRIVE_UPLOAD_URL = 'https://www.googleapis.com/upload/drive/v2/files/';

             var RetryHandler = function() {
		 this.interval = 1000; // Start at one second
		 this.maxInterval = 60 * 1000; // Don't wait longer than a minute 
             };

             RetryHandler.prototype.retry = function(fn) {
		 setTimeout(fn, this.interval);
		 this.interval = this.nextInterval_();
             };

             RetryHandler.prototype.reset = function() {
		 this.interval = 1000;
             };

             RetryHandler.prototype.nextInterval_ = function() {
		 var interval = this.interval * 2 + this.getRandomInt_(0, 1000);
		 return Math.min(interval, this.maxInterval);
             };

             RetryHandler.prototype.getRandomInt_ = function(min, max) {
		 return Math.floor(Math.random() * (max - min + 1) + min);
             };

             var MediaUploader = function(options) {
		 var noop = function() {};
		 this.file = options.file;
		 this.contentType = options.contentType || this.file.type || 'application/octet-stream';
		 this.metadata = options.metadata || {
                     'title': this.file.name,
                     'mimeType': this.contentType
		 };
		 this.token = options.token;
		 this.onComplete = options.onComplete || noop;
		 this.onProgress = options.onProgress || noop;
		 this.onError = options.onError || noop;
		 this.offset = options.offset || 0;
		 this.chunkSize = options.chunkSize || 0;
		 this.retryHandler = new RetryHandler();

		 this.url = options.url;
		 if (!this.url) {
                     var params = options.params || {};
                     params.uploadType = 'resumable';
                     this.url = this.buildUrl_(options.fileId, params, options.baseUrl);
		 }
		 this.httpMethod = options.fileId ? 'PUT' : 'POST';
             };

             MediaUploader.prototype.upload = function() {
		 var self = this;
		 var xhr = new XMLHttpRequest();

		 xhr.open(this.httpMethod, this.url, true);
		 xhr.setRequestHeader('Authorization', 'Bearer ' + this.token);
		 xhr.setRequestHeader('Content-Type', 'application/json');
		 xhr.setRequestHeader('X-Upload-Content-Length', this.file.size);
		 xhr.setRequestHeader('X-Upload-Content-Type', this.contentType);

		 xhr.onload = function(e) {
                     if (e.target.status < 400) {
			 var location = e.target.getResponseHeader('Location');
			 this.url = location;
			 this.sendFile_();
                     } else {
			 this.onUploadError_(e);
                     }
		 }.bind(this);
		 xhr.onerror = this.onUploadError_.bind(this);
		 xhr.send(JSON.stringify(this.metadata));
             };

             MediaUploader.prototype.sendFile_ = function() {
		 var content = this.file;
		 var end = this.file.size;

		 if (this.offset || this.chunkSize) {
                     // Only bother to slice the file if we're either resuming or uploading in chunks
                     if (this.chunkSize) {
			 end = Math.min(this.offset + this.chunkSize, this.file.size);
                     }
                     content = content.slice(this.offset, end);
		 }

		 var xhr = new XMLHttpRequest();
		 xhr.open('PUT', this.url, true);
		 xhr.setRequestHeader('Content-Type', this.contentType);
		 xhr.setRequestHeader('Content-Range', 'bytes ' + this.offset + '-' + (end - 1) + '/' + this.file.size);
		 xhr.setRequestHeader('X-Upload-Content-Type', this.file.type);
		 if (xhr.upload) {
                     xhr.upload.addEventListener('progress', this.onProgress);
		 }
		 xhr.onload = this.onContentUploadSuccess_.bind(this);
		 xhr.onerror = this.onContentUploadError_.bind(this);
		 xhr.send(content);
             };

             MediaUploader.prototype.resume_ = function() {
		 var xhr = new XMLHttpRequest();
		 xhr.open('PUT', this.url, true);
		 xhr.setRequestHeader('Content-Range', 'bytes */' + this.file.size);
		 xhr.setRequestHeader('X-Upload-Content-Type', this.file.type);
		 if (xhr.upload) {
                     xhr.upload.addEventListener('progress', this.onProgress);
		 }
		 xhr.onload = this.onContentUploadSuccess_.bind(this);
		 xhr.onerror = this.onContentUploadError_.bind(this);
		 xhr.send();
             };

             MediaUploader.prototype.extractRange_ = function(xhr) {
		 var range = xhr.getResponseHeader('Range');
		 if (range) {
                     this.offset = parseInt(range.match(/\d+/g).pop(), 10) + 1;
		 }
             };

             MediaUploader.prototype.onContentUploadSuccess_ = function(e) {
		 if (e.target.status == 200 || e.target.status == 201) {
                     this.onComplete(e.target.response);
		 } else if (e.target.status == 308) {
                     this.extractRange_(e.target);
                     this.retryHandler.reset();
                     this.sendFile_();
		 }
             };

             MediaUploader.prototype.onContentUploadError_ = function(e) {
		 if (e.target.status && e.target.status < 500) {
                     this.onError(e.target.response);
		 } else {
                     this.retryHandler.retry(this.resume_.bind(this));
		 }
             };

             MediaUploader.prototype.onUploadError_ = function(e) {
		 this.onError(e.target.response); // TODO - Retries for initial upload
             };

             MediaUploader.prototype.buildQuery_ = function(params) {
		 params = params || {};
		 return Object.keys(params).map(function(key) {
                     return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
		 }).join('&');
             };

             MediaUploader.prototype.buildUrl_ = function(id, params, baseUrl) {
		 var url = baseUrl || DRIVE_UPLOAD_URL;
		 if (id) {
                     url += id;
		 }
		 var query = this.buildQuery_(params);
		 if (query) {
                     url += '?' + query;
		 }
		 return url;
             };
            </script>

            <script>
             var chkFixSeeking = document.querySelector('#chk-fixSeeking');
             chkFixSeeking.onchange = function() {
                 if(this.checked === true) {
                     localStorage.setItem(this.id, 'true');
                 }
                 else {
                     localStorage.removeItem(this.id);
                 }
             };
             if(localStorage.getItem(chkFixSeeking.id) === 'true') {
                 chkFixSeeking.checked = true;
             }
            </script>

            <script>
             var chkTimeSlice = document.querySelector('#chk-timeSlice');
             var timeSlice = false;

             if(typeof MediaRecorder === 'undefined') {
                 chkTimeSlice.disabled = true;
             }

             chkTimeSlice.addEventListener('change', function() {
                 if(chkTimeSlice.checked === true) {
                     var _timeSlice = prompt('Please enter timeSlice in milliseconds e.g. 1000 or 2000 or 3000.', 1000);
                     _timeSlice = parseInt(_timeSlice);
                     if(!_timeSlice || _timeSlice == NaN || typeof _timeSlice === 'undefined') {
                         timeSlice = false;
                         return;
                     }

                     timeSlice = _timeSlice;
                 }
                 else {
                     timeSlice = false;
                 }
             }, false);
            </script>

            <script>
             var btnPauseRecording = document.querySelector('#btn-pause-recording');
             btnPauseRecording.onclick = function() {
                 if(!btnStartRecording.recordRTC) {
                     btnPauseRecording.style.display = 'none';
                     return;
                 }

                 btnPauseRecording.disabled = true;
                 if(btnPauseRecording.innerHTML === 'Pause') {
                     btnStartRecording.disabled = true;
                     chkFixSeeking.parentNode.style.display = 'none';
                     btnStartRecording.style.fontSize = '15px';
                     btnStartRecording.recordRTC.pauseRecording();
                     recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = 'Recording status: paused';
                     recordingPlayer.pause();

                     btnPauseRecording.style.fontSize = 'inherit';
                     setTimeout(function() {
                         btnPauseRecording.innerHTML = 'Resume Recording';
                         btnPauseRecording.disabled = false;
                     }, 2000);
                 }

                 if(btnPauseRecording.innerHTML === 'Resume Recording') {
                     btnStartRecording.disabled = false;
                     chkFixSeeking.parentNode.style.display = 'none';
                     btnStartRecording.style.fontSize = 'inherit';
                     btnStartRecording.recordRTC.resumeRecording();
                     recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = '<img src="https://www.webrtc-experiment.com/images/progress.gif">';
                     recordingPlayer.play();

                     btnPauseRecording.style.fontSize = '15px';
                     btnPauseRecording.innerHTML = 'Pause';
                     setTimeout(function() {
                         btnPauseRecording.disabled = false;
                     }, 2000);
                 }
             };
            </script>


	    <script>

	     $('#video-audio-r-toggle').change(function() {
		 if(this.checked) {
		     $('.recording-media').val('record-audio-plus-video');
		     $('#btn-start-recording').click();
		     $('#screen-audio-r-toggle').prop('disabled',true);
		     $('#screen-add-box').css('opacity','0.6');
		     $('#upload-to-php').html('Upload as Session Video');
		     $('#stop-button').show();
		 } else if(!this.checked) {
		     $('#btn-start-recording').click();
		     /*$('#screen-audio-r-toggle').prop('disabled',false);
		     $('#screen-add-box').css('opacity','1');
		     $('#stop-button').hide();*/
		     $('#screen-audio-r-toggle').hide();
		     $('#stop-button').hide();
		     $('#video-audio-r-toggle').hide();
		     $('#screen-add-box').hide()
		     $('#video-add-box').hide();
		     $('#new-rec-btn').show();
		 }
	     });

	    </script>
	    <script>

	     $('#screen-audio-r-toggle').change(function() {
		 if(this.checked) {
		     $('.recording-media').val('record-audio-plus-screen');
		     $('#btn-start-recording').click();
		     $('#video-audio-r-toggle').prop('disabled',true);
		     $('#video-add-box').css('opacity','0.6');
		     $('#upload-to-php').html('Upload as Session Video');
		     $('#stop-screen-button').show();
		 } else if(!this.checked) {
		     $('#btn-start-recording').click();
		     /*$('#video-audio-r-toggle').prop('disabled',false);
		     $('#video-add-box').css('opacity','1');
			$('#stop-screen-button').hide();*/
		     $('#screen-audio-r-toggle').hide();
		     $('#stop-screen-button').hide();
		     $('#video-audio-r-toggle').hide();
		     $('#screen-add-box').hide();
		     $('#video-add-box').hide();
		     $('#new-rec-btn').show();
		 }
	     });
	     
	    </script>


	    <script>
	     $('#stop-button').click(function() {
		 $('#video-audio-r-toggle').click();
	     });
	     $('#stop-screen-button').click(function() {
		 $('#screen-audio-r-toggle').click();
	     });
	     $('#new-rec-btn').click(function() {
		 window.location.reload();
	     });
	    </script>
	    
	</article>
    </body>
</html>
