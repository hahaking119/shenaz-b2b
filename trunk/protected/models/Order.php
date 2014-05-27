<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $order_id
 * @property integer shipping_method
 * @property integer $payment_method
 * @property double $total
 * @property string $comments
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property BillingInformation[] $billingInformations
 * @property ShippingInformation[] $shippingInformations
 */
class Order extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shipping_method, payment_method, total', 'required'),
            array('shipping_method, payment_method, status, trash', 'numerical', 'integerOnly' => true),
            array('total', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('order_id, shipping_method, payment_method, total, comments, status, trash, created_at, modified_at, trashed_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'billingInformations' => array(self::HAS_MANY, 'BillingInformation', 'order_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'shippingInformations' => array(self::HAS_MANY, 'ShippingInformation', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'order_id' => 'Order',
            'shipping_method' => 'Shipping Method',
            'payment_method' => 'Payment Method',
            'total' => 'Total',
            'comments' => 'Comments',
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
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('shipping_method', $this->billing_method);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('total', $this->total);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('trash', $this->trash);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('trashed_at', $this->trashed_at, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}