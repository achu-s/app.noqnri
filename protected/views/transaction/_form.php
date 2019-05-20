<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'transaction-form',
    'enableAjaxValidation'=>true,
)); ?>
<div class="row">
  <div class="col-md-6">
     <div class="box box-primary">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
				  <div class="form-group has-feedback"">
            	<?php echo $form->labelEx($model,'card_id'); ?>
            	<?php 
            	$type_list=CHtml::listData(Card::model()->findAllByAttributes(array('card_issue_status'=>'Approved')),'id','card_number');
            	echo CHtml::activeDropDownList($model,'card_id',$type_list,array('class'=>'form-control select2 special','empty'=>'Select Option','data-validation'=>'required')); 
            	?>
          </div>
          <div class="form-group">
              <?php echo $form->labelEx($model,'trans_amount'); ?>
              <?php echo $form->textField($model,'trans_amount',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Transaction Amount','data-validation'=>'required')); ?>
              <?php echo $form->error($model,'trans_amount'); ?>
          </div>
          <div  class="form-group has-feedback">
              <?php echo $form->labelEx($model,'trans_note'); ?>
              <?php echo $form->textArea($model, 'trans_note', array('class'=>'form-control editors','autocomplete'=>'off','placeholder' => 'Transaction Note','data-validation'=>"required",'rows'=>'4','value'=>isset($model->trans_note)?nl2br($model->trans_note):'')); ?>
              <?php echo $form->error($model,'trans_note',array('style'=>'color:#FF0000'));?>
          </div>
          <div class="form-group">
              <label>Transaction Date</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <?php echo $form->textField($model, 'trans_date', array('class'=>'form-control date date_picker','placeholder' => 'Transaction Date','data-validation'=>"required",'data-validation'=>'required')); ?>
                <?php echo $form->error($model,'trans_date',array('style'=>'color:#FF0000'));?>
              </div>
        </div>
        <div class="form-group">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'submit',
              'type'=>'primary',
                'htmlOptions'=>array('id'=>'submit_reg'),
              'label'=>$model->isNewRecord ? 'Save' : 'Update',
            )); ?>
            <?php if(!$model->id){?>
            <?php
                  echo CHtml::htmlButton('Reset',array(
                      "id"=>'chtmlbutton',
                      "class"=>'btn btn-secondary'
                  ));
              ?>
              <?php }?>
              <?php echo CHtml::link('Cancel',array('transaction/index'),array('class'=>'btn btn-danger')); ?>
           </div>
				</div> 
			</div>
		</div>
	</div>
</div>	
<?php $this->endWidget(); ?>