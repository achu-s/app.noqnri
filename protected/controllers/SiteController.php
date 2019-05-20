<?php
class SiteController extends Controller
{
    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('/dashboard/'));
        }
        $customer = new Customer();
        $country = new Country();
        $state  = new State();
        $city = new City();
        $login = new Login();
        $card = new Card();
        $model = new CustomerLogin();
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-user')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['CustomerLogin'])) {
            $model->attributes = $_POST['CustomerLogin'];
            if($model->validate() && $model->login('customer')){
                $message="Admin Logged In ";
                date_default_timezone_set('Asia/Kolkata');
                $date_last = date("Y-m-d H:i:s");
                Common::activityLog("-1", 'LOG IN', $message, $date_last);
                Yii::app()->user->setFlash('success_flash_msg', 'Logged In');
                $this->redirect(array('/dashboard'));
            } else {
                Yii::app()->user->setFlash('error_flash_msg', 'Username or Password incorrect');
            }
        }
        $this->layout = false;
        $this->render('//site/customer', array('model' => $model,'customer'=>$customer,'login'=>$login,'card'=>$card));
        
    }
    
    public function actionCheck_card(){
        if($_POST['value']){
            $carddata = Card::model()->findByAttributes(array('card_number'=>$_POST['value']));
            if($carddata){
                $transaction = Yii::app()->db->beginTransaction();
                if($_POST['is_signup']==1){
                    if($carddata->card_issue_status=="Pending"){
                        $carddata->card_issue_status = "Verified";
                        if($carddata->save(false)){
                            echo (json_encode(array('status'=>'true','card_issue_status'=>$carddata->card_issue_status,'message'=>'Card verification completed')));
                        }else{
                            echo (json_encode(array('status'=>'false')));
                        }
                    }else{
                        if($carddata->card_issue_status=="OTP"){
                            $carddata->otp=str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
                            $messageContent = "Hello ,\r\nPlease enter yout OTP,\r\nOTP:".$carddata->otp."\r\n Cheers\r\nTeam NoQnri";
                            //if(Common::SendSMS('+91'.$carddata->phone_number,$messageContent)){
                                if($carddata->save(false)){
                                    $transaction->commit();
                                    echo (json_encode(array('status'=>'true','phone_number'=>$carddata->phone_number,'card_issue_status'=>$carddata->card_issue_status,'message'=>'Card verification completed & OTP sent to the registered mobile number')));
                                }else{
                                    $transaction->rollBack();
                                    echo (json_encode(array('status'=>'false','message'=>'Error while processing request, Please try after some time..!')));
                                }
                            /*}else{
                                $transaction->rollBack();
                                echo (json_encode(array('status'=>'false','message'=>'Error while senting OTP, Please try after some time..!')));
                            }*/
                        }else{
                            echo (json_encode(array('status'=>'true','phone_number'=>$carddata->phone_number,'card_issue_status'=>$carddata->card_issue_status,'message'=>'Card verification completed')));
                        }
                    }
                }else{
                    echo (json_encode(array('status'=>'true','phone_number'=>$carddata->phone_number,'card_issue_status'=>$carddata->card_issue_status,'message'=>'Card verification completed')));
                }
            }else{
                echo (json_encode(array('status'=>'false','message'=>'Invalid card')));
            }
        }else{
            echo (json_encode(array('status'=>'false','message'=>'Empty value submitted')));
        }
    }
    public function actionCheck_send_phone(){
        if(isset($_POST['value'])&&($_POST['card_number'])){
            $phoneData = Card::model()->findByAttributes(array('card_number'=>$_POST['card_number']));
            if($phoneData){
                $phone_unique = Card::model()->findByAttributes(array('phone_number'=>$_POST['value']));
                $check_flag=1;
                if($phone_unique){
                    if($phone_unique->card_number!=$_POST['card_number']){
                        $check_flag=0;
                    }
                }
                if($check_flag==1){
                    $transaction = Yii::app()->db->beginTransaction();
                    $otp = str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
                    if($_POST['is_signup']==1){
                        $phoneData->otp = $otp; // Replace the otp
                        $phoneData->card_issue_status = "OTP";
                        $phoneData->phone_number = $_POST['value'];
                    }else{
                        $phoneData = Login::model()->findByAttributes(array('username'=>$_POST['card_number']));
                        $phoneData->reset_code = $otp;
                    }
                    if($phoneData->save(false)){
                        $messageContent = "Hello ,\r\nPlease enter yout OTP,\r\nOTP:".$otp."\r\n Cheers\r\nTeam NoQnri";
                        //if(Common::SendSMS('+91'.$_POST['value'],$messageContent)){
                            $transaction->commit();
                            if($_POST['is_signup']==1){
                                echo (json_encode(array('status'=>'true','phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status,'message'=>'OTP has been sent to your registered phone number')));
                            }else{
                                echo (json_encode(array('status'=>'true','phone_number'=>$_POST['value'],'card_issue_status'=>0,'message'=>'OTP has been sent to your registered phone number')));
                            }
                        /*}else{
                            $transaction->rollBack();
                            echo (json_encode(array('status'=>'false','message'=>'Error while senting the OTP,Please try after some time')));
                        }*/
                    }else{
                        $transaction->rollBack();
                        echo (json_encode(array('status'=>'false','message'=>'Error while processing the data,Please try after some time')));
                    }
                }else{
                    echo (json_encode(array('status'=>'false','message'=>'This phone number has already been taken'))); 
                }
            }else{
                echo (json_encode(array('status'=>'false','message'=>'Card Not Found')));
            }
        }else{
            echo (json_encode(array('status'=>'false','message'=>'Empty value Submitted')));
        }
    }
    
    public function actionCheck_otp(){
        if(isset($_POST['value'])&&($_POST['card_number'])){
            if($_POST['is_signup']==1){
                $phoneData = Card::model()->findByAttributes(array('card_number'=>$_POST['card_number'],'phone_number'=>$_POST['value'],'otp'=>$_POST['otp']));
            }else{
                $phoneData = Login::model()->findByAttributes(array('username'=>$_POST['card_number'],'reset_code'=>$_POST['otp']));
            }
            if($phoneData){
                $transaction = Yii::app()->db->beginTransaction();
                if($_POST['is_signup']==1){
                    $phoneData->card_issue_status = "Registration";
                }
                if($phoneData->save(false)){
                    $transaction->commit();
                    if($_POST['is_signup']==1){
                        echo (json_encode(array('status'=>'true','phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status,'message'=>'OTP verification completed')));
                    }else{
                        echo (json_encode(array('status'=>'true','message'=>'OTP verification completed & rest your password')));
                    }
                }else{
                    $transaction->rollBack();
                    echo (json_encode(array('status'=>'false','message'=>'Error while processing request,Please try after some time')));
                }
            }else{
                echo (json_encode(array('status'=>'false','message'=>'Submitted OTP is mis-match')));
            }
        }else{
            echo (json_encode(array('status'=>'false','message'=>'Empty value Submitted')));
        }
    }
    public function actionrequestOtp(){
        if(isset($_POST['value'])&&($_POST['phone_number'])){
            $otpData = Card::model()->findByAttributes(array('card_number'=>$_POST['value'],'phone_number'=>$_POST['phone_number']));
            if($otpData){
                $transaction = Yii::app()->db->beginTransaction();
                $otp = str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
                if($_POST['is_signup']==1){
                    $otpData->otp = $otp;
                    $otpData->card_issue_status = "OTP";
                    $otpData->updated_at = date('Y-m-d H:i:s');
                    $otpData->updated_by = Yii::app()->user->id;
                }else{
                    $otpData = Login::model()->findByAttributes(array('username'=>$_POST['value']));
                    $otpData->reset_code = $otp;
                }
                if($otpData->save(false)){
                    $messageContent = "Hello ,\r\nPlease enter yout OTP,\r\nOTP:".$otp."\r\n Cheers\r\nTeam NoQnri";
                    //if(Common::SendSMS('+91'.$_POST['phone_number'],$messageContent)){
                        $transaction->commit();
                        echo (json_encode(array('status'=>'true','msg'=>'OTP has been generated and sent successfully','message'=>'OTP has been sent to your registered mobile number')));
                    /*}else{
                        $transaction->rollBack();
                        echo (json_encode(array('status'=>'false','message'=>'Error while senting OTP,try after some time')));
                    }*/
                }else{
                    $transaction->rollBack();
                    echo (json_encode(array('status'=>'false','message'=>'Error while save the data')));
                }
            }else{
                echo (json_encode(array('status'=>'false','message'=>'Card and Phone mis-match')));
            }
        }
    }
    
    public function actionError()
    {
        $this->page_title ='Error';
        $error = Yii::app()->errorHandler->error;
        echo "<pre>";print_r($error);die;
        $this->render('//layouts/error',array('error'=>$error));
        /*$this->renderJSON(array(
            'message' => Yii::app()->errorHandler->error['message']
        ), Yii::app()->errorHandler->error['code']);*/
    }
    
   public function actionCheck_unity(){
       if(isset($_POST['value']) && ($_POST['key']) && ($_POST['table'])){
           if($_POST['value']!=""|| $_POST['value']!=NULL || empty($_POST['value'])){
               $contentData = $_POST['table']::model()->findByAttributes(array($_POST['key']=>$_POST['value']));
               if($contentData){
                   echo(json_encode(array('status'=>'false','msg'=>$_POST['value'] .' Already taken..!','color'=>'#FF0000')));
               }else{
                   echo(json_encode(array('status'=>'true','msg'=>$_POST['value'] .' Available..!','color'=>'#00a65a')));
               }
            }
       }
   }
    public function actionForgot(){
        $this->layout=false;
        date_default_timezone_set('Asia/Kolkata');
        if(isset($_POST['Login']))
        {
            $loginData = Login::model()->findByAttributes(array('username'=>$_POST['Login']['username_input']));
            if($loginData){
                $loginData->password = md5($_POST['Login']['password']);
                if($_POST['Login']['userType']=="1"){
                    $loginData->reset_code = '';
                }
                if($loginData->save(false)){
                    Yii::app()->user->setFlash('success_flash_msg', "Password reset successfully");
                    $this->renderJSON(array('status' => 'true', 'message' => 'Password reset successfully'));
                }else{
                    $this->renderJSON(array('status' => 'false', 'message' => 'Error while reset the password'));
                }
            }else{
                $this->renderJSON(array('status' => 'false', 'message' => 'Username not found'));
            }
        }
    }
    public function actionRegister(){
        if(isset($_POST['Customer']) && $_POST['Login']){
            $cardData = Card::model()->findByAttributes(array('card_number'=>$_POST['Login']['username']));
                if($cardData){
                    $customer = new Customer;
                    $login = new Login;
                    $login->username = $_POST['Login']['username'];
                    $login->password = md5($_POST['Login']['password']);
                    $login->role_id = 3;
                    $transaction = Yii::app()->db->beginTransaction();
                    if($login->save(false)){
                        $customer->login_id = $login->id;
                        $customer->attributes = $_POST['Customer'];
                        if($customer->save(false)){
                            $messageContent = "Hello ".$_POST['Customer']['first_name'].",\r\nYour account has been activated,\r\nCredentails are below,\r\nUsername:".$_POST['Login']['username']."\r\n Password: ".$_POST['Login']['password']."\r\n Cheers\r\nTeam NoQnri";
                            //if(Common::SendSMS('+91'.$cardData->phone_number,$messageContent)){
                                $transaction->commit();
                                $cardData->otp = NULL;
                                $cardData->card_issue_status = "Approved";
                                $cardData->updated_at = date('Y-m-d:h-i-s');
                                if($cardData->save(false)){
                                    Yii::app()->user->setFlash('success_flash_msg', 'Registration has been successful,Credentails sent to the registered contact number');
                                    $this->renderJSON(array('status' => 'true', 'message' => 'success'));
                                }else{
                                    $transaction->rollBack();
                                    Yii::app()->user->setFlash('error_flash_msg', 'Unable to register this time.Please try after sometime');
                                    $this->renderJSON(array('status' => 'false', 'message' => '1'));
                                }
                            /*}else{
                                $transaction->rollBack();
                                Yii::app()->user->setFlash('error_flash_msg', 'Unable to register this time.Please try after sometime');
                                $this->renderJSON(array('status' => 'false', 'message' => '2'));
                            }*/
                        }else{
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error_flash_msg', 'Unable to register this time.Please try after sometime');
                            $this->renderJSON(array('status' => 'false', 'message' => '2'));
                        }
                    }else{
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('error_flash_msg', 'Unable to register this time.Please try after sometime');
                        $this->renderJSON(array('status' => 'false', 'message' => '4'));
                    }
                }else{
                    $transaction->rollBack();
                    Yii::app()->user->setFlash('error_flash_msg', 'Invalid card number');
                    $this->renderJSON(array('status' => 'false', 'message' => 'Invalid card number'));
                }
        }
    }

    public function actionGetState(){
        if($_POST['value']){
            $StateDetails = State::model()->findAllByAttributes(array('country_id'=>$_POST['value']));
            if($StateDetails){?>
                <label for="Customer_state_id">State Name</label>
                <select id="Customer_state_id" class="form-control select2" data-placeholder="Select State" name="Customer[state_id]" data-validation="required" onChange="SelectCity(this);">
                    <option value="">Select State</option>
                <?php foreach($StateDetails as $user_data){?>
                    <option value="<?php echo $user_data->id?>"><?php echo $user_data->state_name;?></option>
                <?php }?>
                </select>
            <?php }else{
                echo "<label for='Customer_state_id'>State Name</label><select class='form-control select2' multiple='multiple' data-placeholder='Select State'><option value=''>Select State</option></select>";
            }
        }
    }
    
    public function actionGetCity(){
        if($_POST['value']){
            $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$_POST['value']));
            if($CityDetails){?>
                <label for="Customer_city_id">City Name</label>
                <select id="Customer_city_id" class="form-control select2" data-placeholder="Select city" name="Customer[city_id]" data-validation="required">
                <option value="">Select City</option>
                <?php foreach($CityDetails as $user_data){?>
                    <option value="<?php echo $user_data->id?>"><?php echo $user_data->name;?></option>
                <?php }?>
                </select>
            <?php }else{
                echo "<label for='Customer_city_id'>City Name</label><select class='form-control select2' multiple='multiple' data-placeholder='Select city'><option value=''>Select City</option></select>";
            }
        }
    }

    public function actionCountryCode(){
        if($_POST['value']){
            $countryData = Country::model()->findByPk($_POST['value']);
            if($countryData){
                echo trim(str_replace("(".$countryData->country_code.")",'',$countryData->country_phone_code));
            }
        }
    }

    public function actionGetusername(){
        if(isset($_POST['value']) && !empty($_POST['value'])){
            $cardData = Card::model()->findByAttributes(array('card_number'=>$_POST['value']));
            if($cardData){
                if($cardData->card_issue_status=="Approved"){
                    echo(json_encode(array('status'=>'error','username'=>$cardData->card_number,'msg'=>'Already registered')));
                }else{
                    echo(json_encode(array('status'=>'success','username'=>$cardData->card_number,'msg'=>'')));
                }
            }else{
                echo(json_encode(array('status'=>'error','username'=>'','msg'=>"Couldn't find any matching card number")));
            }
        }
    }
    
    public function actionLogout() {
        $userType = Yii::app()->user->userType;
        if($userType=="Admin" || $userType=="Super Admin"){
            Yii::app()->user->logout();
            $this->redirect(array('partner/index'));
        }else if($userType=="Customer"){
            Yii::app()->user->logout();
            $this->redirect(array('site/index'));
        }else{
            Yii::app()->user->logout();
            $this->redirect(array('partner/index'));
        }
    }
}