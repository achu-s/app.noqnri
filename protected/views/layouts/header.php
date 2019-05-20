<header class="main-header">
    <a href="<?php echo Yii::app()->baseUrl."/dashboard"?>" class="logo">
      <span class="logo-lg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/site_logo.png" alt="logo" style="width: 100px;"></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php 
                if(Yii::app()->user->userType!='Customer'){
                      $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'1'));
                      if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.Yii::app()->user->partner.'/profile_image/'.$userDetails->image?>" class="user-image" alt="User Image">
                      <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/user2-160x160.jpg" class="user-image" alt="User Image">
                      <?php }
                }else{
                    $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'0'));
                    if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_image/'.$userDetails->image?>" class="user-image" alt="User Image">
                    <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/user2-160x160.jpg" class="user-image" alt="User Image">
                    <?php }?>
                <?php }?>
              <span class="hidden-xs"><?php echo Yii::app()->user->fullname."(".Yii::app()->user->username.")";?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <?php 
                if(Yii::app()->user->userType!='Customer'){
                      $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'1'));
                      if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.Yii::app()->user->partner.'/profile_image/'.$userDetails->image?>" class="img-circle" alt="User Image">
                      <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                      <?php }
                }else{
                    $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'0'));
                    if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_image/'.$userDetails->image?>" class="img-circle" alt="User Image">
                    <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <?php }?>
                <?php }?>
                <p>
                  <?php echo Yii::app()->user->userType;?>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                </div>
                <div class="pull-right">
                  <a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>