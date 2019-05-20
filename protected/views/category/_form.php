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
        			  <?php if(!empty($parentData)) {?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'parent_category_value'); ?>
                        <?php echo $form->textField($model,'parent_category_value',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','value'=>$parentData->category,'readonly'=>true)); ?>
                        <?php echo $form->error($model,'parent_category_value'); ?>
                    </div>
                    <input type="hidden" name="parent_category" id="parent_category" value="<?php echo $parentId;?>">
                <?php }?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'category'); ?>
                    <?php echo $form->textField($model,'category',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                    <?php echo $form->error($model,'category'); ?>
                </div>
                <div class="form-group">
            		<?php echo $form->labelEx($model,'category_image'); ?>
                  <div class="input-group image-preview">
                      <input type="text" class="form-control image-preview-filename" id="image_title" readonly="true" value="<?php echo $model->category_image;?>">
                      <span class="input-group-btn">
                          <div class="btn btn-default image-preview-input">
                              <span class="glyphicon glyphicon-folder-open"></span>
                              <span class="image-preview-input-title">Choose File</span>
                              <?php 
                              echo $form->fileField($model, 'category_image',array('id'=>'image','accept'=>"image/*"));
                              echo $form->error($model, 'category_image');
                              ?>
                          </div>
                      </span>
                  </div>
                </div>
                <div class="form-group has-feedback">
        					<div id="output-image">
        						<?php $img = Yii::app()->basePath.'/../uploads/category/'.$model->category_image;?>
        						<?php if($model->category_image!=NULL && file_exists($img)){?>
        						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/category/'.$model->category_image;?>">
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
                <div  class="form-group has-feedback">
              	<?php echo $form->labelEx($model,'category_discription'); ?>
                  <?php echo $form->textArea($model, 'category_discription', array('class'=>'form-control editors','placeholder' => 'Category Description','data-validation'=>"required",'rows'=>'4','value'=>$model->category_discription)); ?>
                  <?php echo $form->error($model,'category_discription',array('style'=>'color:#FF0000'));?>
                </div>
                <div class="form-group">
              		<?php echo $form->labelEx($model,'category_banner'); ?>
                  <div class="input-group image-preview">
                      <input type="text" class="form-control image-preview-filename" id="banner_title" readonly="true" value="<?php echo $model->category_banner;?>">
                        <span class="input-group-btn">
                          <div class="btn btn-default image-preview-input">
                              <span class="glyphicon glyphicon-folder-open"></span>
                              <span class="image-preview-input-title">Choose File</span>
                              <?php 
                              echo $form->fileField($model, 'category_banner',array('id'=>'banner','accept'=>"image/*"));
                              echo $form->error($model, 'category_banner');
                              ?>
                          </div>
                        </span>
                  </div>
                  <span class="image-error-show"></span>
                </div>
                <div class="form-group has-feedback">
        					<div id="output-banner">
        						<?php $img = Yii::app()->basePath.'/../uploads/category/banner/'.$model->category_banner;?>
        						<?php if($model->category_banner!=NULL && file_exists($img)){?>
        						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/category/banner/'.$model->category_banner;?>">
        						<?php }?>
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
                	<?php echo CHtml::htmlButton('Reset',array(
                            "id"=>'chtmlbutton',
                          "class"=>'btn btn-secondary'
                          
                      ));?>
                  <?php }?>
                  <?php echo CHtml::link('Cancel',array('category/index'),array('class'=>'btn btn-danger')); ?>
               </div>
    				</div>
    			</div>
		    </div>
	  </div>			
</div>
<?php $this->endWidget(); ?>