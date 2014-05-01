<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property integer $parent_id
 * @property string $image
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property CategoryBanner[] $categoryBanners
 * @property Product[] $products
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, parent_id, image, status', 'required'),
			array('parent_id, status, trash', 'numerical', 'integerOnly'=>true),
			array('title, slug, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, title, slug, parent_id, image, status, trash, created_at, modified_at, trashed_at', 'safe', 'on'=>'search'),
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
			'categoryBanners' => array(self::HAS_MANY, 'CategoryBanner', 'category_id'),
			'products' => array(self::HAS_MANY, 'Product', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'Category',
			'title' => 'Title',
			'slug' => 'Slug',
			'parent_id' => 'Parent',
			'image' => 'Image',
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

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('image',$this->image,true);
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