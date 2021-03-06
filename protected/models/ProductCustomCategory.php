<?php

/**
 * This is the model class for table "product_custom_category".
 *
 * The followings are the available columns in table 'product_custom_category':
 * @property integer $id
 * @property integer $product_id
 * @property integer $custom_category_id
 *
 * The followings are the available model relations:
 * @property CustomCategory $customCategory
 * @property Product $product
 */
class ProductCustomCategory extends CActiveRecord {

    public $customsubcategory_id;
    public $level1;
    public $level2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductCustomCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_custom_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id', 'numerical', 'integerOnly' => true),
//            array('custom_category_id', 'type', 'type' => 'array', 'allowEmpty' => false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, product_id, custom_category_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customCategory' => array(self::BELONGS_TO, 'CustomCategory', 'custom_category_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'custom_category_id' => 'Custom Category',
            'level1' => 'Level 1',
            'level2' => 'Level 2'
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

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('custom_category_id', $this->custom_category_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}