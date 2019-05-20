<?php

class PartnerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','Check_username','Confirm_phone','Check_otp','RequestOtp'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','partnerDelete','partnerView','changeStatus','RemovePhone','partnerView','Admin','Remove_gallery_item','FormulaGrid','Create_formula_form','SubmitFormula','FormulaChangeStatus','Update_formula_form'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/*public function init()
	{
	    if((Yii::app()->user->getId()==null) && (!isset(Yii::app()->user->userType)))
	    {
	        $this->redirect(Yii::app()->baseURL."/partner");
	    }
	}*/
	
	public function actionIndex()
	{
	    $this->layout = false;
	    if (!Yii::app()->user->isGuest) {
	        $this->redirect(array('/dashboard/'));
	    }
	    $model = new ForkindUserLogin();
	    $login = new Login();
	    if(isset($_POST['ajax']) && $_POST['ajax']==='login-user')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    if (isset($_POST['ForkindUserLogin'])) {
	        $model->attributes = $_POST['ForkindUserLogin'];
	        if($model->validate() && $model->login()){
	            $message="Partner ".Yii::app()->user->fullname." Logged In ";
	            date_default_timezone_set('Asia/Kolkata');
	            $date_last = date("Y-m-d H:i:s");
	            Common::activityLog(Yii::app()->user->getId(), 'LOG IN', $message, $date_last);
	            $this->redirect(array('/dashboard'));
	        } else {
	            Yii::app()->user->setFlash('error', 'Username or Password incorrect');
	        }
	    }
	    $this->render('//site/partner', array('model' => $model,'login'=>$login));
	}
	public function actionadminView($id)
	{
	    $model=$this->loadModel($id);
	    $this->page_title ='Admin: '.$model->first_name." ".$model->last_name;
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionAdmin()
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $model = new Partner('search');
	        $this->page_title   = 'Partner Management';
	        $model->unsetAttributes();  // clear any default values
	        if (isset($_GET['Partner']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Partner'];
	            $this->render('admin', array(
	                'model' => $model,
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	
	public function actionCreate()
	{
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
	        $partner = new Partner();
	        $country = new Country();
	        $state  = new State();
	        $city = new City();
	        $login = new Login();
	        $photoModel = new PartnerPhotos();
	        $this->page_title ='Create Partner';
	        $successFlag = false;
	        if(isset($_POST))
	        {
	            $transaction = Yii::app()->db->beginTransaction();
	            if(isset($_POST['Partner'])){
	                $partner = new Partner();
	                $partner->attributes = $_POST['Partner'];
	                $partner->created_at = date('Y-m-d H:i:s');
	                $partner->created_by = Yii::app()->user->id;
	                if($partner->validate() && $partner->save()){
                        $imageDetails=CUploadedFile::getInstance($partner,'logo');
                        if($imageDetails!=NULL){
                            $image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$partner->id.'/logo/';
                            if (!file_exists($image_path)){
                                mkdir($image_path, 0777, true);
                            }
                            $image_name = $_FILES['Partner']['name']['logo'];
                            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                            $partnerName = str_replace(' ', '_', $partner->name);
                            $partner->logo = $partnerName."_"."logo"."_".date('ymdhis').".".$ext;
                            $imageDetails->saveAs($image_path.$partner->logo);
                            $partner->save(false);
                        }
                        
                        $photoDetails = CUploadedFile::getInstances($photoModel, 'image');
                        if(!empty($photoDetails)){
                            $image_image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$partner->id."/photo/";
                            if (!file_exists($image_image_path)){
                                mkdir($image_image_path, 0777, true);
                            }
                            $successPhoto = array();
                            $failedPhoto = array();
                            $path=0;
                            foreach ($photoDetails as $i=>$photo){
                                $photoModel = new PartnerPhotos();
                                $img_name = str_replace(' ', '_', $photo->name);
                                $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                                $image_name = $i."_"."photo"."_".date('ymdhis').".".$ext;
                                $photoModel->image = $image_name;
                                $photoModel->owner_id = $partner->id;
                                $photoModel->created_date = date('Y-m-d H:i:s');
                                if($photoModel->validate()&&$photoModel->save()){
                                    $path = '/uploads/partner/'.$partner->id.'/photo/';
                                    $photo->saveAs(Yii::app()->basePath .DIRECTORY_SEPARATOR.'..'.$path.$image_name);
                                    array_push($successPhoto,'1');
                                }else{
                                    array_push($failedPhoto,'1');
                                }
                            }
                            if(count($photoDetails)==count($successPhoto)){
                                $successFlag=true;
                            }else{
                                $successFlag=false;
                            }
                        }
	                }else{
	                    $successFlag = false;
	                }
	                if($successFlag===true){
	                    $transaction->commit();
	                    $message = "New partner ".$partner->name." registered ";
	                    Common::activityLog($login->id, 'REGISTRATION', $message, date('Y-m-d H:i:s'));
	                    Yii::app()->user->setFlash('success','Partner registration has been successfully completed');
	                    $this->redirect(Yii::app()->baseURL.'/partner/admin');
	                }else{
	                   /* print_r($partner->getErrors());
	                     print_r($login->getErrors());
	                     print_r($partner_address->getErrors());
	                     print_r($phone->getErrors());die;
	                    $transaction->rollBack();*/
	                    Yii::app()->user->setFlash('success','Error while registering partner');
	                }
	            }else{
	                $successFlag = false;
	            }
	        }
	        $this->render('create',array(
	            'partner'=>$partner,'country'=>$country,'state'=>$state,'city'=>$city,'login'=>$login,'photoModel'=>$photoModel
	        ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	
	
	public function actionUpdate($id)
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $partner=$this->loadModel($id);
	        if($partner->logo!=NULL){
	           $old_logo = $partner->logo;
	        }
	        $transaction = Yii::app()->db->beginTransaction();
	        $country = new Country();
	        $state  = new State();
	        $city = new City();
	        $photos = PartnerPhotos::model()->findAllByAttributes(array('owner_id'=>$id));
	        $photoModel = new PartnerPhotos(); 
	        if($partner){
	            if($partner->id==1){
	               $this->page_title ='Update '.$partner->name." (Super Admin)";
	            }else{
	               $this->page_title ='Update '.$partner->name;
	            }
        		$successFlag = false;
    		    if(isset($_POST['Partner'])){
    		        $partner->attributes = $_POST['Partner'];
		            $partner->updated_at = date('Y-m-d H:i:s');
		            $partner->updated_by = Yii::app()->user->id;
		            if($partner->validate() && $partner->save()){
                        $imageDetails=CUploadedFile::getInstance($partner,'logo');
                        if($imageDetails!=NULL){
                        	$image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$id."/logo/";
					        if (!file_exists($image_path)){
					            mkdir($image_path, 0777, true);
					        }
                            if($old_logo!=NULL){
                                $old_img = $image_path.$old_logo;
                                if(file_exists($old_img)){
                                    unlink($old_img);
                                }
                            }
                            $img_name = $_FILES['Partner']['name']['logo'];
                            $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                            $partnerName = str_replace(' ', '_', $partner->name);
                            $partner->logo = $imageDetails;//$partnerName."_"."logo"."_".date('ymdhis').".".$ext;
                            $partner->save(false);
                            $imageDetails->saveAs($image_path.$partner->logo);
                        }else{
                            if($old_logo!=NULL){
                                $partner->logo = $old_logo;
                                $partner->save(false);
                            }
                        }
                        $photoDetails = CUploadedFile::getInstances($photoModel, 'image');
                        if(!empty($photoDetails)){
                        	$image_image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$id."/photo/";
					        if (!file_exists($image_image_path)){
					            mkdir($image_image_path, 0777, true);
					        }
                            $successPhoto = array();
                            $failedPhoto = array();
                            $path=0;
                            foreach ($photoDetails as $i=>$photo){
                                $imageInfo = getimagesize($photo->getTempName());
                                //echo $imageInfo[0]."=>".$imageInfo[1];die;
                                //if($imageInfo[0]=='1400' && $imageInfo[1]=='500'){
	                                $photoModel = new PartnerPhotos();
	                                $img_name = $photo->name;
	                                $ext = pathinfo($img_name, PATHINFO_EXTENSION);
	                                $image_name = $i."_"."photo"."_".date('ymdhis').".".$ext;
	                                $photoModel->owner_id = $id;
	                                $photoModel->image = $image_name;
	                                $photoModel->created_date = date('Y-m-d H:i:s');
	                                if($photoModel->validate()&&$photoModel->save()){
	                                    $path = '/uploads/partner/'.$id.'/photo/';
	                                    $photo->saveAs(Yii::app()->basePath .DIRECTORY_SEPARATOR.'..'.$path.$image_name);
	                                    array_push($successPhoto,'1');
	                                }else{
	                                    array_push($failedPhoto,'1');
	                                }
	                                sleep(1);
                                //}
                            }
                            if(count($failedPhoto)==0){
                                $successFlag=true;
                            }else{
                                $successFlag=false;
                            }
                        }
                    }else{
                        $successFlag = false;
                    }
		            
			        if($successFlag===true){
			            $transaction->commit();
			            Yii::app()->user->setFlash('success','Partner has been successfully updated');
			            if(Yii::app()->user->userType=="Partner"){
			                $this->redirect(Yii::app()->baseURL.'/partner/update/'.$id);
			            }else{
			                $this->redirect(Yii::app()->baseURL.'/partner/admin');
			            }
			        }else{
			            /*print_r($partner->getErrors());
			             print_r($address->getErrors());
			             print_r($phone->getErrors());die;*/
			            $transaction->rollBack();
			            Yii::app()->user->setFlash('success','Error while registering partner');
			        }
    		    }else{
    		        $successFlag = false;
    		    }
        		$this->render('update',array(
        		    'partner'=>$partner,'country'=>$country,'state'=>$state,'city'=>$city,'photos'=>$photos,'photoModel'=>$photoModel
        		));
    	    }else{
    	        throw new CHttpException(404,'Page does not exist');
    	    }
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionRemove_gallery_item(){
	    $partner_id = $_POST['partner_id'];
	    $image_id = $_POST['image_id'];
	    $image_name = $_POST['image_name'];
	    if($image_id!=NULL){
	        $ImageData = PartnerPhotos::model()->findByPk($image_id);
	        if($ImageData->delete()){
	           unlink((dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$partner_id.'/photo/'.$image_name);
	           $htm=1;
	        }else{
	            $htm=0;
	        }
	    }else{
	        $htm=0;
	    }
	    echo $htm;
	}
	public function actionRemovePhone(){
	    if(isset($_POST['phone_id'])){
	        $phoneDetails = Phone::model()->findByPk($_POST['phone_id']);
	        if($phoneDetails){
	            $phoneDetails->delete();
	            echo "1";
	        }else{
	            echo "0";
	        }
	    }
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionpartnerDelete($id)
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $model = $this->loadModel($id);
	        $this->loadModel($id)->delete();
	        Yii::app()->user->setFlash('success', "Partner has been deleted successfully.");
	        $message = "Partner ".$model->name." deleted";
	        Common::activityLog($model->id, 'Partner', $message, date('Y-m-d H:i:s'));
	        $this->redirect(array('partner/admin'));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}


	/**
	 * Manages all models.
	 */
	
	public function actionpartnerView($id){
	    $this->page_title   = 'View Partner';
	    $partner=$this->loadModel($id);
	    $country = new Country();
	    $state  = new State();
	    $city = new City();
	    $photos = PartnerPhotos::model()->findAllByAttributes(array('owner_id'=>$id));
	    $photoModel = new PartnerPhotos(); 
	    $this->render('view', array('partner'=>$partner,'country'=>$country,'state'=>$state,'city'=>$city,'photoModel'=>$photoModel,'photos'=>$photos));
	}
	public function actionchangeStatus(){
	    if(isset($_POST['state'])){
	        $status = ($_POST['state']=='true')?'Y':'N';
	        $partner = Partner::model()->findByPk($_POST['id']);
	        if($partner){
	            $partner->status= $status;
	            if($partner->save(false)){
	                echo $partner->status;
	            }else{
	                echo "0";
	            }
	        }
	        
	    }
	}
	
	public function loadModel($id)
	{
		$model=Partner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
