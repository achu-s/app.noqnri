<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'admin-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections',
        'enctype' => 'multipart/form-data'
    )
));?>
<div class="row">
      <div class="col-md-6">
         <div class="box box-primary">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'first_name'); ?>
                            <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                            	<div class="col-md-12">
                            	<?php echo $form->labelEx($customer,'gender'); ?>
                                <?php
                            		$accountStatus = array('M'=>'Male', 'F'=>'Female');
                            		echo $form->radioButtonList($customer,'gender',$accountStatus);
                            	?>
                            	</div>
                            </div>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'email'); ?>
                            <?php echo $form->textField($customer, 'email', array('class'=>'form-control','placeholder' => 'Email','data-validation'=>"email",'onKeyup'=>'checkUnity(this,"email","Customer")')); ?>
                            <?php echo $form->error($customer,'email',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <span id="email"></span>
                        </div>
                        <div class="form-group has-feedback">
                      		<?php echo $form->labelEx($customer,'country_id'); ?>
                            <?php echo $form->dropDownList($customer, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2 special','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this)','options' => array($customer->country_id=>array('selected'=>true))));?>
                            <?php echo $form->error($customer,'country_id'); ?>
                  		</div>
                        <div class="form-group has-feedback append_state">
                            <?php if($customer->id){?>
                                <?php echo $form->labelEx($customer,'state_id'); ?>
                                <?php echo $form->dropDownList($customer, 'state_id', CHtml::listData(State::model()->findAllByAttributes(array('country_id'=>$customer->country_id)), 'id', 'state_name'),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State",'options' => array($customer->state_id=>array('selected'=>true))));?>
                                <?php echo $form->error($customer,'state_id'); ?>
                            <?php }else{ ?>
                                <?php echo $form->labelEx($customer,'state_id'); ?>
                                <?php $listContent = array();?>
                                <?php echo $form->dropdownlist($customer,'state_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select State')); ?>
                                <?php echo $form->error($customer,'state_id',array('style'=>'color:#FF0000'));?>
                            <?php } ?>
                        </div>
                        <div class="form-group has-feedback append_city">
                            <?php if($customer->id){?>
                                <label for="City_city_content">City Name</label>
                                <?php $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$customer->state_id));
                                if(count($CityDetails)>0){?>
                                <select id="Customer_city_id" class="form-control select2" data-placeholder="Select city" name="Customer[city_id]" data-validation="required">
                                <?php foreach($CityDetails as $user_data){?>
                                    <option value="<?php echo $user_data->id?>" <?php echo ($user_data->name==$customer->CityData->name)?"selected":'';?>><?php echo $user_data->name;?></option>
                                <?php }?>
                                </select>
                                <?php }else{
                                   echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
                                }?>
                            <?php }else{?>
                            	<?php echo $form->labelEx($customer,'city_id'); ?>
                                <?php $listContent = array();?>
                                <?php echo $form->dropdownlist($customer,'city_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select City')); ?>
                                <?php echo $form->error($customer,'city_id',array('style'=>'color:#FF0000'));?>
                            <?php }?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($customer,'country_code'); ?>
                            <?php echo $form->textField($customer, 'country_code', array('class'=>'form-control date country_code','placeholder'=>'Country Code','value'=>($customer->country_code)?$customer->country_code:'+91','readonly'=>true)); ?>
                            <?php echo $form->error($customer,'country_code',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($imageData,'image'); ?>
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" id="image_title" readonly="true" value="<?php echo ($imageData->image)?$imageData->image:'';?>">
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
    				</div> 
    			</div>
    		</div>
    	</div>
    	<div class="col-sm-6">
    	<div class="box box-danger">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'last_name'); ?>
                            <?php echo $form->textField($customer, 'last_name', array('class'=>'form-control','placeholder' => 'Last Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'last_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>	
                        <div  class="form-group has-feedback">
                            <?php echo $form->labelEx($customer,'indian_address'); ?>
                            <?php echo $form->textArea($customer, 'indian_address', array('class'=>'form-control editors','autocomplete'=>'off','placeholder' => 'Indian Address','data-validation'=>"required",'rows'=>'4','value'=>isset($customer->indian_address)?nl2br($customer->indian_address):'')); ?>
                            <?php echo $form->error($customer,'indian_address',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	  <?php echo $form->labelEx($customer,'dob'); ?>
                              <?php echo $form->textField($customer, 'dob', array('class'=>'form-control date','placeholder' => 'Date Of Birth','autocomplete'=>'off')); ?>
                              <?php echo $form->error($customer,'dob',array('style'=>'color:#FF0000'));?>
                              <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'profession'); ?>
            				<?php echo $form->textField($customer, 'profession', array('class'=>'form-control','placeholder' => 'Profession')); ?>
                            <?php echo $form->error($customer,'profession',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
                      	</div>
                        <div class="form-group has-feedback">
                          <?php echo $form->labelEx($customer,'pin_code'); ?>
                          <?php echo $form->textField($customer, 'pin_code', array('class'=>'form-control','placeholder'=>'Pin Code','data-validation'=>"required",'value'=>$customer->pin_code)); ?>
                          <?php echo $form->error($customer,'pin_code',array('style'=>'color:#FF0000'));?>
                    	</div> 
                      	<div class="form-group">
                      		<div class="row">
            			    	<div class="col-md-12">
            			    	  <?php echo $form->labelEx($customer,'indian_contact_number'); ?>
                                  <?php echo $form->textField($customer, 'indian_contact_number', array('class'=>'form-control','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"indian_contact_number","Customer")','value'=>$customer->indian_contact_number)); ?>
                                  <?php echo $form->error($customer,'indian_contact_number',array('style'=>'color:#FF0000'));?>
                                  <span id="indian_contact_number"></span>
                          		</div>
                            </div>
                        </div>
                        <div class="form-group has-feedback"> 
    						<div id="output-image">
        						<?php $img_path = Yii::app()->basePath.'/../uploads/customer/profile_image/'.$imageData->image;?>
        						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
        						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_image/'.$imageData->image?>">
        						<?php }?>
        					</div>
						</div>	
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
        	<div class="form-group" style="text-align: center">
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            		'buttonType'=>'submit',
            		'type'=>'primary',
            	    'htmlOptions'=>array('id'=>'submit_reg'),
            	    'label'=>($customer->id)?'Update':'Register',
            	)); ?>
            	
            	<?php
            	if(!$customer->id){
            	    echo CHtml::ResetButton('Reset',array(
            	        "id"=>'reset_form',
            	        "class"=>'btn btn-secondary'
            	    ));
            	}
                ?>
                <?php echo CHtml::link('Cancel',array('customer/index'),array('class'=>'btn btn-danger')); ?>
                <img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/loading_second.gif" style="display:none;">
             </div>
         </div>
    </div>
<?php $this->endWidget(); ?>