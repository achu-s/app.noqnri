<?php
$this->breadcrumbs=array(
    'Category List'=>array('category/index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create Category</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model,'parentId'=>$parentId,'parentData'=>$parentData)); ?>
    </div>
</div>