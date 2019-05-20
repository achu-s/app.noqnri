<?php
$this->breadcrumbs=array(
    'Privillage Update'=>array('index'),
    'view',
);

?>
<div class="box">
  	<div class="box-body">
	   	<h1>View Privillage Update</h1>
	   	<br>
	   	<hr>
	    <?php
	    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	        'id'=>'privillage-updates-form',
	        'enableAjaxValidation'=>true,
	    )); ?>
	    <div class="row">
	      	<div class="col-md-6">
			    <div class="box box-primary">
			        <div class="box-header with-border"></div>
			            <div class="box-body">
			        		<div class="form-group">
				                <div class="form-group has-feedback">
			                  		<?php echo $form->labelEx($model,'partner_id'); ?>
			                        <?php echo $form->dropDownList($model, 'partner_id', CHtml::listData(Partner::model()->findAll(), 'id', 'name'),array('class'=>'form-control select2 special','empty'=>'Select Partner','data-validation'=>"required",'data-placeholder'=>"Select Partner",'options' => array($model->partner_id=>array('selected'=>true))));?>
			                        <?php echo $form->error($model,'partner_id'); ?>
			              		</div>
			              		<div  class="form-group has-feedback">
			                        <?php echo $form->labelEx($model,'description'); ?>
			                        <?php echo $form->textArea($model, 'description', array('class'=>'form-control','autocomplete'=>'off','placeholder' => 'Description','data-validation'=>"required",'rows'=>'4','value'=>isset($model->description)?nl2br($model->description):'')); ?>
			                        <?php echo $form->error($model,'description',array('style'=>'color:#FF0000'));?>
			                    </div>
				                <div class="form-group">
				            		<?php echo $form->labelEx($model,'image'); ?>
				                  <div class="input-group image-preview">
				                      <input type="text" class="form-control image-preview-filename" id="image_title" readonly="true" value="<?php echo $model->image;?>">
				                      <span class="input-group-btn">
				                          <div class="btn btn-default image-preview-input">
				                              <span class="glyphicon glyphicon-folder-open"></span>
				                              <span class="image-preview-input-title">Choose File</span>
				                              <?php 
				                              echo $form->fileField($model, 'image',array('id'=>'image','accept'=>"image/*"));
				                              echo $form->error($model, 'image');
				                              ?>
				                          </div>
				                      </span>
				                  </div>
				                </div>
				                <div class="form-group has-feedback">
			    					<div id="output-image">
			    						<?php $img = Yii::app()->basePath.'/../uploads/privillage_updates/'.$model->partner_id.'/'.$model->image;?>
			    						<?php if($model->image!=NULL){?>
			    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/privillage_updates/'.$model->partner_id.'/'.$model->image;?>">
			    						<?php }?>
			    					</div>
			    			  	</div>	        			
			    			</div> 
			    		</div>
				</div>
			</div>
	    </div>   
	</div>
</div>
<?php $this->endWidget(); ?>