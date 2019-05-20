<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'state-form',
    'enableAjaxValidation'=>true,
)); ?>
  	<div class="col-md-6">
      	<div class="box box-primary">
        	<div class="box-header with-border"></div>
            <div class="box-body">
        		<div class="form-group">
                    <div class="form-group has-feedback">
                  		<?php echo $form->labelEx($model,'country_name'); ?>
                        <?php echo $form->textField($model, 'country_name', array('class'=>'form-control','placeholder'=>'Country Name','value'=>($country->country_name)?$country->country_name:'','readonly'=>true)); ?>
                        <?php echo $form->error($model,'country_name'); ?>
                        <?php echo $form->hiddenField($model, 'country_id',array('value'=>$country->id)); ?>
              		</div>

	                <div class="form-group">
	                    <?php echo $form->labelEx($model,'state_name'); ?>
	                    <?php echo $form->textField($model,'state_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'State Name')); ?>
	                    <?php echo $form->error($model,'state_name'); ?>
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
	                  	<?php echo CHtml::link('Cancel',array('state/index'),array('class'=>'btn btn-danger')); ?>
               		</div>
        		</div> 
			</div>
		</div>
	</div>	
<?php $this->endWidget(); ?>