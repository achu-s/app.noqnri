<?php

/**
 * This is the model class for table "nq_privillage_updates".
 *
 * The followings are the available columns in table 'nq_privillage_updates':
 * @property integer $id
 * @property integer $partner_id
 * @property string $description
 * @property string $image
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class PrivillageUpdates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_privillage_updates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_id, description, created_at', 'required'),
			array('partner_id', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>250),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, partner_id, description, image, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'PartnerData'=>array(self::BELONGS_TO,'Partner',array('partner_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'partner_id' => 'Partner',
			'description' => 'Description',
			'image' => 'Image',
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
		$criteria->compare('partner_id',$this->partner_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
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
	 * @return PrivillageUpdates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function Description($data){
	    if(isset($data->description) && $data->description != "" )
	        $html = strlen($data->description) > 20
	        ? CHtml::tag("span", array("title"=>$data->description,"style"=>"color:#555555"), CHtml::encode(substr($data->description, 0, 20)) . "...")
	        : CHtml::encode($data->description)
	        ;
	        else
	            $html =  "";
	            return $html;
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function Status($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='switch' ".$status." ref='$data->id' res='PrivillageUpdates'>";
	}
	public function PartnerName($data){
	    echo "<a href=".Yii::app()->request->baseUrl.'/partner/partnerView/'.$data->partner_id.">".$data->PartnerData->name."</a>";
	}
}
