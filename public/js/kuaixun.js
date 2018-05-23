!function(){
	$(".show_page .warp").niceScroll({
		cursorcolor:"#696969",
		cursoropacitymax:1,
		touchbehavior:false,
		cursorwidth:"5px",
		cursorborder:"0",
		cursorborderradius:"5px",
		cursorfixedheight:true
	});

	var num = 20;
	var start = 20;

	$('.load_more').click(function(){
		load_more_loading();
		next_page();
	});

	function load_more_loading(){
		$('.load_more_loader_box').css({'display':'block'});
		$('.load_more').hide();
	}

	function load_more_loadover(){
		$('.load_more_loader_box').css({'display':'none'});
		$('.load_more').show();
	}

	function next_page(){
		var url = '/index.php?m=kuaixun&c=index&a=next_page_ajax&catid=' + info.catid + '&start=' + start;
		$.ajax({
			'url' : url,
			'success' : function(data){
				var html = '';
				var relgp;
				$.each(data,function(k,v){
					var inputtime = gettime(v.inputtime*1000);
					relgp = relgpeach(v.relevantgp);
					html += '<li class="theme_list clearfix">';
					html +=	'<div class="time"><p>'+ inputtime +'</p></div>';
					html +=	'<div class="theme_list_con">';
					html +=		'<div class="desc fs14"><h2><a href="" class="view fs14" data-url="&catid='+ v.catid +'&id='+ v.id +'" name="titleName" class="title_name">【' + v.title + '】</a></h2>' + v.description +'</div>';
					html += 	'<div class="relgp">'+ relgp +'<div class="clear"></div></div>';
					html +=	'</div>';
					html +=	'<div class="clear"></div>';
					html += '</li>';
				});
				start = start + num;
				load_more_loadover();
				$('.load_more').before(html);
			}
		});
	}
	
	function relgpeach(data){
		var res = '';
		$.each(data,function(i,v){
			console.log(v);
			url = '/index.php??m=content&c=shares&a=page&id=' + v.code;
			var codeFirst = parseInt(v.code/100000);
			console.log(codeFirst);
			var city = codeFirst == 6 ? 'sh' : 'sz';
			res += '<a href="'+ url +'" target="_blank">'+ v.allname +'<em><img src="http://image.sinajs.cn/newchart/small/n'+ city + v.code +'.gif"></em></a>';
		});
		return res;
	}

	function load_more_loader () {
		
	}

	function gettime (t) {
		var now = new Date();
		var today = now.getDate();
		var date = new Date(t);
		var day = date.getDate();
		if (day == today) {
			return "今天 " + date.getHours() + ":" + date.getMinutes();
		}
		var month = date.getMonth() + 1;
		return month + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes();
	}
	
	function show_page(title, date, content, relation, gpindex) {
		$(".show_page_bg").show();
		$('.show_page h2').html(title);
		$('.show_page .date').html(date);
		$('.show_page .cont').html(content);
		
		if($('.show_page .relation').length > 0) {
			$('.show_page .relation').remove();
		}
		if(relation) {
			var rels = '';
			$.each(relation,function(i,v){
				nobr = i == 0 ? ' class="noborder"' : '';
				rels += '<a href="'+ v.url + nobr +'" target="_blank">'+ v.title +'</a>';
			});
			$('.show_page .cont').after('<div class="relation"><span>相关信息：</span>'+ rels +'<div class="clear"></div></div>');
		}
		if(gpindex){
			var indexs = '';
			url = '/index.php?m=kuaixun&c=index&a=test&catid=41&id=1056&key=';
			$.each(gpindex, function(i,v){
				indexs += '<a href="'+ url + v +'">'+ v +'</a>';
			});
			$('.show_page .cont').after('<div class="relation"><span>历史信息：</span>'+ indexs +'<div class="clear"></div></div>');
		}
		var wh = $(window).height();
		var h = $('.show_page').height() > wh-30 ? wh-30 :  $('.show_page').height();
		var top = -h/2;
		$('.show_page').css({'top': '20px', 'height':h});
		$('.show_page .warp').css({'height':h-70});
		$('.show_page').addClass('show');
	}
	
	function show_loader(){
		$('.loadbox').show();
	}
	
	function hide_loader(){
		$('.loadbox').hide();
	}
	
	function show_postwrap () {

	}

	$('.show_page_bg').click(function(){
		$(this).hide();
		$('.show_page').removeClass('show');
		$('.show_page').css('height','auto').css("top", 0);
		$('.show_page .warp').css('height','auto');
	});
	
	$('.kxlist ul').on('click', 'li a.view', function() {
		show_loader();
		var url = '/index.php?m=kuaixun&c=index&a=kx_page_ajax' + $(this).attr('data-url');
		$.ajax({
			'url' : url,
			'success' : function(data){
				hide_loader();
				var relation = typeof data.relation == 'undefined' ? false : data.relation;
				var gpindex = typeof data.gpindex == 'undefined' ? false : data.gpindex;
				show_page(data.title, data.inputtime, data.content, relation, gpindex);
			}
		});
		
		return false;
	});
}();