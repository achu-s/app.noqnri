<?php

class NewsTestimonialController extends Controller
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
				'actions'=>array('create','update','TestimonialUpdate','ChangeStatus'),
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

	public function actionCreate()
	{
		if(Yii::app()->user->userType=="Admin"){
			$model=new NewsTestimonial;
			$this->page_title   = 'Create News';
			if(isset($_POST['NewsTestimonial']))
			{
				$model->attributes=$_POST['NewsTestimonial'];
				$model->is_testimonial = 0;
				$model->user_id = 0;
				$model->created_at = date('Y-m-d H:i:s');
				if($model->validate() && $model->save()){
	                Yii::app()->user->setFlash('success','News & updated added');
	                $this->redirect(Yii::app()->baseURL.'/NewsTestimonial');
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
			$this->page_title   = 'Update News';
			if(isset($_POST['NewsTestimonial']))
			{
				$model->attributes=$_POST['NewsTestimonial'];
				$model->updated_at = date('Y-m-d H:i:s');
				if($model->validate() && $model->save()){
					Yii::app()->user->setFlash('success','News & updated updated');
	                $this->redirect(Yii::app()->baseURL.'/NewsTestimonial');
				}
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}else{
			throw new CHttpException(401,'You are not authorised to perform this action');
		}
	}

	public function actionTestimonialUpdate($id)
	{
		if(Yii::app()->user->userType=="Admin"){
			$this->page_title   = 'Update Testimonials';
			$model=$this->loadModel($id);
			if(isset($_POST['NewsTestimonial']))
			{
				$model->attributes=$_POST['NewsTestimonial'];
				$model->updated_at = date('Y-m-d H:i:s');
				if($model->validate() && $model->save()){
					Yii::app()->user->setFlash('success','News & updated updated');
	                $this->redirect(Yii::app()->baseURL.'/NewsTestimonial');
				}
			}
			$this->render('testimonial_update',array(
				'model'=>$model,
			));
		}else{
			throw new CHttpException(401,'You are not authorised to perform this action');
		}
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->userType=="Admin"){
	        $model=new NewsTestimonial('search');
	        $this->page_title   = 'News';
	        $model->unsetAttributes();
	        if(isset($_GET['NewsTestimonial']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes=$_GET['NewsTestimonial'];
	            $this->render('admin', array(
	                'model' => $model
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}


	public function actionCustomer()
	{
		if(Yii::app()->user->userType=="Admin"){
	        $model=new NewsTestimonial('search');
	        $this->page_title   = 'Customer Testimonials ';
	        $model->unsetAttributes();
	        $model->is_testimonial = 1;
	        $model->user_type = 0;
	        if(isset($_GET['NewsTestimonial']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes=$_GET['NewsTestimonial'];
	            $model->user_type = 0;
	            $this->render('testimonial_admin', array(
	                'model' => $model
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	public function actionPartner()
	{
		if(Yii::app()->user->userType=="Admin"){
	        $model=new NewsTestimonial('search');
	        $this->page_title   = 'Partner Testimonials ';
	        $model->unsetAttributes();
	        $model->is_testimonial = 1;
	        $model->user_type = 1;
	        if(isset($_GET['NewsTestimonial']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes=$_GET['NewsTestimonial'];
	            $model->user_type = 1;
	            $this->render('testimonial_admin', array(
	                'model' => $model
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NewsTestimonial the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NewsTestimonial::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function actionChangeStatus(){
	    if(isset($_POST['state'])){
	        $state = $_POST['state'];
	        $status = ($state=='true')?'Y':'N';
	        $privillage = NewsTestimonial::model()->findByPk($_POST['id']);
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
	 * Performs the AJAX validation.
	 * @param NewsTestimonial $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-testimonial-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
