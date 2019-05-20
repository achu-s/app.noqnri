<?php

/**
 * This is the model class for table "nq_news_testimonial".
 *
 * The followings are the available columns in table 'nq_news_testimonial':
 * @property integer $id
 * @property string $is_testimonial
 * @property string $user_type
 * @property integer $user_id
 * @property string $description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class NewsTestimonial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_news_testimonial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, description, created_at', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('is_testimonial, user_type, status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, is_testimonial, user_type, user_id, description, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'is_testimonial' => 'Is Testimonial',
			'user_type' => 'User Type',
			'user_id' => 'User',
			'description' => 'Description',
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
		$criteria->compare('is_testimonial',$this->is_testimonial,true);
		$criteria->compare('user_type',$this->user_type,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('description',$this->description,true);
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
	 * @return NewsTestimonial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function UserType($data){
		if($data->user_type){
			echo ($data->user_type==0)?"Customer":"Partner";
		}else{
			echo "";
		}
	}
	public function User(){
		if($data->user_id){
			$table = ($data->user_type==0)?"Customer":"Partner";
			$info = $table::model()->findByPk($data->user_id);
			if($data->user_type==0){
				echo $info->first_name;
			}else{
				echo $info->name;
			}
		}
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
	    echo "<input type='checkbox' class='switch' ".$status." ref='$data->id' res='NewsTestimonial'>";
	}
}
