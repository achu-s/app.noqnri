<?php
$this->breadcrumbs=array(
    'Customer'=>array('index'),
    'update',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Update Customer</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('customer'=>$customer,'addressess'=>$addressess,'location'=>$location,'phone'=>$phone,'phones'=>$phones,'add'=>$add,'imageData'=>$imageData)); ?>
    </div>
</div>