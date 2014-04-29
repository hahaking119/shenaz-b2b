<?php

/**
 * This is the model class for table "newsletter".
 *
 * The followings are the available columns in table 'newsletter':
 * @property integer $newsletter_id
 * @property integer $business_type
 * @property string $title
 * @property string $description
 * @property string $attachment
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 */
class Newsletter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Newsletter the static model class
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
		return 'newsletter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_type, title, description, attachment, status, trash, created_at, modified_at, trashed_at', 'required'),
			array('business_type, status, trash', 'numerical', 'integerOnly'=>true),
			array('title, attachment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('newsletter_id, business_type, title, description, attachment, status, trash, created_at, modified_at, trashed_at', 'safe', 'on'=>'search'),
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
			'newsletter_id' => 'Newsletter',
			'business_type' => 'Business Type',
			'title' => 'Title',
			'description' => 'Description',
			'attachment' => 'Attachment',
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

		$criteria->compare('newsletter_id',$this->newsletter_id);
		$criteria->compare('business_type',$this->business_type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('attachment',$this->attachment,true);
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