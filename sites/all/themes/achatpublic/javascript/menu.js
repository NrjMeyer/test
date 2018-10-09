$(document).ready(function() {
	$("#menu_nav > div.top > ul.menu > li.expanded a").each(function(){
		if($(this).attr('href') == '/'){
			$(this).removeAttr('href');
		}
	});
	$("#menu_nav > div.top > ul.menu > li.active-trail > div").show();
	var widthAllSousMenu = 998;
	var widthSousMenu = $("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").width();
	
	if($("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").height() <= 22){
		var restantSousMenu = widthAllSousMenu - widthSousMenu - 10;
		var paddingGaucheSousMenu = Math.round(restantSousMenu / 2);
		$("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").css({'padding-left' : paddingGaucheSousMenu+'px'});
	}
	
	$('#menu_nav').hover(function(){
		// nothing
	} , function() {
		$("#menu_nav > div.top > ul.menu > li.active-trail > div").hide();
		$("#menu_nav > div.top > ul.menu > li.active-trail").removeClass("on");
		$("#menu_nav > div.top > ul.menu > li.exit_out").addClass("on");
		$("#menu_nav > div.top > ul.menu > li.exit_out > div").show();
		$(this).oneTime(2000, function(){
			$("#menu_nav > div.top > ul.menu > li").removeClass("on");
			$("#menu_nav > div.top > ul.menu > li").removeClass("exit_out");
			$("#menu_nav > div.top > ul.menu > li > div").hide();
			$("#menu_nav > div.top > ul.menu > li.active-trail").addClass("on");
			$("#menu_nav > div.top > ul.menu > li.active-trail > div").show();
		});
	});
	
	$('#menu_nav > div.top > ul.menu > li').hover(function() {
		$("#menu_nav > div.top > ul.menu > li.active-trail > div").hide();
		$("#menu_nav > div.top > ul.menu > li.active-trail").removeClass("on");
		$("#menu_nav > div.top > ul.menu > li").removeClass("exit_out");
		$(this).addClass("on");
		$(this).children('div').show();
		
		var widthSousMenu = $("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").width();
		if($("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").height() <= 22){
			var restantSousMenu = widthAllSousMenu - widthSousMenu - 10;
			var paddingGaucheSousMenu = Math.round(restantSousMenu / 2);
			$("#menu_nav > div.top > ul.menu > li.on > div.top > ul.menu").css({'padding-left' : paddingGaucheSousMenu+'px'});
		}
	}, function() {
		$(this).removeClass("on");
		$(this).addClass("exit_out");
		$(this).children('div').hide();
		$("#menu_nav > div.top > ul.menu > li.active-trail").addClass("on");
		$("#menu_nav > div.top > ul.menu > li.active-trail > div").show();
	});	
	
	
});