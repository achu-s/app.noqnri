<?php
$this->breadcrumbs=array(
    'Admin'=>array('customer'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create Admin</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>