<?php

class CountryController extends Controller
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
				'actions'=>array('create','update','index','view','ChangeStatus'),
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

	public function actionCreate()
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Create Country';	
			$model=new Country;
			if(isset($_POST['Country']))
			{
				$model->attributes=$_POST['Country'];
				$model->created_at = date('Y-m-d H:i:s');
				if($model->validate() && $model->save()){
					Yii::app()->user->setFlash('success',"Country '".$_POST['Country']['country_name']."' added successfully");
			        Common::activityLog($model->id, 'Country', 'New Country '.$_POST['Country']['country_name'].' created', date('Y-m-d H:i:s'));
			        $this->redirect(Yii::app()->baseURL.'/country');
				}
			}
			$this->render('create',array(
				'model'=>$model,
			));
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionUpdate($id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Update Country';
			$model=$this->loadModel($id);
			if(isset($_POST['Country']))
			{
				$model->attributes=$_POST['Country'];
				$model->updated_at = date('Y-m-d H:i:s');
				if($model->validate() && $model->save())
					Yii::app()->user->setFlash('success',"Country '".$_POST['Country']['country_name']."' updated successfully");
			        Common::activityLog($model->id, 'Country', 'Country '.$_POST['Country']['country_name'].' updated', date('Y-m-d H:i:s'));
			        $this->redirect(Yii::app()->baseURL.'/country');
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Manage Country';
			$model=new Country('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Country']))
				$model->attributes=$_GET['Country'];
			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}
	
	public function loadModel($id)
	{
		$model=Country::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='country-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionChangeStatus(){
	    if(isset($_POST['state'])){
	        $state = $_POST['state'];
	        $status = ($state=='true')?'Y':'N';
	        $country = Country::model()->findByPk($_POST['id']);
	        if($country){
	            $country->status=$status;
	            if($country->save(false)){
	                echo $country->status;
	            }else{
	                echo "0";
	            }
	        }
	    }
	}
}
