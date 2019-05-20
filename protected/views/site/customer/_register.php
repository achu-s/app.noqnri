<p class="login-box-msg">Register as new customer</p>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections',
        'enctype' => 'multipart/form-data'
    )
));
?>
<div class="row">
	<div class="col-xs-12">
    <div class="col-sm-6">
        <div  class="form-group has-feedback">
        	<?php echo $form->labelEx($customer,'first_name'); ?>
            <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','data-validation'=>"required")); ?>
            <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>  
        <div  class="form-group has-feedback">
          <?php echo $form->labelEx($customer,'indian_contact_number'); ?>
            <?php echo $form->numberField($customer, 'indian_contact_number', array('class'=>'form-control','placeholder' => 'Contact Number (Indian)','data-validation'=>"required",'onKeyup'=>'checkUnity(this,"indian_contact_number","Customer")')); ?>
            <?php echo $form->error($customer,'indian_contact_number',array('style'=>'color:#FF0000'));?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div> 
        <div  class="form-group has-feedback">
        	<?php echo $form->labelEx($customer,'email'); ?>
            <?php echo $form->textField($customer, 'email', array('class'=>'form-control','placeholder' => 'Email','onKeyup'=>'checkUnity(this,"email","Customer")')); ?>
            <?php echo $form->error($customer,'email',array('style'=>'color:#FF0000'));?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span id="email"></span>
        </div> 
        <div class="form-group has-feedback">
        	  <?php echo $form->labelEx($login,'username'); ?>
              <?php echo $form->textField($login, 'username', array('class'=>'form-control','placeholder' => 'Username','data-validation'=>"alphanumeric",'data-validation-allowing'=>"-_.",'onKeyup'=>'checkUnity(this,"username","Login")','value'=>$PhoneData->card_number,'readonly'=>true)); ?>
              <?php echo $form->error($login,'username',array('style'=>'color:#FF0000'));?>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
              <span id="username"></span>
        </div> 
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($login,'password'); ?>
              <?php echo $form->passwordField($login, 'password', array('class'=>'form-control','placeholder' => 'Password','data-validation'=>'length','data-validation-length'=>'8-15')); ?>
              <?php echo $form->error($login,'password',array('style'=>'color:#FF0000'));?>
              <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              <span id="result"></span>&nbsp&nbsp <span id="password_strength"></span>
        </div>
	  </div>
    <div class="col-sm-6">
      <div  class="form-group has-feedback">
        <?php echo $form->labelEx($customer,'last_name'); ?>
          <?php echo $form->textField($customer, 'last_name', array('class'=>'form-control','placeholder' => 'Last Name','data-validation'=>"required")); ?>
          <?php echo $form->error($customer,'last_name',array('style'=>'color:#FF0000'));?>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>  
      <div  class="form-group has-feedback">
        <?php echo $form->labelEx($customer,'indian_address'); ?>
          <?php echo $form->textArea($customer, 'indian_address', array('class'=>'form-control editors','autocomplete'=>'off','placeholder' => 'Permement Indian Address','data-validation'=>"required",'rows'=>'5','value'=>isset($customer->indian_address)?nl2br($customer->indian_address):'')); ?>
          <?php echo $form->error($customer,'indian_address',array('style'=>'color:#FF0000'));?>
      </div>
      <div class="form-group has-feedback">
          <?php echo $form->labelEx($login,'confirm_password'); ?>
            <?php echo $form->passwordField($login, 'confirm_password', array('class'=>'form-control','placeholder' => 'Confirm Password','data-validation'=>'length','data-validation-length'=>'8-15')); ?>
            <?php echo $form->error($login,'confirm_password',array('style'=>'color:#FF0000'));?>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            <span id="result_confirm"></span>&nbsp&nbsp <span id="password_strength_confirm"></span>
      </div>
      <!--<div class="form-group has-feedback">
        <div class="g-recaptcha form-group" data-sitekey="6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb" data-validation="recaptcha" data-validation-recaptcha-sitekey="6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb"></div>
        <span class="error" id="captcha_error" style="color:#dd4b39"></span>
      </div>-->  
      <div class="form-group">
          <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
              'htmlOptions'=>array('id'=>'submit_registration'),
            'label'=>'Register',
          )); ?>
          <a href="<?php echo Yii::app()->baseUrl.'/site/'?>" class="btn btn-danger common_regist" id="back_to_otp_submit_form">Back</a>
          <input type="hidden" id="card_id" name="card_id">
          <img id="reg_loading" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/loading_second.gif" style="display:none;">
       </div>  
    </div>                 
  </div>
</div>
<?php $this->endWidget(); ?>
<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->