<?php
$this->breadcrumbs=array(
    'Customer'=>array('index'),
    'create',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Update Customer</h1>
        <br>
        <hr>
        <?php echo $this->renderPartial('_form', array('partner'=>$partner,'address'=>$address,'location'=>$location,'phone'=>$phone)); ?>
    </div>
</div>