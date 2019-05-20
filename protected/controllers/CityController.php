<?php

class CityController extends Controller
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

	/**
	 * Manages all models.
	 */
	public function actionIndex($state_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$stateData = State::model()->findByPk($state_id);
			$countryData = Country::model()->findByPk($stateData->country_id);
			$this->page_title   = $stateData->state_name.' - Manage City';
			$model=new City('search');
			$model->unsetAttributes();  // clear any default values
			$model->state_id = $state_id;
			if(isset($_GET['City']))
				$model->attributes=$_GET['City'];
			$this->render('admin',array(
				'model'=>$model,
				'state'=>$stateData,
				'country'=>$countryData
			));
		}
	}

	public function actionCreate($state_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$stateData = State::model()->findByPk($state_id);
			if($stateData){
				$countryData = Country::model()->findByPk($stateData->country_id);
				if($countryData){
					$this->page_title   = 'Create City';	
					$model=new City;
					if(isset($_POST['City']))
					{
						$model->attributes=$_POST['City'];
						$model->created_at = date('Y-m-d H:i:s');
						if($model->validate() && $model->save()){
							Yii::app()->user->setFlash('success',"City '".$_POST['City']['name']."' added successfully");
					        Common::activityLog($model->id, 'City', 'New City '.$_POST['City']['name'].' created', date('Y-m-d H:i:s'));
					        $this->redirect(Yii::app()->baseURL.'/city/index?state_id='.$_POST['City']['state_id']);
						}
					}
					$this->render('create',array(
						'model'=>$model,
						'state'=>$stateData,
						'country'=>$countryData
					));
				}else{
					throw new CHttpException(404,'Requested item not found');
				}
			}else{
				throw new CHttpException(404,'Requested item not found');
			}
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionUpdate($id,$state_id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Update City';
			$stateData = State::model()->findByPk($state_id);
			if($stateData){
				$countryData = Country::model()->findByPk($stateData->country_id);
				if($countryData){
					$model=$this->loadModel($id);
					if(isset($_POST['City']))
					{
						$model->attributes=$_POST['City'];
						$model->updated_at = date('Y-m-d H:i:s');
						if($model->validate() && $model->save())
							Yii::app()->user->setFlash('success',"City '".$_POST['City']['name']."' updated successfully");
					        Common::activityLog($model->id, 'City', 'City '.$_POST['City']['City_name'].' updated', date('Y-m-d H:i:s'));
					        $this->redirect(Yii::app()->baseURL.'/city/index?state_id='.$_POST['City']['state_id']);
					}
					$this->render('update',array(
						'model'=>$model,
						'state'=>$stateData,
						'country'=>$countryData
					));
				}else{
					throw new CHttpException(404,'Requested item not found');
				}
			}else{
				throw new CHttpException(404,'Requested item not found');
			}
		}else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function loadModel($id)
	{
		$model=City::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param City $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionChangeStatus(){
	    if(isset($_POST['state'])){
	        $state = $_POST['state'];
	        $status = ($state=='true')?'Y':'N';
	        $country = City::model()->findByPk($_POST['id']);
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
