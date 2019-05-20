$(window).load(function() {
	$(".se-pre-con").fadeOut("slow");
});
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
$(document).ready(function(){

	$.validate();

    $('.select2').select2();

	$("[data-fancybox]").fancybox();
	
	$(".switch").bootstrapSwitch();

    $('.date_picker').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
    });
	
	$('.switch').on('switchChange.bootstrapSwitch', function(event, state) {
	  var controller = $(this).attr('res');
	  var id = $(this).attr('ref');
	  state = state;
	  $.ajax({
		  type:'POST',
		  url:Baseurl+'/'+controller+'/ChangeStatus',
		  data:{state:state,id:id},
		  success:function(response){
			  if(response=="0"){
				  $.notify({
		            icon: "fa fa-times",
	                message: "Error while updating status",
		          },{
		            type: "error"
		          });
			  }else{
				  if(response=="Y"){
					  $.notify({
			            icon: "fa fa-check",
		                message: "Status has been changed to <b>Active</b>",
			          },{
			            type: "success"
			          });
				  }else{
					  $.notify({
	                    icon: "fa fa-exclamation-triangle",
	                    message: "Status has been changed to <b>Inacive</b>",
	                  },{
	                    type: "warning"
	                  });
				  }
			  }
		  }
	  });
	});

	$('#image').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#output-image').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
            	 $('#image_title').val(file.name);
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                        $('#output-image').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
           
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });

    $('#banner').on('change', function(){
        if (window.File && window.FileReader && window.FileList && window.Blob){
        	$('#output-banner').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            var output = [];
            var notoutput = [];
            $.each(data, function(index, file){ //loop though each file
             	var img = new Image();
                 img.src = window.URL.createObjectURL( file );
                 img.onload = function() {
                    var width = img.naturalWidth,
                        height = img.naturalHeight;
                     	window.URL.revokeObjectURL( img.src );
                     	if(width>=1500 || height>=700){
                         	$('#banner_title').val(file.name);
                             if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                                 var fRead = new FileReader(); //new filereader
                                 fRead.onload = (function(file){ //trigger function on successful read
                                     console.log(file);
                                 return function(e) {
                                     var img = $('<img  class="img-responsive"/>').addClass('thumb').attr('src', e.target.result); //create image element
                                     $('#output-banner').append(img); //append image to output element
                                 };
                                 })(file);
                                 fRead.readAsDataURL(file); //URL representing the file's data.
                             }
                 		}else{
    						$('.image-error-show').html('Image diamention should be greater than 1500 X 900').css({'color':'#dd4b39'});return false;
                     	}
                 };
            });
        }else{
         alert("Your browser doesn't support File API!"); //if File API is absent
        }
    }); 
    
    $('#PhotoModel_image').on('change', function(){//on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#output-photo-img').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            var output = [];
            var notoutput = [];
            $.each(data, function(index, file){ //loop though each file
            	var img = new Image();
                img.src = window.URL.createObjectURL( file );
                img.onload = function() {
                    var width = img.naturalWidth,
                        height = img.naturalHeight;
                    window.URL.revokeObjectURL( img.src );
                    	output.push(file.name);	
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                                console.log(file);
                            return function(e) {
                                var img = $('<img  class="img-responsive"/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('#output-photo-img').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                        $('#image_title').val(output.join(", "));
                };
            });
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
    
    $("#partner-view-form :input").prop("disabled", true);
    $("#customer-view-form :input").prop("disabled", true);
    $("#privillage-updates-form :input").prop("disabled", true);
    $("#sales-form :input").prop("disabled", true);
    
    $('#add_new_form').on('click',function(){
    	$('.modal-content').html("<img src='"+Baseurl+"/vendor/images/loading_second.gif'>").css({'text-align':'center'});
    	$.ajax({
        	type:'POST',
        	dataType:'html',
        	url:Baseurl+'/card/CardForm',
        	success:function(response){
        		$('.modal-content').html(response);
                $('form#create-new-form').prop('action','');
        	},error: function(jqXHR, textStatus, errorThrown) {
        		$('.modal-content').html("Error while loading form");
            }
        });
    });
});

function getState(param){
    $('.append_state').html("<img src='"+Baseurl+"/vendor/images/loading_second.gif'>");
    $('.country_code').val('Please wait..');
    var value = $(param).val();
    $.ajax({
        type:'POST',
        dataType:'html',
        data:{'value':value},
        url:Baseurl+'/site/GetState',
        success:function(response){
            $('.append_state').html(response);
            $('.select2').select2();
            $.ajax({
                type:'POST',
                dataType:'html',
                data:{'value':value},
                url:Baseurl+'/site/CountryCode',
                success:function(data){
                    $('.country_code').val(data);
                },error: function(jqXHR, textStatus, errorThrown) {
                    //window.location.reload();
                }
            });
        },error: function(jqXHR, textStatus, errorThrown) {
            //window.location.reload();
        }
    });
}

function SelectCity(param){
    $('.append_city').html("<img src='"+Baseurl+"/vendor/images/loading_second.gif'>");
    var value = $(param).val();
    $.ajax({
        type:'POST',
        dataType:'html',
        data:{'value':value},
        url:Baseurl+'/site/GetCity',
        success:function(response){
            $('.append_city').html(response);
            $('.select2').select2();
        },error: function(jqXHR, textStatus, errorThrown) {
            //window.location.reload();
        }
    });
}

function checkUnity(param,key,table){
    var value=$(param).val();
    if(value!=null || value!=""){
        $('#submit_reg').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
        $.ajax({
            url:Baseurl+'/site/check_unity',
            type:'POST',
            dataType:'json',
            data:{'value':value,'key':key,'table':table},
            success:function(data){
                if(data.status=="false"){
                    $('#'+key).html(data.msg).css({'color':data.color});
                }else{
                    $('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
                    $('#'+key).html("");
                }
            }
        })
    }
}

function editCard(param){
	$('.modal-content').html("<img src='"+Baseurl+"/vendor/images/loading_second.gif'>").css({'text-align':'center'});
	var id = $(param).attr('id');
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	url:Baseurl+'/card/EditCard',
    	data: {'id':id},
    	success:function(response){
        	$('.modal-title').html('Update card');
    		$('.modal-content').html(response);
            $('form#create-new-form').prop('action','');
    	},error: function(jqXHR, textStatus, errorThrown) {
    		$('.modal-content').html("Error while loading form");
        }
    });
}