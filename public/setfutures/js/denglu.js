    $(function(){
        // 弹窗的js
         $(".dl_mask").on("click",function(){
            $('#err_msg').text('');
            $(".dl_zh").css("display","block");
            $(".dl_tc").css("display","block");
            $(".dl_ptf").css("display","none");
            $(".dl_dsf").css("display","block");
            $(".dl_zz").css("display","none");
            $(".dd_zz").css("display","block");
        })
        $(".dl_cha").on("click",function(){
            //解开注释就可以只清空注册表单，而不会清空登录表单
                $('.dl_f')[0].reset();
                countdown='';
                $('#err_msg').text('');
                logoshu=2
            $('body').removeClass('jzgd');
            $(".dl_zh").css("display","none");
            $(".dl_tc").css("display","none");
        })
        //判断密码长度
        $("#reg_pwd").change( function() {
            if($('#reg_pwd').val().length < 6||$('#reg_pwd').val().length > 20){
                $('#err_msg').text("密码必须在6~20位之间!");
                return false;
             }else{
                $('#err_msg').text('');
             }
        });
        $(".dl_ptf").on("click",function(){
            $(this).css("display","none");
            $(".dl_dsf").css("display","block");
        })
         $(".dl_sq").on("click",function(){
            $(".dl_dsf").css("display","none");
            $('.dl_qt').css('margin-top','11px')
            $(".dl_ptf").css("display","block");
        })

         //注册页面的js
         $(".dd_clause_l").on("click",function(){
            //登录和注册页面切换的时候默认让文字先显示第三方图标影藏
            $(".dl_ptf").css("display","none");
            $(".dl_dsf").css("display","block");

            $(".dd_zz").css("display","none");
            $(".dl_zz").css("display","block");
         })

         //登录页面的js
         $(".dl_clause_r").on("click",function(){
            //登录和注册页面切换的时候默认让文字先显示第三方图标影藏
            $('#err_msg').text('');

            $(".dl_ptf").css("display","none");
            $(".dl_dsf").css("display","block");
            $(".dl_zz").css("display","none");
            $(".dd_zz").css("display","block");
         })
         //单击侧边注册按钮直接进入注册页面
         $(".left_nav_b_z").on("click",function(){
             $(".dl_zh").css("display","block");
             $(".dl_tc").css("display","block");
             $(".dl_ptf").css("display","none");
            $(".dl_dsf").css("display","block");
            $(".dd_zz").css("display","none");
            $(".dl_zz").css("display","block");
         })
    });

// 原生写的倒计时 页面位置的class="dl_btn"
var countdown=60;
function settime(obj) {
    if (countdown == 0) {
        obj.removeAttribute("disabled");
        obj.value="免费获取验证码";
        countdown = 60;
        return;
    } else {
        obj.setAttribute("disabled", true);
        obj.value="重新发送(" + countdown + ")";
        countdown--;
    }
setTimeout(function() {
    settime(obj) }
    ,1000)
}

