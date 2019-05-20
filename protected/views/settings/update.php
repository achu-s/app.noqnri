<?php
$this->breadcrumbs=array(
    'Settings'=>array('Update'),
);
?>
<div class="box">
    <div class="box-body">
        <h1>Update Settings</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>
