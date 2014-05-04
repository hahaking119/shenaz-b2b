<?php

/**
 * This is the model class for table "company_information".
 *
 * The followings are the available columns in table 'company_information':
 * @property integer $company_id
 * @property integer $member_id
 * @property string $company_name
 * @property string $slug
 * @property string $logo
 * @property string $banner_image
 * @property string $company_location
 * @property string $country_of_origin
 * @property string $website
 * @property string $established_at
 * @property integer $active_business_years
 * @property integer $import_export
 * @property integer $no_of_staffs
 * @property string $description
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property CustomCategory[] $customCategories
 * @property DirectoryInformation[] $directoryInformations
 * @property Product[] $products
 * @property Rating[] $ratings
 */
class CompanyInformation extends CActiveRecord
{
            /**
         * Behaviors for this model
         */
        public function behaviors(){
          return array(
            'sluggable' => array(
              'class'=>'ext.behaviors.SluggableBehavior',
              'columns' => array('company_name'),
              'unique' => true,
              'update' => true,
            ),
          );
        }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyInformation the static model class
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
		return 'company_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, company_name, logo, company_location, country_of_origin, website, established_at, active_business_years, import_export, no_of_staffs, description, status, created_at, modified_at', 'required'),
			array('member_id, active_business_years, import_export, no_of_staffs, status, trash', 'numerical', 'integerOnly'=>true),
			array('company_name, slug, logo, banner_image, company_location, country_of_origin, website', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, member_id, company_name, slug, logo, banner_image, company_location, country_of_origin, website, established_at, active_business_years, import_export, no_of_staffs, description, status, trash, created_at, modified_at, trashed_at', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'customCategories' => array(self::HAS_MANY, 'CustomCategory', 'company_id'),
			'directoryInformations' => array(self::HAS_MANY, 'DirectoryInformation', 'company_id'),
			'products' => array(self::HAS_MANY, 'Product', 'company_id'),
			'ratings' => array(self::HAS_MANY, 'Rating', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => 'Company',
			'member_id' => 'Member',
			'company_name' => 'Company Name',
			'slug' => 'Slug',
			'logo' => 'Logo',
			'banner_image' => 'Banner Image',
			'company_location' => 'Company Location',
			'country_of_origin' => 'Country Of Origin',
			'website' => 'Website',
			'established_at' => 'Established At',
			'active_business_years' => 'Active Business Years',
			'import_export' => 'Import Export',
			'no_of_staffs' => 'No Of Staffs',
			'description' => 'Description',
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

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('banner_image',$this->banner_image,true);
		$criteria->compare('company_location',$this->company_location,true);
		$criteria->compare('country_of_origin',$this->country_of_origin,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('established_at',$this->established_at,true);
		$criteria->compare('active_business_years',$this->active_business_years);
		$criteria->compare('import_export',$this->import_export);
		$criteria->compare('no_of_staffs',$this->no_of_staffs);
		$criteria->compare('description',$this->description,true);
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