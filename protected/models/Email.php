<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property integer $email_id
 * @property string $from
 * @property integer $to
 * @property string $subject
 * @property string $message
 * @property string $attachment
 * @property integer $status
 * @property integer $trash
 * @property string $sent
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 * @property string $sent_at
 *
 * The followings are the available model relations:
 * @property Member $to0
 */
class Email extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Email the static model class
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
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, subject, message, attachment, status, trash, sent, created_at, modified_at, trashed_at, sent_at', 'required'),
			array('to, status, trash', 'numerical', 'integerOnly'=>true),
			array('from, subject, attachment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email_id, from, to, subject, message, attachment, status, trash, sent, created_at, modified_at, trashed_at, sent_at', 'safe', 'on'=>'search'),
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
			'to0' => array(self::BELONGS_TO, 'Member', 'to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email_id' => 'Email',
			'from' => 'From',
			'to' => 'To',
			'subject' => 'Subject',
			'message' => 'Message',
			'attachment' => 'Attachment',
			'status' => 'Status',
			'trash' => 'Trash',
			'sent' => 'Sent',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'trashed_at' => 'Trashed At',
			'sent_at' => 'Sent At',
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

		$criteria->compare('email_id',$this->email_id);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('attachment',$this->attachment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('trash',$this->trash);
		$criteria->compare('sent',$this->sent,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('trashed_at',$this->trashed_at,true);
		$criteria->compare('sent_at',$this->sent_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}