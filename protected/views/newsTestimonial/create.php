<?php
$this->breadcrumbs=array(
    'News '=>array('NewtsTestimonials/index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create News & Testimonials</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>