<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property integer $order_item_id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class OrderItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
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
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, quantity', 'required'),
			array('order_id, product_id, quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_item_id, order_id, product_id, quantity', 'safe', 'on'=>'search'),
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
			'order_item_id' => 'Order Item',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
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

		$criteria->compare('order_item_id',$this->order_item_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}