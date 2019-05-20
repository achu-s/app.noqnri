<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Generate Cards</h4>
</div>
<div class="modal-body">
	<?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'create-new-form',
            'enableAjaxValidation'=>true,
            'htmlOptions'=>array('enctype' => 'multipart/form-data'),
        ));
    ?> 
    <div class="row">
     	<div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body">
      			<div class="form-group">
              <?php if($model->id){?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'card_number'); ?>
                    <?php echo $form->textField($model,'card_number',array('class'=>'form-control','maxlength'=>16,'autocomplete'=>'off','data-validation'=>"required")); ?>
                    <?php echo $form->error($model,'card_number'); ?>
                    <span id="card_number_error"></span>
                </div>
                <?php if($model->phone_number!=NULL){?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'phone_number'); ?>
                        <?php echo $form->textField($model,'phone_number',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                        <?php echo $form->error($model,'phone_number'); ?>
                        <span id="phone_number_error"></span>
                    </div>
                <?php }?>
              <?php }else{ ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'count'); ?>
                    <?php echo $form->numberField($model,'count',array('class'=>'form-control','autocomplete'=>'off','data-validation'=>"required")); ?>
                    <?php echo $form->error($model,'count'); ?>
                    <span id="card_number_error"></span>
                </div>
              <?php } ?>  
              <div class="form-group" style="float: right;">
                  <img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/loading_second.gif" style="visibility: hidden;">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                		'buttonType'=>'submit',
                		'type'=>'primary',
                	  'htmlOptions'=>array('id'=>'card_submit'),
                	  'label'=>($model->id)?'Update':'Save',
                	)); ?>
                	<input type="hidden" name="Card[id]" id="Card_card_number" value="<?php echo ($model->id)?$model->id:'0';?>">
            	  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	 	  </div>
      			</div> 
    			</div>
    		</div>
		  </div>
    </div>
  <?php $this->endWidget();?>  
</div>
<script type="text/javascript">
  $('#card_submit').on('click',function(event){
        event.preventDefault();
        $('#card_submit').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
        $('#loading_img').css({'visibility':'visible'});
        setTimeout(function(){
          var formData = new FormData( $("#create-new-form")[0] );
          jQuery.ajax({
              type: "POST",
              dataType:'json',
              url: Baseurl+"/card/InsertCard",
              data: formData,
              async : false,
              cache : false,
              contentType : false,
              processData : false,
              success: function(data){
                  $('#loading_img').css({'visibility': 'hidden'});
                  $('#card_submit').html('Save').css({'cursor':'pointer'}).attr('disabled',false);
                  if(data.status=="success"){
                      $('.box-body').html("<img src='"+Baseurl+"/vendor/images/loading_second.gif'>");
                      $('form')[0].reset();
                      $("#myModal .close").click();
                      window.location.reload();
                  }else{
                      $('#card_number_error').html(data.card_number).css({'color':'#dd4b39'});
                      $('#phone_number_error').html(data.phone_number).css({'color':'#dd4b39'});
                  }
              }
          })
        }, 2000);
    });
    
</script>