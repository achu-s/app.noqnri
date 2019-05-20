<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'city-form',
    'enableAjaxValidation'=>true,
)); ?>
  	<div class="col-md-6">
      	<div class="box box-primary">
        	<div class="box-header with-border"></div>
            <div class="box-body">
        		<div class="form-group">
              		<div class="form-group has-feedback">
                  		<?php echo $form->labelEx($model,'state_name'); ?>
                        <?php echo $form->textField($model, 'state_name', array('class'=>'form-control','placeholder'=>'State Name','value'=>($state->state_name)?$state->state_name:'','readonly'=>true)); ?>
                        <?php echo $form->error($model,'state_name'); ?>
                        <?php echo $form->hiddenField($model, 'state_id',array('value'=>$state->id)); ?>
              		</div>
	                <div class="form-group">
	                    <?php echo $form->labelEx($model,'name'); ?>
	                    <?php echo $form->textField($model,'name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Name')); ?>
	                    <?php echo $form->error($model,'name'); ?>
	                </div>
                	<div class="form-group">
	                	<?php $this->widget('bootstrap.widgets.TbButton', array(
	                		'buttonType'=>'submit',
	                		'type'=>'primary',
	                	    'htmlOptions'=>array('id'=>'submit_reg'),
	                		'label'=>$model->isNewRecord ? 'Save' : 'Update',
	                	)); ?>
	                	<?php if(!$model->id){?>
	                	<?php echo CHtml::htmlButton('Reset',array(
	                            "id"=>'chtmlbutton',
	                          "class"=>'btn btn-secondary'
	                          
	                      ));?>
	                  	<?php }?>
	                  	<?php echo CHtml::link('Cancel',array('city/index'),array('class'=>'btn btn-danger')); ?>
               		</div>
        		</div> 
			</div>
		</div>
	</div>	
<?php $this->endWidget(); ?>