jQuery(function($){
	var index = 0;
	var maximg = 5;

	//滑动导航改变内容
	jQuery("#bgSwitchNav li").hover(function(){
		if(MyTime){
			clearInterval(MyTime);
		}
		index  =  $("#bgSwitchNav li").index(this);
		MyTime = setTimeout(function(){
			ShowjQueryFlash(index);
			$('#indexBgSwitch').stop();
		} , 400);

	}, function(){
		clearInterval(MyTime);
		MyTime = setInterval(function(){
			ShowjQueryFlash(index);
			index++;
			if(index==maximg){index=0;}
		} , 4000);
	});
	//滑入 停止动画，滑出开始动画.
	$('#indexBgSwitch').hover(function(){
		if(MyTime){
			clearInterval(MyTime);
		}
	},function(){
		MyTime = setInterval(function(){
			ShowjQueryFlash(index);
			index++;
			if(index==maximg){index=0;}
		} , 4000);
	});
	//自动播放
	var MyTime = setInterval(function(){
		ShowjQueryFlash(index);
		index++;
		if(index==maximg){index=0;}
	} , 4000);
	
	$(".bannerwrap").mouseover(function(){
		$(".arrL").show();
		$(".arrR").show();
	});
	$(".bannerwrap").mouseout(function(){
		$(".arrL").hide();
		$(".arrR").hide();
	});
	
	$(".oddleft_wrap")[0].innerHTML += $(".oddleft_wrap")[0].innerHTML;
	$(".oddleft_wrap")[0].style.width=$(".futures")[0].offsetWidth*$(".futures").size()+"px";
	var i=0,iLeft=0;
	var timer1=null;
	$(".arrowleft_odds").click(function(){
		i++;
		if(i>=$(".futures").size()/2)
		{i=0}
		iLeft=i*$(".futures")[0].offsetWidth;
		$(".oddleft_wrap").animate({left:-iLeft+"px"});
	});
	setInterval(function(){
		i++;
		if(i>=$(".futures").size()/2)
		{i=0}
		iLeft=i*$(".futures")[0].offsetWidth;
		$(".oddleft_wrap").animate({left:-iLeft+"px"});
	},4000);
	
	$(".oddright_wrap")[0].innerHTML += $(".oddright_wrap")[0].innerHTML;
	$(".oddright_wrap")[0].style.width=$(".exchange")[0].offsetWidth*$(".exchange").size()+"px";
	var i2=0,iLeft2=0;
	$(".arrowright_odds").click(function(){
		i2++;
		if(i2>=$(".exchange").size()/2)
		{i2=0}
		iLeft2=i2*$(".exchange")[0].offsetWidth;
		$(".oddright_wrap").animate({left:-iLeft2+"px"});
	});
	setInterval(function(){
		i2++;
		if(i2>=$(".exchange").size()/2)
		{i2=0}
		iLeft2=i2*$(".exchange")[0].offsetWidth;
		$(".oddright_wrap").animate({left:-iLeft2+"px"});
	},4000);
});
function ShowjQueryFlash(i) {
	jQuery("#indexBgSwitch a").eq(i).animate({opacity: 1},300).css({"z-index": "1"},300).siblings().animate({opacity: 0},300).css({"z-index": "0"},300);
	jQuery("#bgSwitchNav li").eq(i).addClass("current").siblings().removeClass("current");
}

ShowjQueryFlash(0);

$(".gonggao").myScroll({
	speed: 80,
	rowHeight: 89
});

function seltab(id,sel,_this){
	$(_this).parent().find('span').removeClass('name');
	$(_this).addClass('name');
	$(sel).find('p').css({'display':'none'});
	$(sel).find('.tab' + id).css({'display':'block'});
}
seltab(1,'.tablist1');
seltab(1,'.tablist2');

!function($){
	$.fn.extend({
		sitegg : function(options){
			_this = $(this);
			var defaults = {
				interval : 5000,
				speed : 500,
				runbox :_this.find('ul'),
				item : _this.find('ul li')
			}
			var set = $.extend({},defaults,options);
			var timer;
			gonggao = {
				init : function(){
					//初始化
					current = 0;
					eqnum = set.item.length - 1;
					this.autorun();
					this.mouseover();
					this.mouseout();
				},
				autorun : function(){
					var t = this;
					this.timer = setInterval(function(){
						t.change()
					},set.interval);
				},
				stop : function(){
					clearInterval(this.timer);
				},
				change : function(){
					next = current+1 > eqnum ? 0 : current+1;
					this.animate();
					current = next;
				},
				animate : function(){
					itemh = -set.item.height();
					runTop = next * itemh;
					runbox = set.runbox;
					speed = set.speed;
					runbox.animate({'top':runTop},speed);
				},
				mouseover : function(){
					var t = this;
					set.item.mouseover(function(){
						t.stop();
					});
				},
				mouseout : function(){
					var t = this;
					set.item.mouseout(function(){
						t.autorun();
					});
				}
			}
			gonggao.init();
		}
	});
}(jQuery);