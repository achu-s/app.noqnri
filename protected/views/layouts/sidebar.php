<aside class="main-sidebar">
<section class="sidebar">
  <div class="user-panel">
    <div class="pull-left image">
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
    </div>
    <div class="pull-left info">
      <p><?php echo Yii::app()->user->fullname;?><br/>(<?php echo (Yii::app()->user->userType=="Forkind")?"Forkind":Yii::app()->user->userType;?>)</p>
    </div>
  </div>
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li><a href="<?php echo Yii::app()->baseUrl . '/dashboard' ?>"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
    <?php if(Yii::app()->user->userType=="Admin"){?>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/sales/update/'.Yii::app()->user->getId(); ?>"><i class="fa fa-user-secret"></i> <span>Update Profile</span></a></li>
      <li><a href="<?php echo Yii::app()->baseUrl.'/dashboard/home_banner'; ?>"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Home Banner</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/category'; ?>"><i class="fa fa-list" aria-hidden="true"></i> <span>Category</span></a></li>
      <li><a href="<?php echo Yii::app()->baseUrl.'/country/'; ?>"><i class="fa fa-globe" aria-hidden="true"></i> <span>Country</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/partner/admin'; ?>"><i class="fa fa-users" aria-hidden="true"></i> <span>Partner</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/customer'; ?>"><i class="fa fa-user" aria-hidden="true"></i> <span>Customer</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/card'; ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Card</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/enquiry'; ?>"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Enquiry</span></a></li>
      <li><a href="<?php echo Yii::app()->baseUrl.'/privillageUpdates'; ?>"><i class="fa fa-cc" aria-hidden="true"></i> <span>Privillage Updates</span></a></li>
      <li><a href="<?php echo Yii::app()->baseUrl.'/newsTestimonial'; ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>News & Events</span></a></li>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Testimonials</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo Yii::app()->baseUrl.'/newsTestimonial/customer'; ?>"><i class="fa fa-user"></i> Client</a></li>
            <li><a href="<?php echo Yii::app()->baseUrl.'/newsTestimonial/partner'; ?>"><i class="fa fa-users"></i> Partner</a></li>
          </ul>
      </li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/performance_report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Performance Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/redeem_report'; ?>"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span>Redemption Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
      <?php }elseif(Yii::app()->user->userType=="Partner"){?>
    	<!-- <li><a href="<?php echo Yii::app()->baseUrl.'/sales/update/'.Yii::app()->user->getId(); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Update Profile</span></a></li> -->
    	<li><a href="<?php echo Yii::app()->baseUrl.'/sales/index/'.Yii::app()->user->partner; ?>"><i class="fa fa-user" aria-hidden="true"></i> <span>Users Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/transaction/'; ?>"><i class="fa fa-area-chart" aria-hidden="true"></i> <span>Transaction</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/performance_report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Performance Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/redeem_report'; ?>"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span>Redemption Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
    <?php }?>
  </ul>
</section>
</aside>