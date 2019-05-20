<?php

/**
 * This is the model class for table "nq_state".
 *
 * The followings are the available columns in table 'nq_state':
 * @property integer $id
 * @property string $state_name
 * @property integer $country_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class State extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $country_name;
	public function tableName()
	{
		return 'nq_state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state_name, created_at', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('state_name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, state_name, country_id, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'CountryData'=>array(self::BELONGS_TO,'Country',array('country_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'state_name' => 'State Name',
			'country_id' => 'Country',
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
		$criteria->compare('state_name',$this->state_name,true);
		$criteria->compare('country_id',$this->country_id);
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
	 * @return State the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function Status($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='switch' ".$status." ref='$data->id' res='State'>";
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function StateName($data){
		$cityDetails = City::model()->findByAttributes(array('state_id'=>$data->id));
		if($cityDetails){
			echo "<a href=".Yii::app()->request->baseUrl.'/city/index?state_id='.$data->id.">".$data->state_name."</a>";
		}else{
			echo $data->state_name;
		}
	}
}
