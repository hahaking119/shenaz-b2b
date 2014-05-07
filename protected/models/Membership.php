<?php

/**
 * This is the model class for table "membership".
 *
 * The followings are the available columns in table 'membership':
 * @property integer $membership_id
 * @property string $title
 * @property string $description
 * @property integer $shopfront_limit
 * @property integer $product_limit
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property Member[] $members
 */
class Membership extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Membership the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'membership';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description, status', 'required'),
            array('shopfront_limit, product_limit, status, trash', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('membership_id, title, description, shopfront_limit, product_limit, status, trash, created_at, modified_at, trashed_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'members' => array(self::HAS_MANY, 'Member', 'membership_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'membership_id' => 'Membership',
            'title' => 'Title',
            'description' => 'Description',
            'shopfront_limit' => 'Shopfront Limit',
            'product_limit' => 'Product Limit',
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
    public function search($params = array()) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria($params);

        $criteria->compare('membership_id', $this->membership_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('shopfront_limit', $this->shopfront_limit);
        $criteria->compare('product_limit', $this->product_limit);
        $criteria->compare('status', $this->status);
        $criteria->compare('trash', $this->trash);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('trashed_at', $this->trashed_at, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'defaultOrder' => 't.membership_id DESC',
                    ),
                ));
    }

}