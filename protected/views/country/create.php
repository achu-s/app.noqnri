<?php
$this->breadcrumbs=array(
    'Countries'=>array('country/index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create Country</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>