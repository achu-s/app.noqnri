<?php
$this->breadcrumbs=array(
    'Partner'=>array('partner/admin'),
    'view',
);
?>
<div class="box">
  <div class="box-body">
   	<h1>Partner Details : <?php echo $partner->name;?></h1>
   	<br>
   	<hr>
    <?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'partner-view-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
      <div class="col-md-6">
         <div class="box box-primary">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
    					<?php if($partner->id!=1){?>
                        	<div  class="form-group has-feedback">
                        		<?php echo $form->labelEx($partner,'category_id'); ?>
                        		<?php $listdate = Partner::model()->getCategories(($partner->category_id)?$partner->category_id:'0');?>
                        		<?php print_r($listdate); ?>
                        		<?php echo $form->error($partner,'category_id'); ?>
                        	</div>
                        <?php }?>
                        <div class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'email_id'); ?>
                            <?php echo $form->textField($partner, 'email_id', array('class'=>'form-control','placeholder' => 'Email','autocomplete'=>'off','onKeyup'=>'checkUnity(this,"email_id","Partner");')); ?>
                            <?php echo $form->error($partner,'email_id',array('style'=>'color:#FF0000'));?>
                            <span id="email"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'established_date'); ?>
                            <div class="input-group date has-feedback">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <?php echo $form->textField($partner, 'established_date', array('class'=>'form-control date_picker','autocomplete'=>'off','placeholder' => 'Established Date','autocomplete'=>'off')); ?>
                              <?php echo $form->error($partner,'established_date',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'address'); ?>
                            <?php echo $form->textArea($partner, 'address', array('class'=>'form-control editors','autocomplete'=>'off','placeholder' => 'Address','data-validation'=>"required",'rows'=>'4','value'=>isset($partner->address)?nl2br($partner->address):'')); ?>
                            <?php echo $form->error($partner,'address',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                      		<?php echo $form->labelEx($partner,'country_id'); ?>
                            <?php echo $form->dropDownList($partner, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2 special','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this)','options' => array($partner->country_id=>array('selected'=>true))));?>
                            <?php echo $form->error($partner,'country_id'); ?>
                  		</div>
                        <div class="form-group has-feedback append_state">
                            <?php if($partner->id){?>
                              		<?php echo $form->labelEx($partner,'state_id'); ?>
                              		<?php echo $form->dropDownList($partner, 'state_id', CHtml::listData(State::model()->findAllByAttributes(array('country_id'=>$partner->country_id)), 'id', 'state_name'),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State"),array('options' => array($partner->state_id=>array('selected'=>true))));?>
                                    <?php echo $form->error($partner,'state_id'); ?>
                            <?php }else{?>
                              		<?php echo $form->labelEx($partner,'state_id'); ?>
                              		<?php echo $form->dropDownList($partner, 'state_id', array(),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State"));?>
                                    <?php echo $form->error($partner,'state_id'); ?>
                          	<?php }?>
                      	</div>
                        <div class="form-group has-feedback append_city">
                        <?php if($partner->id){?>
                        	<label for="City_city_content">City Name</label>
                      		<?php $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$partner->state_id));
                            if(count($CityDetails)>0){?>
                      		<select id="Address_city_id" class="form-control select2" data-placeholder="Select city" name="Address[city_id]" onChange="PlaceOther(this);" data-validation="required">
            	            <?php foreach($CityDetails as $user_data){?>
            	            	<option value="<?php echo $user_data->id?>" <?php echo ($user_data->name==$partner->City_details->name)?"selected":'';?>><?php echo $user_data->name;?></option>
            	            <?php }?>
            	            	<option value="0" <?php echo ($partner->city_id=='0')?"selected":'';?>>Other</option>
            	            </select>
                      		<?php }else{
            	               echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
            	            }?>
                        <?php }else{?>
                        	<?php echo $form->labelEx($partner,'city_id'); ?>
                            <?php $listContent = array();?>
                            <?php echo $form->dropdownlist($partner,'city_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select City')); ?>
                            <?php echo $form->error($partner,'city_id',array('style'=>'color:#FF0000'));?>
                        <?php }?>    
                        </div>
                        <div class="form-group has-feedback">
                      		  <?php echo $form->labelEx($partner,'pin_code'); ?>
                              <?php echo $form->textField($partner, 'pin_code', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Pin Code','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'pin_code',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                      		  <?php echo $form->labelEx($partner,'landmark'); ?>
                              <?php echo $form->textField($partner, 'landmark', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Landmark')); ?>
                              <?php echo $form->error($partner,'landmark',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<label for="Partner_working_hours">Working Hours</label>
                           	<div id="datetimepickerDate" class="input-group timerange">
                        	<?php echo $form->textField($partner,'working_hours',array('class'=>'form-control myclass','id'=>'working_hours','autocomplete'=>'off')); ?>
                          	<span class="input-group-addon" style=""><i aria-hidden="true" class="fa fa-calendar"></i></span>
                          	<?php echo $form->error($partner,'working_hours',array('style'=>'color:#FF0000'));?>
                            </div>
                    	</div>
                        <div class="form-group">
                  		<?php echo $form->labelEx($partner,'logo'); ?>
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" id="image_title" readonly="true" value="<?php echo $partner->logo;?>">
                                <span class="input-group-btn">
                                    <div class="btn btn-default image-preview-input">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title">Choose File</span>
                                        <?php 
                                        echo $form->fileField($partner, 'logo',array('id'=>'image','accept'=>"image/*"));
                                        echo $form->error($partner, 'logo');
                                        ?>
                                    </div>
                                </span>
                            </div>
                   		</div>
                   		<div class="form-group has-feedback">
    						<div id="output-image">
    							<?php $img = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/logo/'.$partner->logo;?>
        						<?php if($partner->logo!=NULL && file_exists($img)){?>
        						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/logo/'.$partner->logo;?>">
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
    					<div  class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'name'); ?>
                            <?php echo $form->textField($partner, 'name', array('class'=>'form-control','placeholder' => 'Name','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'name',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	  <?php echo $form->labelEx($partner,'contact_person'); ?>
                              <?php echo $form->textField($partner, 'contact_person', array('class'=>'form-control','autocomplete'=>'off','placeholder' => 'Contact Person','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'contact_person',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                      		  <?php echo $form->labelEx($partner,'mode_of_business'); ?>
                              <?php echo $form->textField($partner, 'mode_of_business', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Mode Of Business','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'mode_of_business',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'description'); ?>
                            <?php echo $form->textArea($partner, 'description', array('class'=>'form-control editors','placeholder' => 'Desription','data-validation'=>"required",'rows'=>'4')); ?>
                            <?php echo $form->error($partner,'description',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'geo_location'); ?>
                           	<div id="geolocation" class="input-group">
                        	<?php echo $form->textField($partner, 'geo_location', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Geo Location')); ?>
                          	<span class="input-group-addon" style=""><i class="fa fa-globe" aria-hidden="true"></i></span>
                          	<?php echo $form->error($partner,'geo_location',array('style'=>'color:#FF0000'));?>
                            </div>
                    	</div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'currency'); ?>
                            <?php echo $form->textField($partner, 'currency', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Currency','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'currency',array('style'=>'color:#FF0000'));?>
                        </div>      
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'google_plus_url'); ?>
                            <?php echo $form->textField($partner, 'google_plus_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Google Plus')); ?>
                            <?php echo $form->error($partner,'google_plus_url',array('style'=>'color:#FF0000'));?>
                        </div>                  
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'faccebook_url'); ?>
                            <?php echo $form->textField($partner, 'faccebook_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Facebook')); ?>
                            <?php echo $form->error($partner,'faccebook_url',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'twitter_url'); ?>
                            <?php echo $form->textField($partner, 'twitter_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Twitter')); ?>
                            <?php echo $form->error($partner,'twitter_url',array('style'=>'color:#FF0000'));?>
                        </div>
						<div class="form-group has-feedback">
                  		<?php echo $form->labelEx($photoModel,'image'); ?>
                            <div class="input-group image-preview">
                            	<?php if($photos){   
                            	    foreach($photos as $photo){
                            	        $photoArray[] =  $photo->image;
                            	    }
                            	    $photoList = implode(',',$photoArray);
                            	}?>
                                <input type="text" class="form-control image-preview-filename" id="image_title" readonly="true" value="<?php echo ($photoList)?$photoList:'';?>">
                                <span class="input-group-btn">
                                    <div class="btn btn-default image-preview-input">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title">Choose File</span>
                                        <?php 
                                        echo $form->fileField($photoModel, 'image[]',array('id'=>'PhotoModel_image','multiple'=>true,'accept'=>"image/*"));
                                        ?>
                                    </div>
                                </span>
                            </div>
                            <?php echo $form->error($photoModel, 'image');?>
                   		</div>
						<div class="form-group has-feedback"> 
							<div class="classs_image_error"></div>
    						<div id="output-photo-img">
        						<?php if($photos){   
        						    foreach($photos as $photo){
        						        $img = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/photo/'.$photo->image;
        						        if($photo->image!=NULL && file_exists($img)){?>
        						        	<img class="img-responsive thumb hover_class remove_image_<?php echo $photo->id;?>" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/photo/'.$photo->image;?>" alt="<?php echo $photo->image;?>" id="<?php echo $photo->id;?>">
											<img class="img-responsive thumb non_hover_class remove_image" style="display:none;cursor:pointer;" src="<?php echo Yii::app()->request->baseUrl.'/images/icon-close-gray.png'?>" alt="<?php echo $photo->image;?>" res="<?php echo $partner->id;?>" ref="<?php echo $photo->id;?>" alt="<?php echo $photo->image;?>" id="non_<?php echo $photo->id;?>">
                					  <?php }
        						    }
        						}?>
    						</div>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
  </div>
</div>
<?php $this->endWidget(); ?>