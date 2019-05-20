<p class="login-box-msg">please log in</p>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections'
    )
));
?>
<div  class="form-group has-feedback">
    <?php echo $form->textField($model, 'username', array('class'=>'form-control','placeholder' => 'Username')); ?>
    <?php echo $form->error($model,'username',array('style'=>'color:#FF0000'));?>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?php echo $form->passwordField($model, 'password', array('class'=>'form-control','placeholder' => 'Password')); ?>
    <?php echo $form->error($model,'password',array('style'=>'color:#FF0000')); ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo CHtml::tag('button', array(
	        'name'=>'loginform',
	        'class'=>'btn btn-block btn-flat loginbtn',
	        'type'=>'submit'
	      ), '<i class="ace-icon fa fa-key"></i><span class="bigger-110"> log in</span>'); ?>
        
    </div>
    <div class="col-xs-12">
        <div class="col-sm-6">
            <a href="javascript:void(0);" id="validate_card_forgot" style="float:left;padding-top:10px;">Forgot Password</a>
        </div>
        <div class="col-sm-6">
            <a href="javascript:void(0);" id="card_less_signup" style="float:right;padding-top:10px;">Request Card </a>
            <a href="javascript:void(0);" id="validate_card_signup" style="float:right;padding-top:10px;padding-right:10px;">Sign Up &nbsp;/</a>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>