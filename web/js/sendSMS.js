/**
 * Created by Administrator on 2016/9/14.
 */
var sendFlag = true;
var waitSecond = 60;
var interval;
// var actionId, sendButton
$(document).ready(function(){
    $('#' + sendButton + '').click(function(){
        if(!sendFlag) return false;
        sendFlag = false;
        $('#' + sendButton + '').addClass('disabled');
        $.ajax({
            url : "/sms/send",
            type : 'get',
            beforeSend : function () {

                //头疼的历史遗留问题 先放着吧

                var validateMobile = true;
                $('#' + actionId + '-form').yiiActiveForm('validateAttribute', '' + actionId + '-mobile');
                $('#' + actionId + '-form').on('afterValidateAttribute', function (e,o,m) {
                    if(m.length > 0){
                        validateMobile = false;
                        sendFlag = true;
                        $('#' + sendButton + '').removeClass('disabled');
                    }
                });
                return validateMobile;
            },
            data : {
                mobile:$('#' + actionId + '-mobile').val(),
                actionid:actionId,
            },
            success : function(result){
                if(result.code == 0){
                    $('#' + actionId + '-form').yiiActiveForm('updateAttribute', '' + actionId + '-'+result.attribute, [result.message]);
                    clearInterval(interval);
                    $('#' + sendButton + '').text('重新获取');
                    $('#' + sendButton + '').removeClass('disabled');
                    sendFlag = true;
                    waitSecond = 60;
                }else{
                    //验证码发送成功,接收短信ID
                    var smsid = result.message;
                    $('#' + actionId + '-smsid').val(smsid);
                    interval = setInterval(function () {
                        waitSecond--;
                        $('#' + sendButton + '').text('重新获取('+waitSecond+')');
                        if(waitSecond <= 0){
                            clearInterval(interval);
                            $('#' + sendButton + '').text('重新获取');
                            $('#' + sendButton + '').removeClass('disabled');
                            sendFlag = true;
                            waitSecond = 60;
                        }
                    },1000);
                }
            },
            error : function(result){
                $('#' + actionId + '-form').yiiActiveForm('updateAttribute', '' + actionId + '-mobile', ["网络异常,请重试。"]);
                clearInterval(interval);
                $('#' + sendButton + '').text('重新获取');
                $('#' + sendButton + '').removeClass('disabled');
                sendFlag = true;
                waitSecond = 60;
            }
        });
    });
});