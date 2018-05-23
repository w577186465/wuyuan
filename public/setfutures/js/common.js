/**
 * 全局js文件
 * */

/**兼容IE的去空格函数*/

String.prototype.trim = function() {
    return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

/*
 * 验证手机号
 * @param {type} String phone 需要验证的手机号
 * @returns {Boolean}
 */
function isPhoneNo(phone) {
    var pattern = /^1[34578]\d{9}$/;
    return pattern.test(phone);
}

/*返回顶部*/
$(function(){

    $(window).scroll(function() {

        if($(window).scrollTop() >= 100){

            $('.fhdb').fadeIn(300);

        }else{

            $('.fhdb').fadeOut(300);

        }

    });

    $('.fhdb').click(function(){

        $('html,body').animate({scrollTop: '0px'}, 800);});   

});
//登录鼠标悬浮
$(function(){
    $(".un-login").hover(function(){
        $('.loginuser').show();
    },function(){
        $('.loginuser').hide();
    })
    
    // $(".loginuser").hover(function(){
    //     $(this).show();
    // },function(){
    //     $(this).hide();
    // })
})
 //登录鼠标悬浮
// $(function(){
//     var index=1;
//     $(".un-login").on("hover",function(){
//         if(index==1){
//             $('.loginuser').show();
//             index=2
//         }else if(index==2){
//             $('.loginuser').hide();
//             index=1  
//         }
//     })
//     $(".loginuser").hover(function(){
//         $(this).show();
//     },function(){
//         $(this).hide();
//     })
// })
/*右侧二维码*/

$(function(){
    $(".aqq").mouseover(function(){
        $(".zx").show()
    });
    $(".aqq").mouseout(function(){
        $(".zx").hide()
    });
});

 // function showVoteDialog(id){
 //        var html = '';
 //            html=id
 //        layui.use('layer', function(){
 //        layer = layui.layer;
 //        layer.alert(html);
 //        })
 //    }
 
 function showVoteDialog(contxt){
     if(dachang===1){
         var html =$('<div class="dpublic-tips dpublic-tipsss"><div class="dpublic-tips-shade"></div><div class="dpublic-tips-dialog"><div class="dpublic-tips-title">提示<span class="dpublic-tips-setwin"><a class="dpublic-tips-ico dpublic-tips-close" href="javascript:;"></a></span></div><div class="dpublic-tips-content">'+contxt+'</div><div class="dpublic-tips-btn"><a class="dpublic-tips-btnok cobtn wd">确定</a></div></div></div>') ;
         html.appendTo('body');
         dachang=2;
     }
    $(".cobtn,.dpublic-tips-close").click(function(){
        dachang=1;
        $('.dpublic-tipsss').remove();

        })
 }

 function PromptBox(txt){
        var msgbox = '';
            msgbox=txt
        layui.use('layer', function(){
        layer = layui.layer;
        layer.msg(msgbox);
        })
    }

var promptTips = {
    message:function(text){

        var str = $('<div class="popMessage"></div><div class="mobileMessage"><span class="msgclose">×</span><div class="title_tip">提示</div><div class="msg_pubcon"><p class="msg_pubtext">'+text+'</p><button class="msg_determine">确定</button></div></div>')
        str.appendTo('body');

        $(".msg_determine,.msgclose").click(function(){
            $('.mobileMessage').remove();

        })
    }
};

//显示提示框，参数(poptxt：显示内容的文本；type：类型0链接、不是0方法；linkme：链接/方法（确定、是）；linktxt：a链接跳转/方法（取消、否）；cleneb:onclick方法；)
var dachang=1;
function showTipsPop(poptxt,type,linkme,linktxt,cleneb){
    if(dachang===1){
        var showtxt = '';
        if(type != 0 && type != undefined){
            showtxt = '<div class="dpublic-tips dpublic-tipss"><div class="dpublic-tips-shade"></div><div class="dpublic-tips-dialog"><div class="dpublic-tips-title">提示<span class="dpublic-tips-setwin"><a class="dpublic-tips-ico dpublic-tips-close" href="javascript:;"></a></span></div><div class="dpublic-tips-content">'+poptxt+'</div><div class="dpublic-tips-btn"><a class="dpublic-tips-btnok deter-btn cobtns" onclick="'+linkme+'">'+linktxt+'</a><a class="dpublic-tips-btnok cobtns gy">'+cleneb+'</a></div></div></div>';
        }else{
            if(cleneb!=''&&cleneb!=null){
                showtxt = '<div class="dpublic-tips dpublic-tipss"><div class="dpublic-tips-shade"></div><div class="dpublic-tips-dialog"><div class="dpublic-tips-title">提示<span class="dpublic-tips-setwin"><a class="dpublic-tips-ico dpublic-tips-close" href="javascript:;"></a></span></div><div class="dpublic-tips-content">'+poptxt+'</div><div class="dpublic-tips-btn"><a class="dpublic-tips-btnok deter-btn" onclick="'+linkme+'">'+linktxt+'</a><a class="dpublic-tips-btnok cobtns gy">'+cleneb+'</a></div></div></div>';
            }else{
                showtxt = '<div class="dpublic-tips dpublic-tipss"><div class="dpublic-tips-shade"></div><div class="dpublic-tips-dialog"><div class="dpublic-tips-title">提示<span class="dpublic-tips-setwin"><a class="dpublic-tips-ico dpublic-tips-close" href="javascript:;"></a></span></div><div class="dpublic-tips-content">'+poptxt+'</div><div class="dpublic-tips-btn"><a class="dpublic-tips-btnok cobtns wd" target="_blank" href="' +linkme+ '">'+linktxt+'</a></div></div></div>';
            }
        }
        dachang=2;
    }

    $('body').prepend(showtxt);
    $(".cobtns,.dpublic-tips-close").click(function(){
            dachang=1;
            $('.dpublic-tipss').remove();

        })
}


// $('body').on('click','.cobtn,.dpublic-tips-close',function(){
//     $('.dpublic-tips').remove();

// })