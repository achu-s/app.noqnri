<?php
	$this->breadcrumbs = array(
    $country->country_name=>array('country/index'),
    $state->state_name=>array('state/index/country_id/'.$country->id),
    'Create'
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create City</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model,'state'=>$state)); ?>
    </div>
</div>