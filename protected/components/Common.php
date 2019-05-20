<?php

class Common {
    public static function getTimezone($time = "", $format = "") {
        // timezone by php friendly values
        $date = new DateTime($time, new DateTimeZone('UTC'));
        if(isset($_COOKIE['Timezone'])){
            $date->setTimezone(new DateTimeZone($_COOKIE['Timezone']));
        }else{
            $date->setTimezone(new DateTimeZone('IST'));
        }
        $time= $date->format($format);
        return $time;
        //set the timezone here
        
    }
    public static function activityLog($user_id,$type,$message,$created_on){
        $Activity = new ActivityLog();
        $Activity->login_id=$user_id;
        $Activity->type=$type;
        $Activity->message=$message;
        $Activity->created_on=$created_on;
        $Activity->save();
    }
        
    public static function modelCount($model,$condition_key,$condition_value,$type){
        return $model::model()->countByAttributes(array($condition_key=>$condition_value));
    }
    public static function modelTotalCount($model,$condition_key,$condition_value,$rderBy,$orderByValue,$limit,$type){
        $reviewCount = $model::model()->findAllByAttributes(array($condition_key=>$condition_value),array('order' => $rderBy.' '.$orderByValue,'limit'=>$limit,'offset'=>0));
        return count($reviewCount);
    }
    public static function modelPercentage($model,$condition_key,$condition_value,$type){
        $reviewCount = $model::model()->countByAttributes(array($condition_key=>$condition_value));
        $countAll = $model::model()->findAll();
        if (count($countAll)>0){
            $result = ($reviewCount/count($countAll))*100;
            return number_format((float)$result, 2, '.', '');
        }else{
            return 0;
        }
        
    }
    public static function modelAll($model,$condition_key,$condition_value,$rderBy,$orderByValue,$limit,$type){
        return $model::model()->findAllByAttributes(array($condition_key=>$condition_value),array('order' => $rderBy.' '.$orderByValue,'limit'=>$limit,'offset'=>0));
    }
    public static function Total($model,$condition,$type){
      if($type!="0"){
          $modelResult = $model::model()->findAllByAttributes(array('partner_id'=>$type));
      }else{
        $modelResult = $model::model()->findAll();
      }
      if(count($modelResult)>0){
          $totalSum = array();
          foreach($modelResult as $modelR){
              array_push($totalSum,$modelR->$condition);
          }
          return empty(array_sum($totalSum))?"0":array_sum($totalSum);
      }else{
          echo 0;
      }
    }
    public static function TotalPercentage($model,$condition,$type){
        $modelResult = $model::model()->findAll();
        if(count($modelResult)>0){
            $totalSum = array();
            foreach($modelResult as $modelR){
                array_push($totalSum,$modelR->$condition);
            }
            $lastResult =  empty(array_sum($totalSum))?"0":array_sum($totalSum);
            return ($lastResult/count($modelResult))*100;
        }else{
            echo 0;
        }
    }

    public static function SendSMS($mobile,$messagecontent){
        $mobile = $mobile; //enter Mobile numbers comma seperated
        $username = 'noqnri'; //your username
        $password = "noqnri@popartmed"; //your password
        $sender = "NOQNRI"; //Your senderid
        $username = urlencode($username);
        $password = urlencode($password);
        $sender = urlencode($sender);
        $message = urlencode($messagecontent);
        $url="http://alertin.co.in/sendsms?uname=$username&pwd=$password&senderid=$sender&to=$mobile&msg=$message&route=T";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);
        if(!empty($data)){
            return true;
        }else{
            return false;
        }
    }
}

?>
