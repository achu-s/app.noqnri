$(document).ready(function(){
    $.validate();
    $('#validate_card_signup').on('click',function(){
          $('form')[0].reset();
          $('#login_content').hide();
          $('#Card_card_number').css({'border':'1px solid #d2d6de'}).val('');
          $('#validate_card_btn').html('Validate card');
          $('#validate_card').show();
          $('form')[0].reset();
          $('#is_signup').val('1');
          $('html, body').animate({scrollTop: '+=150px'}, 800);
    });

// Display card validation form from forgot link
    $('#validate_card_forgot').on('click',function(){
          $('form')[0].reset();
          $('#login_content').hide();
          //$('#validate_card').show().addClass('animated zoomIn');
          $('#validate_card').show();
          $('#is_signup').val('0');
          $('html, body').animate({scrollTop: '+=150px'}, 800);
    });

// Back from card validation form
    $('#back_to_login_form').on('click',function(){
        $('form')[0].reset();
        $('.validate_class').html('');
        $('#validate_card').hide();
        //$('#login_content').show().addClass('animated zoomIn');
        $('#login_content').show();
    });

// Back from Confirm mobile 
    $('#back_to_card_form').on('click',function(){
        $('form')[0].reset();
        $('.validate_class').html('');
        $('#confirm_phone_number').hide();
        //$('#validate_card').show().addClass('animated zoomIn');
        $('#validate_card').show();
    });

//Back from submit OTP to send otp
    $('#back_to_confirm_phone_form').on('click',function(){
        $('form')[0].reset();
        $('.validate_class').html('');
        $('#send_otp').hide();
        //$('#confirm_phone_number').show().addClass('animated zoomIn');
        $('#confirm_phone_number').show();
    });

// Back from send OTP
    $('#back_to_otp_form').on('click',function(){
        $('form')[0].reset();
        $('.validate_class').html('');
        $('#submit_otp').hide();
        //$('#send_otp').show().addClass('animated zoomIn');
        $('#send_otp').show();
    });

//Back from reset password to otp validate form
    $('#back_to_submit_otp_form').on('click',function(){
        $('form')[0].reset();
        $('#password_reset').hide();
        //$('#submit_otp').show().addClass('animated zoomIn');
        $('#submit_otp').show();
    });

/********************************** Validate Card  *********************************/
    $('#validate_card_btn').on('click',function(e){
    	e.preventDefault();
    	var lenght = $("#Card_card_number").val().replace(/ /g,'').length
    	if(lenght=='10'){
    		value = $("#Card_card_number").val();
    		is_signup = $('#is_signup').val();
    		$('#validate_card_btn').html('Validating your card..!').attr('disabled',true);
    		$.ajax({
                url:base_url+'/site/check_card',
                type:'POST',
                dataType:'json',
                data:{'value':value,'is_signup':is_signup},
                success:function(data){
                	$('#validate_card_btn').html('Validate card').attr('disabled',false);
                    $('.validate_class').hide();
                    $('#Card_card_number').css({'border':'1px solid #800000'});
                    if(data.status=="false"){
                    	$.notify({
                        icon: "fa fa-times",
                        message: data.message
                      },{
                        type: "error"
                      });
                    }else{
                    	$('#validate_card').hide();
                    	if(is_signup=="1"){
                        	if(data.card_issue_status=='Verified'){
	                          	$('#confirm_phone_back').hide(); // button hide
	                          	$('#common_to_confirm').show(); // button show
	                          	$('#confirm_phone_number').show();
	                          	$("#conform_card_number").val(value);
	                            $.notify({
	                              icon: "fa fa-check",
	                              message: "Card verification completed"
	                            },{
	                              type: "success"
	                            });
                        	}else if(data.card_issue_status=='OTP'){
                        		$('#submit_otp').show();
                        		$('#otp_back').hide(); // button hide
	                          	$('#common_to_otp').show(); // button show
	                          	$("#validate_card_number").val(value);
	                          	$('#validate_conform_Phone').val(data.phone_number);
	                            $.notify({
	                              icon: "fa fa-check",
	                              message: data.message
	                            },{
	                              type: "success"
	                            });
                        	}else if(data.card_issue_status=='Registration'){	
	                          	$('.login-box').css({'width': '700px'});
	                          	$('#register_content').show();
	                          	$('#register_content_back').hide(); // button hide
	                          	$('#common_to_regi').show(); // button show
	                          	$('#Login_username').val(value).attr('readonly',true);
	                          	$('#Phone_phone_number').val(data.phone_number);
	                          	$('#card_id').val(value);
	                          	$('html, body').animate({scrollTop: '+=200px'}, 800);
	                            $.notify({
	                              icon: "fa fa-check",
	                              message: "Card verification completed"
	                            },{
	                              type: "success"
	                            });
                        	}else if(data.card_issue_status=='Approved'){
	                          	$('#validate_card').show();
	                            $('#Card_card_number').css({'border':'1px solid #006400'});
	                            $.notify({
	                              icon: "fa fa-exclamation-triangle",
	                              message: "Card has been already registered"
	                            },{
	                              type: "warning"
	                            });
	      						$('#validate_card_btn').html('Already registered').attr('disabled',false);
                          }
                    	}else{
                    		  if(data.card_issue_status=='Pending'||data.card_issue_status=='Verified'||data.card_issue_status=='OTP'||data.card_issue_status=='Registration'){
	                    			$('#validate_card').show();
		                            $.notify({
		                              icon: "fa fa-times",
		                              message: "Card not resgistered yet"
		                            },{
		                              type: "error"
		                            });
	        						$('#validate_card_btn').html('Submit').attr('disabled',false);
                    		  }else{
	                            	$('#confirm_phone_back').hide(); // button hide
	                            	$('#common_to_confirm').show(); // button show
	                            	$('#Login_username_input').val(value);
	                            	$('#confirm_phone_number').show();
	                            	$("#conform_card_number").val(value);
	                            	$('#conform_phone_number_hidden').show().val(data.phone);
	                            	$.notify({
		                                icon: "fa fa-check",
		                                message: data.message
	                            	},{
	                            		type: "success"
	                            	});
                    		 }                		
                        }
                    }
                }
            })
    	}else{
        $.notify({
          icon: "fa fa-times",
          message: "Card number should be 10 digit"
        },{
          type: "error"
        });
    	}
    });


/********************************** Confirming Phone Number  *********************************/
    $('#validate_phone_btn').on('click',function(e){
    	e.preventDefault();
    	var lenght = $("#conform_phone_number").val().replace(/ /g,'').length
    	if(lenght>='10'){
    		value = $("#conform_phone_number").val();
    		card_number = $("#conform_card_number").val(); 
    		is_signup = $('#is_signup').val();
    		$('#validate_phone_btn').html('Confirming & senting OTP').attr('disabled',true);
    		$.ajax({
                url:base_url+'/site/check_send_phone',
                type:'POST',
                dataType:'json',
                data:{'value':value,'card_number':card_number},
                success:function(data){
                	$('#validate_phone_btn').html('Confirm phone number & send OTP').attr('disabled',false);
                    if(data.status=="false"){
                        $.notify({
                          icon: "fa fa-times",
                          message: data.message
                        },{
                          type: "error"
                        });
                    }else{
                      $('#confirm_phone_number').hide();
                      $('#submit_otp').show();
                      $("#validate_card_number").val(card_number);
                      $('#validate_conform_Phone').val(value);
                      $.notify({
                        icon: "fa fa-check",
                        message: data.message
                      },{
                        type: "success"
                      });
                    }
                }
            })
    	}else{
            $.notify({
              icon: "fa fa-times",
              message: "Phone number should be 10 digit"
            },{
              type: "error"
            });
    	}
    });

/******************************************* Submit Otp ********************************************/
    $('#submit_otp_btn').on('click',function(e){
    	e.preventDefault();
    	var lenght = $("#Card_otp").val().replace(/ /g,'').length
    	if(lenght>='4'){
    		value = $("#validate_conform_Phone").val();
    		card_number = $("#validate_card_number").val(); 
    		is_signup = $('#is_signup').val();
    		otp = $('#Card_otp').val();
    		is_signup = $('#is_signup').val();
    		$('#submit_otp_btn').html('validating OTP').attr('disabled',true);
    		$.ajax({
                url:base_url+'/site/Check_otp',
                type:'POST',
                dataType:'json',
                data:{'value':value,'card_number':card_number,'otp':otp,'is_signup':is_signup},
                success:function(data){
                	$('#submit_otp_btn').html('Submit OTP').attr('disabled',false);
                	$('#Card_otp').val('');
                    if(data.status=="false"){
                    	$.notify({
                          icon: "fa fa-times",
                          message: data.message
                        },{
                          type: "error"
                        });
                    }else{
                    	$('#submit_otp').hide();
                    	if(is_signup=="1"){
                    		$('.login-box').css({'width': '700px'});
	                        $('#register_content').show();
	                        $('#register_content_back').hide(); // button hide
	                        $('#common_to_regi').show(); // button show
	                        $('#Login_username').val(card_number).attr('readonly',true);
	                        $('#Phone_phone_number').val(value).attr('readonly',true);
	                        $('#card_id').val(card_number);
	                        $('html, body').animate({scrollTop: '+=200px'}, 800);
                    	}else{
                    		$('#Login_username_input').val(card_number);
                    		$('#password_reset').show();
                    	}
                    	$.notify({
                    		icon: "fa fa-check",
                        	message: data.message
                    	},{
                    		type: "success"
                    	});
                    }
                }
            })
    	}else{
            $.notify({
              icon: "fa fa-times",
              message: "OTP should be 4 digit"
            },{
              type: "error"
            });
    	}
    });

/********************************** Register form *************************************/
    $.validate({
        reCaptchaSiteKey: '6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb',
        reCaptchaTheme: 'light'
    });

    $('#re_request_otp').click(function(){
        $('#submit_otp_btn').html('Re-requsting OTP').attr('disabled',true);
        $('#Card_otp').val('');
        var card_number = $('#validate_card_number').val();
        var phone_number = $('#validate_conform_Phone').val();
        is_signup = $('#is_signup').val();
        $.ajax({
            url:base_url+'/site/requestOtp',
            type:'POST',
            dataType:'json',
            data:{'value':card_number,'phone_number':phone_number,'is_signup':is_signup},
            success:function(data){
                $('#submit_otp_btn').html('Submit OTP').attr('disabled',false);
                if(data.status=="false"){
                    $.notify({
                      icon: "fa fa-times",
                      message: data.message
                    },{
                      type: "error"
                    });
                    return false;
                }else{
                    $.notify({
                      icon: "fa fa-check",
                      message: data.message
                    },{
                      type: "success"
                    });
                }
            }
        })
    });

/******************** Forgot Password *****************************/
    $('#Login_password').keyup(function() {
      $('#result').html(checkStrength($('#Login_password').val()))
    });
    $('#Login_confirm_password').keyup(function() {
      $('#result_confirm').html(checkStrength_confirm($('#Login_confirm_password').val(),$('#Login_password').val()))
    });
    
    $('#Login_password_reset').keyup(function() {
        $('#result_password').html(checkStrength_reset($('#Login_password_reset').val()))
    });
    $('#Login_confirm_password_reset').keyup(function() {
        $('#result_confirm_password').html(checkStrength_confirm_reset($('#Login_confirm_password_reset').val(),$('#Login_password_reset').val()))
    });

    $('form#register-form').submit(function(event){
        $('#submit_registration').html('loading...').css({'cursor':'not-allowed'}).attr('disabled',true);
        event.preventDefault();
        $.ajax({
            url:base_url+'/site/register',
            type:'POST',
            dataType:'json',
            data:$('form#register-form').serialize(),
            success:function(data){
                $('#submit_registration').html('Submit').css({'cursor':'pointer'}).attr('disabled',false);
                if(data.status=="false"){
                    $.notify({
	                    icon: "fa fa-times",
	                    message: data.message
	                },{
	                    type: "error"
	                });
                }else{
                    window.location.href=base_url;
                }
            }
        });
    });

    $('form#forgot-form').submit(function(event){
        $('#forgot_pass_btn').html('loading...').css({'cursor':'not-allowed'}).attr('disabled',true);
        event.preventDefault();
        $.ajax({
            url:base_url+'/site/Forgot',
            type:'POST',
            dataType:'json',
            data:$('form#forgot-form').serialize(),
            success:function(data){
                $('#forgot_pass_btn').html('Submit').css({'cursor':'pointer'}).attr('disabled',false);
                if(data.status=="false"){
                	$.notify({
	                    icon: "fa fa-times",
	                    message: data.message
	                },{
	                    type: "error"
	                });
                }else{
                    window.location.href=base_url;
                }
            }
        });
    });
});

