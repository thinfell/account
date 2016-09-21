<?php

namespace app\controllers;

use Yii;

class SsoApiController extends \yii\web\Controller
{

    public function actionLogin()
    {
        ?>
        <html>
        <head>
            <title></title>
        </head>
        <script language="javascript">
            function process() {
                var returnUrl = '<?=Yii::$app->request->get('from')?>';
                if (returnUrl) {
                    window.location.href = returnUrl;
                }
                else if (document.referrer) {
                    window.location.href = document.referrer;
                }
            }
        </script>
        <script language="javascript">
            setTimeout("process", 3000);
        </script>
        <body onload="process()">
        <img style="display:none" src="http://a.com/sso/login?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://b.com/sso/login?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://c.com/sso/login?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://account.chelintong.com/sso/login?account=15556666551&AuthenTickitRequestParamName=yes"/>
        </body>
        </html>
        <?php

    }

    public function actionLogout()
    {
        ?>
        <html>
        <head>
            <title></title>
        </head>
        <script language="javascript">
            function process() {
                var returnUrl = '<?=Yii::$app->request->get('from')?>';
                if (returnUrl) {
                    window.location.href = returnUrl;
                }
                else if (document.referrer) {
                    window.location.href = document.referrer;
                }
            }
        </script>
        <script language="javascript">
            setTimeout("process", 3000);
        </script>
        <body onload="process()">
        <img style="display:none" src="http://a.com/sso/logout?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://b.com/sso/logout?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://c.com/sso/logout?account=15556666551&AuthenTickitRequestParamName=yes"/>
        <img style="display:none" src="http://account.chelintong.com/sso/logout?account=15556666551&AuthenTickitRequestParamName=yes"/>
        </body>
        </html>
        <?php
    }

}
