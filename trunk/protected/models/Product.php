<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property integer $company_id
 * @property string $name
 * @property string $slug
 * @property string $sku
 * @property integer $category_id
 * @property integer $custom_category_id
 * @property string $description
 * @property double $price
 * @property string $price_type
 * @property integer $minimum_quantitiy
 * @property integer $stock
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property CustomCategory $customCategory
 * @property CompanyInformation $company
 * @property Category $category
 * @property ProductImage[] $productImages
 * @property Rating[] $ratings
 */
class Product extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, name, sku,description, price, minimum_quantitiy, stock, status', 'required'),
            array('company_id, category_type, category_id, custom_category_id, minimum_quantitiy, stock, status, trash', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('name, slug, sku, price_type', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('product_id, company_id, name, slug, sku, category_id, custom_category_id, description, price, price_type, minimum_quantitiy, stock, status, trash, created_at, modified_at, trashed_at', 'safe', 'on' => 'search'),
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
            'company' => array(self::BELONGS_TO, 'CompanyInformation', 'company_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'productImages' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
            'ratings' => array(self::HAS_MANY, 'Rating', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'product_id' => 'Product',
            'company_id' => 'Company',
            'name' => 'Name',
            'slug' => 'Slug',
            'sku' => 'Sku',
            'category_type' => 'Select Category',
            'category_id' => 'Category',
            'custom_category_id' => 'Custom Category',
            'description' => 'Description',
            'price' => 'Price',
            'price_type' => 'Price Type',
            'minimum_quantitiy' => 'Minimum Quantitiy',
            'stock' => 'Stock',
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

        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('category_type', $this->category_type);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('custom_category_id', $this->custom_category_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('price_type', $this->price_type, true);
        $criteria->compare('minimum_quantitiy', $this->minimum_quantitiy);
        $criteria->compare('stock', $this->stock);
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