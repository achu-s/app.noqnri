<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="<?php echo Yii::app()->baseUrl;?>"><?php echo Yii::app()->name;?></a>.</strong> All rights
    reserved.
  </footer>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/raphael.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.knob.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/moment.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/fastclick.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/adminlte.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/select2.full.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.fancybox.min.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/js/jquery.ba-bbq.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        console.log('app started');
        <?php if (Yii::app()->user->hasFlash('success')){?>
            $.notify({
                icon: "fa fa-check",
                message: "<?php echo Yii::app()->user->getFlash('success');?>"
            },{
                type: "success"
            });
        <?php } ?>
        <?php if (Yii::app()->user->hasFlash('error')){ ?>
            $.notify({
              icon: "fa fa-times",
              message: "<?php echo Yii::app()->user->getFlash('error');?>"
            },{
              type: "error"
            });
        <?php } ?>
    });
</script>