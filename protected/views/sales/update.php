<?php
$this->breadcrumbs=array(
    $partner->name=>array('index?parent_id='.$model->parent_id),
    'update',
);

?>
<div class="box">
    <div class="box-body">
        <h1>Update <?php echo $partner->name;?> User</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData)); ?>
    </div>
</div>