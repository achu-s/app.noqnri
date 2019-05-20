<?php
if($parentData){
    $this->breadcrumbs=array(
        'Category List'=>array('category/index'),
        $parentData->category=>array('category/CategoryList?parentId='.$parentId),
        'Update',
    );
}else{
    $this->breadcrumbs=array(
        'Category List'=>array('category/index'),
        'Update',
    );
}
?>
<div class="row">
    <div class="box">
        <div class="box-body">
            <h1>Update Category - <?php echo $model->category;?></h1>
            <hr>
            <?php echo $this->renderPartial('_form',array('model'=>$model,'parentId'=>$parentId,'parentData'=>$parentData)); ?>
        </div>
    </div>
</div>