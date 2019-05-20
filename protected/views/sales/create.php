<?php
$this->breadcrumbs=array(
    $partner->name=>array('sales/index?parent_id='.$partner->id),
    'create',
);

?>
<div class="box">
    <div class="box-body">
        <h1>Create <?php echo $partner->name?> Users</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData)); ?>
    </div>
</div>