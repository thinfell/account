<html>
<head>
    <title>login</title>
</head>
    <script language="javascript">
        setTimeout("process", 3000);
        function process() {
            var returnUrl = '<?=Yii::$app->session->get('from')?>';
            if (returnUrl) {
                window.location.href = returnUrl;
            } else if (document.referrer) {
                window.location.href = document.referrer;
            }
        }
    </script>
    <body onload="process();" style="display:none">
    <?php
        foreach ($website as $val) {
            ?>
            <img src="<?=$val->url?>sso/login?AuthenTickitRequestParamName=<?=$AuthenTickitRequestParamName?>"/>
            <?php
        }
    ?>
    </body>
</html>