<?php

class StateController extends Controller
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

	public function actionCreate($country_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Create State';
			$countryData = Country::model()->findByPk($country_id);	
			if($countryData){
				$model=new State;
				if(isset($_POST['State']))
				{
					$model->attributes=$_POST['State'];
					$model->created_at = date('Y-m-d H:i:s');
					if($model->validate() && $model->save()){
						Yii::app()->user->setFlash('success',"State '".$_POST['State']['state_name']."' added successfully");
				        Common::activityLog($model->id, 'State', 'New State '.$_POST['State']['state_name'].' created', date('Y-m-d H:i:s'));
				        $this->redirect(Yii::app()->baseURL.'/state/index/country_id/'.$country_id);
					}
				}
				$this->render('create',array(
					'model'=>$model,
					'country'=>$countryData
				));
			}else{
				throw new CHttpException(404,'Requested item not found');
			}
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionUpdate($id,$country_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Update State';
			$countryData = Country::model()->findByPk($country_id);
			if($countryData){
				$model=$this->loadModel($id);
				if(isset($_POST['State']))
				{
					$model->attributes=$_POST['State'];
					$model->updated_at = date('Y-m-d H:i:s');
					if($model->validate() && $model->save())
						Yii::app()->user->setFlash('success',"State '".$_POST['State']['state_name']."' updated successfully");
				        Common::activityLog($model->id, 'State', 'State '.$_POST['State']['state_name'].' updated', date('Y-m-d H:i:s'));
				        $this->redirect(Yii::app()->baseURL.'/state/index/country_id/'.$country_id);
				}
				$this->render('update',array(
					'model'=>$model,
					'country'=>$countryData
				));
			}else{
				throw new CHttpException(404,'Requested item not found');
			}
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex($country_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$countryData = Country::model()->findByPk($country_id);
			$this->page_title   = $countryData->country_name.' - Manage State';
			$model=new State('search');
			$model->unsetAttributes();  // clear any default values
			$model->country_id = $country_id;
			if(isset($_GET['State']))
				$model->attributes=$_GET['State'];
			$this->render('admin',array(
				'model'=>$model,
				'country'=>$countryData
			));
		}
	}
	public function loadModel($id)
	{
		$model=State::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param State $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='state-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionChangeStatus(){
	    if(isset($_POST['state'])){
	        $state = $_POST['state'];
	        $status = ($state=='true')?'Y':'N';
	        $country = State::model()->findByPk($_POST['id']);
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
