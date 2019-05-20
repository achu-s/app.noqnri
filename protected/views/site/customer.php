<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Yii::app()->name;?> - Customer Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">   
      	<link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/favicon_fork.ico"> 
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/bootstrap.min.css">
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/font-awesome.min.css">
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/ionicons.min.css">
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/AdminLTE.css">
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/animate.min.css">
        <link rel="stylesheet" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/additional_style.css">
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.form-validator.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-notify.js"></script> 
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-notify.min.js"></script> 
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/signup.js"></script> 
    </head>
    <script type="text/javascript">
        var base_url = '<?php echo Yii::app()->request->baseUrl;?>';
    </script>
    <body class="hold-transition login-page" id="login">
        <div class="login-box" id="partner-login-box">
            <div class="login-logo">
                <a><img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/site_logo.png"></a>
            </div>
            <div class="login-box-body">
            	<div id="login_content">
                    <?php $this->renderPartial('//site/customer/_login',array('model' => $model));?>
                </div>
    			<div id="validate_card" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_validate_card',array('card'=>$card));?>
                </div>
                <div id="confirm_phone_number" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_confirm_phone_number',array('card'=>$card));?>
                </div>
                <div id="submit_otp" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_validate_otp',array('card'=>$card));?>
                </div>
                <div id="register_content" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_register',array('model' => $model,'customer'=>$customer,'login'=>$login,'card'=>$card));?>
                </div>
                <div id="password_reset" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_reset_password',array('login'=>$login));?>
                </div>
                <input type="hidden" id="is_signup">
			</div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                console.log('app started');
                <?php if (Yii::app()->user->hasFlash('success_flash_msg')){?>
                    $.notify({
                        icon: "fa fa-check",
                        message: "<?php echo Yii::app()->user->getFlash('success_flash_msg');?>"
                    },{
                        type: "success"
                    });
                <?php } ?>
                <?php if (Yii::app()->user->hasFlash('error_flash_msg')){ ?>
                    $.notify({
                      icon: "fa fa-times",
                      message: "<?php echo Yii::app()->user->getFlash('error_flash_msg');?>"
                    },{
                      type: "error"
                    });
                <?php } ?>
            });
        </script>
    </body>
</html>