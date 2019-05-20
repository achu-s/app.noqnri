<?php
$this->breadcrumbs=array(
    'Transaction'=>array('transaction/index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
		<h1>Create Transaction</h1>
		<br>
		<hr>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>