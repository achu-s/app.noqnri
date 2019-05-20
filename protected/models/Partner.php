<?php

/**
 * This is the model class for table "nq_partner".
 *
 * The followings are the available columns in table 'nq_partner':
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $contact_person
 * @property string $email_id
 * @property string $geo_location
 * @property string $mode_of_business
 * @property string $working_hours
 * @property string $established_date
 * @property string $address
 * @property string $phone_number
 * @property string $google_plus_url
 * @property string $faccebook_url
 * @property string $twitter_url
 * @property string $status
 * @property string $logo
 * @property string $currency
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $state_id
 * @property integer $city_id
 * @property string $landmark
 * @property integer $pin_code
 */
class Partner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_partner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, name, contact_person, geo_location, mode_of_business, description, working_hours, established_date, address, phone_number, currency, created_at, created_by, country_id, state_id, city_id, pin_code', 'required'),
			array('category_id, created_by, updated_by, state_id, city_id, pin_code', 'numerical', 'integerOnly'=>true),
			array('name, contact_person, email_id, mode_of_business, working_hours, currency', 'length', 'max'=>50),
			array('geo_location, google_plus_url, faccebook_url, twitter_url, logo', 'length', 'max'=>150),
			array('established_date', 'length', 'max'=>100),
			array('phone_number', 'length', 'max'=>20),
			array('status', 'length', 'max'=>1),
			array('landmark', 'length', 'max'=>250),
			array('description, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, name, description, contact_person, email_id, geo_location, mode_of_business, working_hours, established_date, address, phone_number, google_plus_url, faccebook_url, twitter_url, status, logo, currency, created_at, created_by, updated_at, updated_by, state_id, city_id, landmark, pin_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'CategoryData'=>array(self::BELONGS_TO,'Category',array('category_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'name' => 'Name',
			'description' => 'Description',
			'contact_person' => 'Contact Person',
			'email_id' => 'Email',
			'geo_location' => 'Geo Location',
			'mode_of_business' => 'Mode Of Business',
			'working_hours' => 'Working Hours',
			'established_date' => 'Established Date',
			'address' => 'Address',
			'phone_number' => 'Phone Number',
			'google_plus_url' => 'Google Plus Url',
			'faccebook_url' => 'Faccebook Url',
			'twitter_url' => 'Twitter Url',
			'status' => 'Status',
			'logo' => 'Logo',
			'currency' => 'Currency',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'state_id' => 'State',
			'city_id' => 'City',
			'landmark' => 'landmark',
			'pin_code' => 'Pin Code',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('geo_location',$this->geo_location,true);
		$criteria->compare('mode_of_business',$this->mode_of_business,true);
		$criteria->compare('working_hours',$this->working_hours,true);
		$criteria->compare('established_date',$this->established_date,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('google_plus_url',$this->google_plus_url,true);
		$criteria->compare('faccebook_url',$this->faccebook_url,true);
		$criteria->compare('twitter_url',$this->twitter_url,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('landmark',$this->landmark,true);
		$criteria->compare('pin_code',$this->pin_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Partner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function Status($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='switch' ".$status." ref='$data->id' res='Partner'>";
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function Email_address($data){
	    if(isset($data->email_id) && $data->email_id != "" )
	        $html = strlen($data->email_id) > 12
	        ? CHtml::tag("span", array("title"=>$data->email_id,"style"=>"color:#555555"), CHtml::encode(substr($data->email_id, 0, 12)) . "...")
	        : CHtml::encode($data->email_id)
	        ;
	        else
	            $html =  "";
	            return $html;
	}
	
	public function PartnerName($data){
	    echo "<a href=".Yii::app()->request->baseUrl.'/sales/index?parent_id='.$data->id.">".$data->name."</a>";
	}
	public function getCategories($categoryId){
	    $parents = Category::model()->findAllByAttributes(array('parent_category'=>0));
	    $categories = array("<option value=''>Select a Category</option>");
	    foreach($parents as $parent) {
	        $selected = ($categoryId==$parent->id)?"selected":'';
	        $children = Category::model()->findAllByAttributes(array('parent_category'=>$parent->id));
	        $categoriesChildren = array();
	        $categoriesChildren[$parent->id]='<option value="'.$parent->id.'" '.$selected.'>'.$parent->category.'</option>';
	        foreach($children as $child) {
	            $selected = ($categoryId==$child->id)?"selected":'';
	            $category=$parent->category.' > '.$child->category;
	            $categoriesChildren[$child->id] = '<option value="'.$child->id.'" '.$selected.'>'.$parent->category.' > '.$child->category.'</option>';
	            $categoriesChildren[] .= Partner::getCategoryTree($child->id,$category,$categoryId).'</option>';
	        }
	        $categories=array_merge($categories,$categoriesChildren);
	    }
	    $html='<select  name="Partner[category_id]" class="form-control select2 special" data-validation="required" data-placeholder="Select Category">';
	    foreach ($categories as $model)
	    {
	        $html .=$model;
	    }
	    $html .='</select>';
	    return $html;
	}
	
	public function getCategoryTree($id,$category,$categoryId)
	{
	    $html='';
	    foreach(Category::model()->findAllByAttributes(array('parent_category'=>$id)) as $child)
	    {
	        $selected = ($categoryId==$child->id)?"selected":'';
	        $category1=$category.' > '.$child->category;
	        $html .= '<option value="'.$child->id.'" '.$selected.'>'.$category.' > '.$child->category.'</option>';
	        
	        $html .= Partner::getCategoryTree($child->id,$category1,$categoryId).'</option>';
	    }
	    return $html;
	}
	
	public function CategoryName($data){
	    echo ($data->CategoryData)?$data->CategoryData->category:'';
	}
}
