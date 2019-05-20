<?php

class CustomerController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','customerDelete','customerView','changeStatus','RemovePhone','RemoveAddress'),
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

	public function init()
	{
	    if((Yii::app()->user->getId()==null) && (!isset(Yii::app()->user->userType)))
	    {
	        $this->redirect(Yii::app()->baseURL."/site/");
	    }
	}
	
	public function actioncustomerView($id)
	{
	    if(Yii::app()->user->userType=="Admin"){
    	    $this->page_title ='Customer: '.$customer->first_name." ".$customer->last_name;
    	    $customer=$this->loadModel($id);
    	    $country = new Country();
    	    $state  = new State();
    	    $city = new City();
    	    $imageData = ProfileImages::model()->findByAttributes(array('owner_id'=>$id,'owner_type'=>'0'));
    	    if($imageData){
    	        $imageData = ProfileImages::model()->findByPk($imageData->id);
    	        $old_pic = $imageData->image;
    	        $img_path = Yii::app()->basePath.'/../uploads/customer/profile_image/'.$old_pic;
    	    }else{
    	        $imageData = new ProfileImages();
    	        $old_pic=NULL;
    	        $img_path = NULL;
    	    }
    	    
    	    $this->render('view',array(
    	        'customer'=>$customer,'country'=>$country,'state'=>$state,'city'=>$city,'imageData'=>$imageData
    	    ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new Customer;
		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/
		
	public function actionUpdate($id)
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $customer=$this->loadModel($id);
	        $imageData = ProfileImages::model()->findByAttributes(array('owner_id'=>$id,'owner_type'=>'0'));
	        if($imageData){
	            $imageData = ProfileImages::model()->findByPk($imageData->id);
	            $old_pic = $imageData->image;
	            $img_path = Yii::app()->basePath.'/../uploads/customer/profile_image/'.$old_pic;
	        }else{
	            $imageData = new ProfileImages();
	            $old_pic=NULL;
	            $img_path = NULL;
	        }
	        if($customer){
	            $this->page_title ='Update '.$customer->first_name;
	            $successFlag = false;
	            if(isset($_POST))
	            {
	                $transaction = Yii::app()->db->beginTransaction();
	                if(isset($_POST['Customer'])){
	                    $customer->attributes = $_POST['Customer'];
	                    $customer->updated_at = date('Y-m-d H:i:s');
	                    $customer->updated_by = Yii::app()->user->id;
	                    if($customer->validate() && $customer->save()){
                            $imageDetails=CUploadedFile::getInstance($imageData,'image');
                            if($imageDetails!=NULL){
                                $path = $_FILES['ProfileImages']['name']['image'];
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $imageData->image = $customer->first_name."_".date('ymdhis').".".$ext;
                                $imageData->owner_id = $customer->id;
                                $imageData->owner_type = 0;
                                if(!$imageData->id){
                                   $imageData->created_date = date('Y-m-d H:i:s');
                                }
                                if($imageData->validate()) {
                                    $file_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/customer/profile_image/';
                                    if (!file_exists($file_path)){
                                        mkdir($file_path, 0777, true);
                                    }
                                    if($old_pic!=NULL && file_exists($img_path)){
                                        unlink($img_path);
                                    }
                                    $path=$file_path.$imageData->image;
                                    $imageDetails->saveAs($path);
                                    if($imageData->save()){
                                        $successFlag = true;
                                    }else{
                                        $successFlag = false;
                                    }
                                }else{
                                    $successFlag = false;
                                }
                            }else{
                                $successFlag = true;
                            }
	                    }else{
	                        $successFlag = false;
	                    }
	                    if($successFlag===true){
	                        $transaction->commit();
	                        Yii::app()->user->setFlash('success','Customer has been successfully updated');
	                        if(Yii::app()->user->userType=="Partner"){
	                            $this->redirect(Yii::app()->baseURL.'/customer/update/'.$id);
	                        }else{
	                            $this->redirect(Yii::app()->baseURL.'/customer');
	                        }
	                    }else{
	                        //print_r($customer->getErrors());
	                        //print_r($phone->getErrors());die;
	                        $transaction->rollBack();
	                        Yii::app()->user->setFlash('success','Error while registering partner');
	                    }
	                }else{
	                    $successFlag = false;
	                }
	            }
	            
	            $this->render('update',array(
	                'customer'=>$customer,'imageData'=>$imageData
	            ));
	        }else{
	            throw new CHttpException(404,'Page does not exist');
	        }
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actioncustomerDelete($id)
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $model = $this->loadModel($id);
	        $this->loadModel($id)->delete();
	        Yii::app()->user->setFlash('success', "Customer has been deleted successfully.");
	        $message = "Customer ".$model->first_name.' '.$model->last_name." deleted";
	        Common::activityLog($model->id, 'ADMIN', $message, date('Y-m-d H:i:s'));
	        $this->redirect(array('customer'));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	public function actionIndex()
	{
	    if(Yii::app()->user->userType=="Admin"){
	        $model = new Customer('search');
	        $this->page_title   = 'Customer Management';
	        $model->unsetAttributes();  // clear any default values
	        if (isset($_GET['Customer']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Customer'];
	            $this->render('admin', array(
	                'model' => $model,
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	public function actionAdmin()
	{
	    if(Yii::app()->user->userType=="Admin"){
    		$model=new Customer('search');
    		$model->unsetAttributes();  // clear any default values
    		if(isset($_GET['Customer']))
    			$model->attributes=$_GET['Customer'];
    
    		$this->render('admin',array(
    			'model'=>$model,
    		));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	public function actionchangeStatus(){
	    if(isset($_POST['state'])){
	        $status = ($_POST['state']=='true')?'Y':'N';
	        $customer = Customer::model()->findByPk($_POST['id']);
	        if($customer){
	            $loginData = Login::model()->findByAttributes(array('id'=>$customer->login_id));
	            if($loginData){
	                $loginData->login_status= $status;
	                if($loginData->save(false)){
	                    echo $loginData->login_status;
	                }else{
	                    echo "0";
	                }
	            }
	        }
	        
	    }
	}
	public function loadModel($id)
	{
		$model=Customer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