function checkStrength_confirm_reset(confirm_password,password){
        var strength = 0;
        if(confirm_password.length == 0){
            $('#result_confirm_password').removeClass()
            //$('#result').addClass('short')
            $('#password_strength_reset_confirm').html(' ');
            //$('#password_strength_reset_confirm').html("Password mis-match").css({'color':'#FF0000'});
            $('#forgot_pass_btn').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        }else if(confirm_password!=password){
            $('#result_confirm_password').removeClass()
            $('#result_confirm_password').addClass('short')
            $('#password_strength_reset_confirm').html("Password mis-match").css({'color':'#FF0000'});
            $('#forgot_pass_btn').html('Register').css({'cursor':'pointer'}).attr('disabled',true);
        }else{
            $('#result_confirm_password').removeClass()
            var class_name = $('#result_password').attr('class');
            $('#result_confirm_password').addClass(class_name);
            if(class_name=="short"){
                style_name = '#FF0000';
            }else if(class_name=="weak"){
                style_name = 'orange';
            }else if(class_name=="good"){
                style_name = '#2D98F3';
            }else if(class_name=="strong"){
                style_name = 'limegreen';
            }else if(class_name=="strongest"){
                style_name = '#00a65a';
            }
            $('#password_strength_reset_confirm').html('Matched').css({'color':style_name});
            $('#forgot_pass_btn').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        }
    }
    function checkStrength_reset(password) {
        var strength = 0
        if(password.length == 0){
            $('#result_password').removeClass()
            //$('#result').addClass('short')
            $('#password_strength_reset').html(' ');
            $('#forgot_pass_btn').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        }else if (password.length < 8) {
            $('#result_password').removeClass()
            $('#result_password').addClass('short')
            $('#password_strength_reset').html('Too short').css({'color':'#FF0000'});
            $('#forgot_pass_btn').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        }else{
            if (password.length >= 8) strength += 1
            // If password contains both lower and uppercase characters, increase strength value.
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
            // If it has numbers and characters, increase strength value.
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
            // If it has one special character, increase strength value.
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            // If it has two special characters, increase strength value.
            if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            // Calculated strength value, we can return messages
            // If value is less than 2
            //alert(strength);
            if(strength==0){
                $('#result_password').removeClass();
                $('#password_strength_reset').html('');
                $('#forgot_pass_btn').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
            }else if (strength < 2) {
                $('#result_password').removeClass()
                $('#result_password').addClass('weak')
                $('#password_strength_reset').html('Weak').css({'color':'orange'});
                $('#forgot_pass_btn').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
            } else if (strength == 2) {
                $('#result_password').removeClass()
                $('#result_password').addClass('good')
                $('#password_strength_reset').html('Good').css({'color':'#2D98F3'});
                $('#forgot_pass_btn').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            } else if(strength == 3){
                $('#result_password').removeClass()
                $('#result_password').addClass('strong')
                $('#password_strength_reset').html('Strong').css({'color':'limegreen'});
                $('#forgot_pass_btn').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            } else {
                $('#result_password').removeClass()
                $('#result_password').addClass('strongest')
                $('#password_strength_reset').html('Strongest').css({'color':'#00a65a'});
                $('#forgot_pass_btn').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
        }
    }


function checkUnity(param,key,table){
    var value=$(param).val();
    if(value!=null || value!=""){
        $('#submit_reg').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
        $.ajax({
            url:base_url+'/site/check_unity',
            type:'POST',
            dataType:'json',
            data:{'value':value,'key':key,'table':table},
            success:function(data){
                if(data.status=="false"){
                    $('#'+table+'_'+key+'_em_').html(data.msg).css({'color':data.color}).show();
                    $('#submit_registration').attr('disabled',true);
                }else{
                    $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
                    $('#'+table+'_'+key+'_em_').html("");
                    $('#submit_registration').attr('disabled',false);
                }
            }
        })
    }
}

function checkStrength(password) {
    var strength = 0
    if(password.length == 0){
        $('#result').removeClass()
        //$('#result').addClass('short')
        $('#password_strength').html(' ');
        $('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    }else if (password.length < 8) {
        $('#result').removeClass()
        $('#result').addClass('short')
        $('#password_strength').html('Too short').css({'color':'#FF0000'});
        $('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    }else{
        if (password.length >= 8) strength += 1
        // If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
        // If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
        // If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // If it has two special characters, increase strength value.
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // Calculated strength value, we can return messages
        // If value is less than 2
        //alert(strength);
        if(strength==0){
            $('#result').removeClass();
            $('#password_strength').html('');
            $('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        }else if (strength < 2) {
            $('#result').removeClass()
            $('#result').addClass('weak')
            $('#password_strength').html('Weak').css({'color':'orange'});
            $('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        } else if (strength == 2) {
            $('#result').removeClass()
            $('#result').addClass('good')
            $('#password_strength').html('Good').css({'color':'#2D98F3'});
            $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        } else if(strength == 3){
            $('#result').removeClass()
            $('#result').addClass('strong')
            $('#password_strength').html('Strong').css({'color':'limegreen'});
            $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        } else {
            $('#result').removeClass()
            $('#result').addClass('strongest')
            $('#password_strength').html('Strongest').css({'color':'#00a65a'});
            $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        }
    }
}

function checkStrength_confirm(confirm_password,password){
    var strength = 0;
    if(confirm_password.length == 0){
        $('#result_confirm').removeClass()
        $('#password_strength_confirm').html(' ');
        $('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    }else if(confirm_password!=password){
        $('#result_confirm').removeClass()
        $('#result_confirm').addClass('short')
        $('#password_strength_confirm').html("Password mis-match").css({'color':'#FF0000'});
        $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',true);
    }else{
        $('#result_confirm').removeClass()
        var class_name = $('#result').attr('class');
        $('#result_confirm').addClass(class_name);
        if(class_name=="short"){
            style_name = '#FF0000';
        }else if(class_name=="weak"){
            style_name = 'orange';
        }else if(class_name=="good"){
            style_name = '#2D98F3';
        }else if(class_name=="strong"){
            style_name = 'limegreen';
        }else if(class_name=="strongest"){
            style_name = '#00a65a';
        }
        $('#password_strength_confirm').html('Matched').css({'color':style_name});
        $('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
    }
}