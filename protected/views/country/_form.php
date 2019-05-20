<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'country-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
  	<div class="col-md-6">
      	<div class="box box-primary">
        	<div class="box-header with-border"></div>
            <div class="box-body">
        		<div class="form-group">
                    <div class="form-group">
	                    <?php echo $form->labelEx($model,'country_code'); ?>
	                    <?php echo $form->textField($model,'country_code',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','value'=>$model->country_code,'placeholder'=>'Country Code')); ?>
	                    <?php echo $form->error($model,'country_code'); ?>
                    </div>
	                <div class="form-group">
	                    <?php echo $form->labelEx($model,'country_name'); ?>
	                    <?php echo $form->textField($model,'country_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Country Name')); ?>
	                    <?php echo $form->error($model,'country_name'); ?>
	                </div>
	                <div class="form-group">
	                    <?php echo $form->labelEx($model,'country_phone_code'); ?>
	                    <?php echo $form->textField($model,'country_phone_code',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Country Phone Code')); ?>
	                    <?php echo $form->error($model,'country_phone_code'); ?>
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
	                  	<?php echo CHtml::link('Cancel',array('country/index'),array('class'=>'btn btn-danger')); ?>
               		</div>
        		</div> 
			</div>
		</div>
	</div>	
<?php $this->endWidget(); ?>