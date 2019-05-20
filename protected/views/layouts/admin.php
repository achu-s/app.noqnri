<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->pageTitle?></title>
  <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/favicon.png"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/custom.css" media="screen">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/select2.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/jquery.fancybox.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/bootstrap-switch.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/kartik-v-bootstrap/css/fileinput.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/kartik-v-bootstrap/themes/explorer/theme.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/sweetalert.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/sweetalert-overrides.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/css/additional_style.css">
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery-1.11.3.js"></script> 
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-switch.js"></script> 
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-notify.js"></script> 
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-notify.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.form-validator.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/kartik-v-bootstrap/js/fileinput.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/kartik-v-bootstrap/js/plugins/sortable.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/kartik-v-bootstrap/themes/explorer/theme.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/sweetalert.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/sweetalert-init.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/admin.js"></script> 
</head>
<script type="text/javascript">
	var Baseurl = '<?php echo Yii::app()->request->baseUrl; ?>';
</script>
<body class="hold-transition skin-blue sidebar-mini">
	<?php echo $this->renderPartial('//layouts/header', array()); 
      if (!$this->hideSidebar) {
          echo $this->renderPartial('//layouts/sidebar', array());
      }?>
	<div class="wrapper">
		<div class="content-wrapper">
             <section class="content-header">
                <h1>
                    <?php echo isset($this->page_title) ? $this->page_title : ''; ?> 
                </h1>  
                <div class="clear"></div>                                                                                                                                                 
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs,
                        'homeLink' => CHtml::link('<i class="fa fa-dashboard"></i>Home', Yii::app()->createAbsoluteUrl('Dashboard')),
                    ));                        
                    ?>
            	<?php endif ?>
            </section>
			<?php echo $content; ?>
		</div>
		<?php echo $this->renderPartial('//layouts/footer', array()); ?>
 </body>
 <div class="se-pre-con"></div>
</html>
