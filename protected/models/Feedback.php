<?php

/**
 * This is the model class for table "feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property integer $id
 * @property integer $product_id
 * @property integer $company_id
 * @property integer $member_id
 * @property string $feedback
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Product $product
 * @property CompanyInformation $company
 */
class Feedback extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, company_id, feedback', 'required'),
			array('product_id, company_id, member_id, status, trash', 'numerical', 'integerOnly'=>true),
			array('feedback', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, company_id, member_id, feedback, status, trash, created_at, modified_at, trashed_at', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'company' => array(self::BELONGS_TO, 'CompanyInformation', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'company_id' => 'Company',
			'member_id' => 'Member',
			'feedback' => 'Feedback',
			'status' => 'Status',
			'trash' => 'Trash',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'trashed_at' => 'Trashed At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('feedback',$this->feedback,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('trash',$this->trash);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('trashed_at',$this->trashed_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}