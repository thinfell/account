<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/21
 * Time: 16:09
 */
$this->registerJs('
    $(document).ready(function () {
        ssohelper(\'a.com\', \'login\');
        ssohelper(\'b.com\', \'login\');
        ssohelper(\'c.com\', \'login\');
        ssohelper(\'account.chelintong.com\', \'login\');
    });
    function ssohelper(web, aciton) {
        $.ajax({
            type: "get",
            async: !1,
            url: \'http://\' + web + \'/sso/\' + aciton + \'?account=15556666551&AuthenTickitRequestParamName=yes\',
            dataType: "jsonp",
            jsonp: "callback",
            complete: function (t) {
                if (4 == t.readyState && 200 == t.status) {
                    console.log(\'sso-\' + aciton + \'成功\');
                    window.location.href="'.$from.'";
                }
            }
        });
    }
');
?>
