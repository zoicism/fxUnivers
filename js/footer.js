if(screen.width>480) {
    $('.footer').html('<span style="float:left;margin-left:10px;"><a href="https://twitter.com/fxunivers" target="_blank"><img src="/images/socialpack/twitter.png" style="width:15px;height:15px;"></a> <a href="https://facebook.com/fxunivers" target="_blank"><img src="/images/socialpack/facebook.png" style="width:15px;height:15px;"></a> <a href="https://instagram.com/fxunivers" target="_blank"><img src="/images/socialpack/instagram.png" style="width:15px;height:15px;"></a></span> With all due Reserves, &copy; fxUnivers 2017-2020 All rights reserved. <span style="float:right;margin-right:10px;"><a href="/policy" style="color:#939393;border: 1px solid #939393;" id="policy">Policy</a></span>');
} else {	
    $('.footer').html('<div class="center" style="width:100%">With all due Reserves, &copy; fxUnivers 2017-2020 All rights reserved. <a href="/policy" style="color:#939393;border: 1px solid #939393;" id="policy">Policy</a></div>');
    
	$('.footer').css('padding-top','0');
	$('.footer').css('padding-bottom','0');	
    if(document.documentElement.scrollHeight !== document.documentElement.clientHeight) {
	$('.footer').css('position','relative');
    } else {
	$('.footer').css('position','fixed');
    }
}
