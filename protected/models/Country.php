<?php

/**
 * This is the model class for table "nq_country".
 *
 * The followings are the available columns in table 'nq_country':
 * @property integer $id
 * @property string $country_code
 * @property string $country_name
 * @property string $country_phone_code
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_code, country_name, country_phone_code, created_at', 'required'),
			array('country_code, country_name, country_phone_code', 'unique'),
			array('country_code', 'length', 'max'=>3),
			array('country_name', 'length', 'max'=>150),
			array('country_phone_code', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_code, country_name, country_phone_code, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_code' => 'Country Code',
			'country_name' => 'Country Name',
			'country_phone_code' => 'Country Phone Code',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('country_phone_code',$this->country_phone_code,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function Status($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='switch' ".$status." ref='$data->id' res='Country'>";
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function CountryName($data){
		$stateDetails = State::model()->findByAttributes(array('country_id'=>$data->id));
		if($stateDetails){
			echo "<a href=".Yii::app()->request->baseUrl.'/state/index/country_id/'.$data->id.">".$data->country_name."</a>";
		}else{
			echo $data->country_name;
		}
	}
}
