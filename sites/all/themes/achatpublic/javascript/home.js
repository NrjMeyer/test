$(function() {
	
    $('#leaderboard #leaderboard_pics #block-views-Leaderboard-block_1 .content .view-content > ul').cycle({
        fx: 'fade',
        timeout: 9000,
		next: '#leaderboard_nav_next', 
		prev: '#leaderboard_nav_prev' ,
        pager: '#leaderboard_nav_selec',
        pagerAnchorBuilder: pagerFactory
    });
	
    function pagerFactory(idx, slide) {
        return '<a href="#">'+(idx+1)+'</a>';
    };

});