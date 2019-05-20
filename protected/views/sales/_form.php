<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'forind-user-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
<div class="row">
  <div class="col-md-6">
     <div class="box box-primary">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
            <div class="form-group">
                <?php echo $form->labelEx($model,'first_name'); ?>
                <?php echo $form->textField($model,'first_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                <?php echo $form->error($model,'first_name'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'last_name'); ?>
                <?php echo $form->textField($model,'last_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                <?php echo $form->error($model,'last_name'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'email_id'); ?>
                <?php echo $form->textField($model,'email_id',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                <?php echo $form->error($model,'email_id'); ?>
            </div>
            <div class="form-group">
            <?php echo $form->labelEx($imageData,'image'); ?>
                  <div class="input-group image-preview">
                      <input type="text" class="form-control image-preview-filename" id="image-preview-filename-image" readonly="true" value="<?php echo $imageData->image;?>">
                      <span class="input-group-btn">
                          <div class="btn btn-default image-preview-input">
                              <span class="glyphicon glyphicon-folder-open"></span>
                              <span class="image-preview-input-title">Choose File</span>
                              <?php 
                              echo $form->fileField($imageData, 'image',array('id'=>'image','accept'=>"image/*"));
                              echo $form->error($imageData, 'image');
                              ?>
                          </div>
                      </span>
                  </div>
            </div>
            <div class="form-group has-feedback"> 
  						<div id="output-image">
  						<?php $img_path = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image;?>
  						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
  						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image;?>">
  						<?php }?>
  						</div>
		       </div>
				</div> 
			</div>
		</div>
	</div>
	<div class="col-md-6">
     <div class="box box-danger">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
  				<div class="form-group">
          <?php echo $form->labelEx($model,'middle_name'); ?>
          <?php echo $form->textField($model,'middle_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
          <?php echo $form->error($model,'middle_name'); ?>
        	</div>
        	<div class="form-group">
            <?php echo $form->labelEx($model,'phone_number'); ?>
            <?php echo $form->textField($model,'phone_number',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
            <?php echo $form->error($model,'phone_number'); ?>
        	</div>
        	<div class="form-group">
          	<?php $this->widget('bootstrap.widgets.TbButton', array(
          		'buttonType'=>'submit',
          		'type'=>'primary',
          	    'htmlOptions'=>array('id'=>'submit_reg'),
          	    'label'=>($model->id)?'Update':'Save',
          	)); ?>
          	
          	<?php
          	if($partner->id){
                  echo CHtml::ResetButton('Cancel',array(
                      "id"=>'cancel_form',
                      "class"=>'btn btn-secondary'
                  ));
          	}
              ?>
              <img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/loading_second.gif" style="display:none;">
           </div>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php $this->endWidget(); ?>