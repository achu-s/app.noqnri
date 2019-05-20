<?php
$this->breadcrumbs=array(
    'Partner'=>array('admin'),
    'update',
);

?>
<div class="box">
        <div class="box-body">        
        <h1>Update Partner</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('partner'=>$partner,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'phones'=>$phones,'photos'=>$photos,'photoModel'=>$photoModel)); ?>
    </div>
</div>