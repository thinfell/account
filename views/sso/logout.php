<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/21
 * Time: 16:09
 */
?>
<script>
    $(document).ready(function () {
        ssohelper('a.com', 'logout');
        ssohelper('b.com', 'logout');
        ssohelper('c.com', 'logout');
    });
    function ssohelper(web, aciton) {
        $.ajax({
            type: "get",
            async: !1,
            url: 'http://' + web + '/index.php?r=sso/' + aciton + '&account=15556666551&AuthenTickitRequestParamName=yes',
            dataType: "jsonp",
            jsonp: "callback",
            complete: function (t) {
                if (4 == t.readyState && 200 == t.status) {
                    console.log('sso-' + aciton + '成功');
                    window.location.href="<?=$form?>";
                }
            }
        });
    }
</script>
