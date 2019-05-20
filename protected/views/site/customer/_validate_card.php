<p class="login-box-msg">Validate Card</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'validate_card',
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
            <?php echo $form->numberField($card, 'card_number', array('class'=>'form-control','placeholder' => 'Card Number','autocomplete'=>"off",'maxlength'=>"10",'data-validation'=>"required")); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="validate_class"></span>
        </div>
        <div class="button_box"id="button_box">
            <div class="row">
                <div class="col-xs-12">
                    <span id="span_msg"></span>
                    <button name="forgotform" id="validate_card_btn" type="submit" class="btn btn-block btn-flat loginbtn">Validate card</button>
                    <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_login_form">Back</a>
                </div>
            </div>    
        </div>            
<?php $this->endWidget(); ?>