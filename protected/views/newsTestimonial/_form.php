<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'admin-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border"></div>
            <div class="box-body">
        		<div class="form-group">
              		<div  class="form-group has-feedback">
                        <?php echo $form->labelEx($model,'description'); ?>
                        <?php echo $form->textArea($model, 'description', array('class'=>'form-control','autocomplete'=>'off','placeholder' => 'Description','data-validation'=>"required",'rows'=>'4','value'=>isset($model->description)?nl2br($model->description):'')); ?>
                        <?php echo $form->error($model,'description',array('style'=>'color:#FF0000'));?>
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
	                  <?php echo CHtml::link('Cancel',array('newsTestimonials'),array('class'=>'btn btn-danger')); ?>
	               	</div>
    			</div> 
    		</div>
	</div>
</div>
<?php $this->endWidget(); ?>