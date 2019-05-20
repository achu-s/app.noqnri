<?php
$this->breadcrumbs=array(
    'News & Evants '=>array('newsTestimonial/index'),
    'Update',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Update Privillage Updates</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>