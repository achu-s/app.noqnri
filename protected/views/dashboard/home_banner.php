<?php
$this->breadcrumbs=array(
    'Home Banner'
);
?>
<div class="box">
    <div class="box-body">
        <h1>Home Banner</h1>
        <br>
        <hr>
        <?php
			$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			    'id'=>'banner-form',
			    'enableAjaxValidation'=>true,
			    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
			)); 
		?>
		<div class="col-md-12">
     		<div class="box box-danger">
        		<div class="box-header with-border"></div>
      			<div class="box-body">
					<div class="form-group">
		                <div class="form-group">
		              		<?php echo $form->labelEx($model,'banner'); ?>
		                  <div class="file-loading">
                          	<?php 
                              echo $form->fileField($model, 'banner[]',array('id'=>'kv-explorer','required'=>true,'accept'=>"image/*",'multiple'=>true));
                              echo $form->error($model, 'banner');
	                          ?>
                      </div>
                      <span class="error">Note : Banner size sholud be minimum of 2000 X 700</span>
		                </div>
		                <div class="form-group">
		                	<?php $this->widget('bootstrap.widgets.TbButton', array(
		                		'buttonType'=>'submit',
		                		'type'=>'primary',
		                	  'htmlOptions'=>array('id'=>'submit_banner'),
		                		'label'=>$model->isNewRecord ? 'Save' : 'Update',
		                	)); ?>
		                  	<?php echo CHtml::link('Cancel',array('dashboard'),array('class'=>'btn btn-danger')); ?>
		               </div>
					</div>
	    		</div>
	  		</div>			
		</div>
		<?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#kv-explorer").fileinput({
        'theme': 'explorer',
        'uploadUrl': '#',
        required : true,
        overwriteInitial: false,
        initialPreviewAsData: true,
        minImageWidth: 2000,
        minImageHeight: 700,
        initialPreview: [
        	<?php echo $uploaded_image_array;?>
        ],
        initialPreviewConfig: [
            <?php echo $uploaded_image_array_config;?>
        ]
    });


    $('.kv-file-remove').on('click',function(){
        var id = $(this).attr('data-key');
    	  swal({
    		  title: "Are you sure?",
    		  text: "You will not be able to recover this image!",
    		  type: "warning",
    		  showCancelButton: true,
    		  confirmButtonClass: "btn-danger",
    		  confirmButtonText: "Yes, delete it!",
    		  cancelButtonText: "No, cancel please!",
    		  closeOnConfirm: false,
    		  closeOnCancel: false
    		},
    		function(isConfirm) {
    		  if (isConfirm) {
    			  $.ajax({
                      type:'POST',
                      dataType : 'json',
                      url:Baseurl+'/dashboard/delete_item',
                      data:{'id':id},
                      success:function(response){
                          if(response.status=="false"){
                        	  swal({title: "error", text: "Unable to delete the banner", type: "error"});
                          }else{
                        	  swal({title: "Success", text: "Banner has been deleted succesfully", type: "success"},
                              function(){ 
                                 location.reload();
                              }
                            );
                          }
                      },error: function(jqXHR, textStatus, errorThrown){ 
                    	  swal("Cancelled", "Error while processing your request", "error");
                      }
                  });
      		    
    		  }else{
    			  swal("Cancelled", "Cancelled the request", "error");
        	  }
    		});
    });
});
</script>