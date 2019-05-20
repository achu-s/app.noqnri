<?php
$this->breadcrumbs=array(
	$country->country_name=>array('country/index'),
    'States'=>array('state/index/country_id/'.$country->id),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Create state</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('model'=>$model,'country'=>$country)); ?>
    </div>
</div>