<?php
    $this->breadcrumbs=array(
        'Countries'=>array('country/index'),
        'Update',
    );
?>
<div class="row">
    <div class="box">
        <div class="box-body">
            <h1>Update Country - <?php echo $model->country_name;?></h1>
            <hr>
            <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
        </div>
    </div>
</div>