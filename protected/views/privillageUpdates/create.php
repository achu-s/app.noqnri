<?php
$this->breadcrumbs=array(
    'Privillage '=>array('category/index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create Privillage Updates</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>