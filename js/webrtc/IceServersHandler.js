// IceServersHandler.js

var IceServersHandler = (function() {
	function getIceServers(connection) {
	    // resiprocate: 3344+4433
	    // pions: 7575
	    var iceServers = [
	        
	        {
   urls: [ "stun:us-turn7.xirsys.com" ]
}, {
   username: "ZiJmpu-hb2bdcYNCYsHWWsMz8fbwz1WURpyTZkeJbfHTEygu9mT1jm_PFyJGd3p7AAAAAF__NwtuZW9hYnJhbXNvbg==",
   credential: "4c22cbfe-55ca-11eb-8e94-0242ac140004",
   urls: [
       "turn:us-turn7.xirsys.com:80?transport=udp"
       //"turn:us-turn7.xirsys.com:3478?transport=udp",
       //"turn:us-turn7.xirsys.com:80?transport=tcp",
       //"turn:us-turn7.xirsys.com:3478?transport=tcp"
       //       "turns:us-turn7.xirsys.com:443?transport=tcp",
       //"turns:us-turn7.xirsys.com:5349?transport=tcp"
   ]
}
	        
	        
	        
	        /*
	        { urls: 'stun:numb.viagenie.ca',
	            username:'neo@fxunivers.com',
		        credential:'23571113'
	        },
	        {urls: 'turn:numb.viagenie.ca',
	         username:'neo@fxunivers.com',
		        credential:'23571113'
	        }*/
		];
        return iceServers;
    }

    return {
        getIceServers: getIceServers
    };
})();
