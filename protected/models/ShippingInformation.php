<?php

/**
 * This is the model class for table "shipping_information".
 *
 * The followings are the available columns in table 'shipping_information':
 * @property integer $shipping_id
 * @property integer $order_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $company
 * @property string $phone
 * @property string $area_code
 * @property string $area
 * @property string $province
 * @property string $country
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class ShippingInformation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShippingInformation the static model class
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
		return 'shipping_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, first_name, last_name, email, company, phone, area_code, area, province, country', 'required'),
			array('order_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, company, phone, area_code, area, province, country', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shipping_id, order_id, first_name, last_name, email, company, phone, area_code, area, province, country', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shipping_id' => 'Shipping',
			'order_id' => 'Order',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'company' => 'Company',
			'phone' => 'Phone',
			'area_code' => 'Area Code',
			'area' => 'Area',
			'province' => 'Province',
			'country' => 'Country',
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

		$criteria->compare('shipping_id',$this->shipping_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('area_code',$this->area_code,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('country',$this->country,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}