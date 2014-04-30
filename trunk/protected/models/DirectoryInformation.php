<?php

/**
 * This is the model class for table "directory_information".
 *
 * The followings are the available columns in table 'directory_information':
 * @property integer $directory_id
 * @property integer $company_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $job_title
 * @property string $image
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $zip_code
 * @property string $address
 * @property string $area
 * @property string $province
 * @property string $country
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 *
 * The followings are the available model relations:
 * @property CompanyInformation $company
 */
class DirectoryInformation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DirectoryInformation the static model class
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
		return 'directory_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, middle_name, last_name, job_title, image, email, phone, fax, zip_code, address, area, province, country, status, created_at, modified_at', 'required'),
			array('company_id, status, trash', 'numerical', 'integerOnly'=>true),
			array('first_name, middle_name, last_name, job_title, image, email, zip_code, address, area, province, country', 'length', 'max'=>255),
			array('phone, fax', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('directory_id, company_id, first_name, middle_name, last_name, job_title, image, email, phone, fax, zip_code, address, area, province, country, status, trash, created_at, modified_at, trashed_at', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'CompanyInformation', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'directory_id' => 'Directory',
			'company_id' => 'Company',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'job_title' => 'Job Title',
			'image' => 'Image',
			'email' => 'Email',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'zip_code' => 'Zip Code',
			'address' => 'Address',
			'area' => 'Area',
			'province' => 'Province',
			'country' => 'Country',
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

		$criteria->compare('directory_id',$this->directory_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('country',$this->country,true);
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