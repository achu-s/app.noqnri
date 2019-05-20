<?php
$this->breadcrumbs=array(
    'admin'=>array('index'),
    'update',
);
?>
<div class="row">
    <div class="box">
        <div class="box-body">
            <h1>Update <?php echo $model->first_name." ".$model->last_name;?></h1>
            <?php echo CHtml::link('<i class="fa fa-angle-double-left" aria-hidden="true"></i> back', $this->createUrl('admin/index'), array('class' => 'btn btn-primary pull-right btn-sm view-btn')); ?>
            <br>
            <hr>
            <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
        </div>
    </div>
</div>