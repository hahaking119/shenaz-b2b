<?php

/**
 * This is the model class for table "custom_category".
 *
 * The followings are the available columns in table 'custom_category':
 * @property integer $id
 * @property integer $company_id
 * @property string $title
 * @property string $slug
 * @property integer $parent_id
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property CompanyInformation $company
 * @property Product[] $products
 */
class CustomCategory extends CActiveRecord {

    public $subcategory_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CustomCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'custom_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, title, slug, parent_id, status', 'required'),
            array('company_id, parent_id, status, trash', 'numerical', 'integerOnly' => true),
            array('title, slug', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, company_id, title, slug, parent_id, status, trash, created_at, modified_at, trashed_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'company' => array(self::BELONGS_TO, 'CompanyInformation', 'company_id'),
            'products' => array(self::HAS_MANY, 'Product', 'custom_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'company_id' => 'Company',
            'title' => 'Title',
            'slug' => 'Slug',
            'parent_id' => 'Parent',
            'subcategory_id' => 'Sub Category',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('trash', $this->trash);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('trashed_at', $this->trashed_at, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getName($id) {
        $model = CustomCategory::model()->findByPk($id);
        $name = $model->title;
        return $name;
    }

}