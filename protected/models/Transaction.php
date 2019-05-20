<?php

/**
 * This is the model class for table "nq_transaction".
 *
 * The followings are the available columns in table 'nq_transaction':
 * @property integer $id
 * @property integer $card_id
 * @property integer $partner_id
 * @property string $trans_currency
 * @property double $trans_amount
 * @property string $trans_date
 * @property string $trans_note
 * @property integer $trans_ref_no
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Transaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at, created_by, updated_at', 'required'),
			array('card_id, partner_id, trans_ref_no, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('trans_amount', 'numerical'),
			array('trans_currency', 'length', 'max'=>150),
			array('trans_date, trans_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, card_id, partner_id, trans_currency, trans_amount, trans_date, trans_note, trans_ref_no, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
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
			'CardData'=>array(self::BELONGS_TO,'Card',array('card_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'card_id' => 'Card',
			'partner_id' => 'Partner',
			'trans_currency' => 'Trans Currency',
			'trans_amount' => 'Trans Amount',
			'trans_date' => 'Trans Date',
			'trans_note' => 'Trans Note',
			'trans_ref_no' => 'Trans Ref No',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
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
		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('partner_id',$this->partner_id);
		$criteria->compare('trans_currency',$this->trans_currency,true);
		$criteria->compare('trans_amount',$this->trans_amount);
		$criteria->compare('trans_date',$this->trans_date,true);
		$criteria->compare('trans_note',$this->trans_note,true);
		$criteria->compare('trans_ref_no',$this->trans_ref_no);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function CardNumber($data){
	    if($data->card_id){
	        echo ($data->CardData)?$data->CardData->card_number:'';
	    }
	}
}
