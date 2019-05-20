<?php

class PrivillageUpdatesController extends Controller
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ChangeStatus','view'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(Yii::app()->user->userType=="Admin"){
			if(Yii::app()->user->userType=="Admin"){
				$this->render('view',array(
					'model'=>$this->loadModel($id),
				));
			}
		}else{
			throw new CHttpException(401,'You are not authorised to perform this action');
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(Yii::app()->user->userType=="Admin"){
			$model=new PrivillageUpdates;
			if(isset($_POST['PrivillageUpdates']))
			{
				$model->attributes=$_POST['PrivillageUpdates'];
				$model->created_at = date('Y-m-d H:i:s');
				$imageDetails=CUploadedFile::getInstance($model,'image');
	            if($imageDetails!=NULL){
	                $privillage_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/privillage_updates/'.$model->partner_id.'/';
	                if (!file_exists($privillage_path)){
	                    mkdir($privillage_path, 0777, true);
	                }
	                $image_name = $_FILES['PrivillageUpdates']['name']['image'];
	                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
	                $model->image = "privillage_updates_".date('ymdhis').".".$ext;
	                $imageDetails->saveAs($privillage_path.$model->image);
	            }
				if($model->validate() && $model->save()){
					$message = "New 'privillage update' added";
	                Yii::app()->user->setFlash('success','New privillage update added');
	                $this->redirect(Yii::app()->baseURL.'/privillageUpdates');
				}else{
					echo "<pre>";print_r($model->getErrors());die;
				}
			}
			$this->render('create',array(
				'model'=>$model,
			));
		}else{
			throw new CHttpException(401,'You are not authorised to perform this action');
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$model=$this->loadModel($id);
			if($model->image!=NULL){
			    $old_image = $model->image;
			}
			if(isset($_POST['PrivillageUpdates']))
			{
				$model->attributes=$_POST['PrivillageUpdates'];
				$model->updated_at = date('Y-m-d H:i:s');
				$imageDetails=CUploadedFile::getInstance($model,'image');
	            if($imageDetails!=NULL){
	                $privillage_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/privillage_updates/'.$model->partner_id.'/';
	                if($old_image!=NULL){
			            unlink($privillage_path.$old_image);
			        }
	                if (!file_exists($privillage_path)){
	                    mkdir($privillage_path, 0777, true);
	                }
	                $image_name = $_FILES['PrivillageUpdates']['name']['image'];
	                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
	                $model->image = "privillage_updates_".date('ymdhis').".".$ext;
	                $imageDetails->saveAs($privillage_path.$model->image);
	            }
				if($model->validate() && $model->save()){
					$message = "New 'privillage update' updated";
	                Common::activityLog($login->id, 'PRIVILLAGE_UPDATES', $message, date('Y-m-d H:i:s'));
	                Yii::app()->user->setFlash('success',"New 'privillage update' updated");
	                $this->redirect(Yii::app()->baseURL.'/privillageUpdates');
				}
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}else{
			throw new CHttpException(401,'You are not authorised to perform this action');
		}
	}

	public function actionChangeStatus(){
	    if(isset($_POST['state'])){
	        $state = $_POST['state'];
	        $status = ($state=='true')?'Y':'N';
	        $privillage = PrivillageUpdates::model()->findByPk($_POST['id']);
	        if($privillage){
	            $privillage->status=$status;
	            if($privillage->save(false)){
	                echo $privillage->status;
	            }else{
	                echo "0";
	            }
	        }
	    }
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->userType=="Admin"){
	        $model=new PrivillageUpdates('search');
			$this->page_title   = 'Privillage Updates';
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['PrivillageUpdates']))
				$model->attributes=$_GET['PrivillageUpdates'];
			$this->render('admin',array(
				'model'=>$model,
			));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PrivillageUpdates the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PrivillageUpdates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PrivillageUpdates $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='privillage-updates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
