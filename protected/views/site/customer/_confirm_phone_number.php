<p class="login-box-msg">Enter Phone Number</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'confirm_phone_number',
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
            <?php echo $form->textField($card, 'card_number', array('id'=>'conform_card_number','class'=>'form-control','placeholder' => '10 Digit Card Number','autocomplete'=>"off",'maxlength'=>"10",'readonly'=>true,'data-validation'=>"required")); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="validate_class"></span>
        </div>
        <div  class="form-group has-feedback" id="phone_number">
            <?php echo $form->textField($card, 'phone_number', array('id'=>'conform_phone_number','class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>"off",'data-validation'=>"required")); ?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div class="button_box"id="button_box">
            <div class="row">
                <div class="col-xs-12">
                    <span id="span_msg"></span>
                    <button name="forgotform" id="validate_phone_btn" type="submit" class="btn btn-block btn-flat loginbtn">Confirm phone number & send OTP</button>
                    <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_card_form">Back</a>
                </div>
            </div>    
        </div>            
<?php $this->endWidget(); ?>