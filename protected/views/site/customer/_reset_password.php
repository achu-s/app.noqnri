<p class="login-box-msg">Forgot Password</p>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'forgot-form',
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
        <?php echo $form->PasswordField($login, 'password', array('id'=>'Login_password_reset','class'=>'form-control','placeholder' => 'Password','autocomplete'=>"off",'data-validation'=>"required")); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <span id="result_password"></span>&nbsp&nbsp <span id="password_strength_reset"></span>
    </div>
    <div  class="form-group has-feedback">
        <?php echo $form->PasswordField($login, 'confirm_password', array('id'=>'Login_confirm_password_reset','class'=>'form-control','placeholder' => 'Confirm Password','autocomplete'=>"off",'data-validation'=>"required")); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <span id="result_confirm_password"></span>&nbsp&nbsp <span id="password_strength_reset_confirm"></span>
    </div>
    <div class="button_box"id="button_box">
    	<div class="row">
            <div class="col-xs-12">
                <span id="span_msg"></span>
                <input type="hidden" name="Login[username_input]" id="Login_username_input">
                <input type="hidden" name="Login[userType]" value="0"/>
                <button name="forgotform" id="forgot_pass_btn" type="submit" class="btn btn-block btn-flat loginbtn">Submit</button>
                <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_submit_otp_form">Back</a>
            </div>
        </div>
    </div>         
<?php $this->endWidget(); ?>