var animData = {
        container: document.getElementById('bodymovin'),
        renderer: 'svg',
        loop: false,
        autoplay: false,
        animationData: animationData
    };
    var anim = bodymovin.loadAnimation(animData);
    
$( "#bodymovin" ).click(function() {
            bodymovin.play();
    });
