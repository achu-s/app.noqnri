<?php

class DashboardController extends Controller {

    public $layout = '//layouts/column2';
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function init()
    {
        if((Yii::app()->user->getId()==null) && (!isset(Yii::app()->user->userType)))
        {
            $this->redirect(Yii::app()->baseURL."/site/");
        }
    }
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','loadmap','loadloginstatus','Home_banner','Delete_item'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
            $this->page_title = Yii::app()->user->userType. '- Dashboard';
            $this->activeLink = 'dashboard';
            if(Yii::app()->user->userType=="Admin"){
            	$partnerCount = Partner::model()->countByAttributes(array('status'=>'Y'));
            	$SalesCount = ForkindUser::model()->countByAttributes(array('status'=>'Y'));
            	$CustomerCount = Customer::model()->countByAttributes(array('status'=>'Y'));
            	$CategoryCount = Category::model()->countByAttributes(array('status'=>'Y'));
            	$this->render('index');
            }else if(Yii::app()->user->userType=="Partner" || Yii::app()->user->userType=="Sales"){
            	$this->render('partner_index');
            }else{
            	$this->render('customer_index');
            }
    }
    public function actionHome_banner(){
        $this->page_title = Yii::app()->name. '- Home Banner';
        $this->activeLink = 'Home Banner';
        if(Yii::app()->user->userType=="Admin"){
            $model = new HomeBanner();
            $banners = HomeBanner::model()->findAllByAttributes(array('status'=>'Y'));
            $bannerDetails = CUploadedFile::getInstances($model, 'banner');
            if(!empty($bannerDetails)){
                $banner_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/home_banner/';
                if (!file_exists($banner_path)){
                    mkdir($banner_path, 0777, true);
                }
                $successPhoto = array();
                $failedPhoto = array();
                $path=0;
                foreach ($bannerDetails as $i=>$photo){
                    $photoModel = new HomeBanner();
                    $banner_name = str_replace(' ', '_', $photo->name);
                    $imagevariables = getimagesize($photo->tempName);
                    $width = $imagevariables[0];
                    $height = $imagevariables[1];
                    if($width>=2000 && $height>=700){
                        $ext = pathinfo($banner_name, PATHINFO_EXTENSION);
                        $banner_name = $i."_"."photo"."_".date('ymdhis').".".$ext;
                        $photoModel->banner = $banner_name;
                        $photoModel->created_at = date('Y-m-d H:i:s');
                        if($photoModel->validate()&&$photoModel->save()){
                            $path = '/uploads/home_banner/';
                            $photo->saveAs(Yii::app()->basePath .DIRECTORY_SEPARATOR.'..'.$path.$banner_name);
                            array_push($successPhoto,'1');
                        }else{
                            array_push($failedPhoto,'1');
                        }
                    }else{
                        array_push($failedPhoto,'1');
                    }
                }
                if(count($bannerDetails)==count($successPhoto)){
                    Yii::app()->user->setFlash('success','Home banner added successfully');
                    $this->redirect(Yii::app()->baseURL.'/dashboard/home_banner');
                }else{
                    $remaining = count($bannerDetails) - count($successPhoto);
                    Yii::app()->user->setFlash('error',''.$remaining.' Home banner(s) not uploaded');
                    $this->redirect(Yii::app()->baseURL.'/dashboard/home_banner');
                }
            }
            $uploaded_image_array = '';
            $uploaded_image_array_config = '';
            $bannerPath = Yii::app()->request->baseUrl.'/uploads/home_banner/';
            if(count($banners)>0){
                foreach($banners as $banner){
                    $uploaded_image_array .= "'".$bannerPath.$banner->banner."'".',';
                    $uploaded_image_array_config .= "{caption:'".$banner->banner."',width:'120px',key:".$banner->id.'},';
                }
            }
            $uploaded_image_array = rtrim($uploaded_image_array,',');
            $uploaded_image_array_config = rtrim($uploaded_image_array_config,',');
            $this->render('home_banner',array('model'=>$model,'banners'=>$banners,'uploaded_image_array'=>$uploaded_image_array,'uploaded_image_array_config'=>$uploaded_image_array_config));
        }else{
            throw new CHttpException(401,'You are not authorised to perform this action');
        }
    }
    public function actionDelete_item(){
        $id = $_POST['id'];
        $home_banner = HomeBanner::model()->findByPk($id);
        if($home_banner){
            if($home_banner->delete()){
                $banner_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/home_banner/';
                unlink($banner_path.$home_banner->banner);
                echo json_encode(array('status'=>'true'));
            }else{
                echo json_encode(array('status'=>'false'));
            }
        }
    }
}
