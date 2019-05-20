<?php
    $this->breadcrumbs = array(
    $country->country_name=>array('country/index'),
    $state->state_name=>array('state/index/country_id/'.$country->id),
    'Update'
);
?>
<div class="row">
    <div class="box">
        <div class="box-body">
            <h1>Update City - <?php echo $model->name;?></h1>
            <hr>
            <?php echo $this->renderPartial('_form',array('model'=>$model,'state'=>$state)); ?>
        </div>
    </div>
</div>