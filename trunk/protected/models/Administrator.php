<?php

/**
 * This is the model class for table "administrator".
 *
 * The followings are the available columns in table 'administrator':
 * @property integer $administrator_id
 * @property string $email
 * @property string $password
 * @property string $password_text
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $role_id
 * @property string $activation_key
 * @property integer $activation_status
 * @property integer $status
 * @property integer $trash
 * @property string $created_at
 * @property string $modified_at
 * @property string $trashed_at
 */
class Administrator extends CActiveRecord {

    public $db_password_text;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Administrator the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'administrator';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, password_text, first_name, last_name', 'required'),
            array('role_id, activation_status, status, trash', 'numerical', 'integerOnly' => true),
            array('email, password_text, first_name, middle_name, last_name, activation_key', 'length', 'max' => 255),
            array('password', 'length', 'max' => 40),
            array('password, password_text', 'length', 'min' => 6),
            array('email', 'email'),
            array('password_text', 'compare', 'compareAttribute' => 'password', 'on' => 'register, update', 'allowEmpty' => false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('administrator_id, email, password, password_text, first_name, middle_name, last_name, role_id, activation_key, activation_status, status, trash, created_at, modified_at, trashed_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'administrator_id' => 'Administrator ID',
            'email' => 'Email',
            'password' => 'Password',
            'password_text' => 'Confirm Password',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'role_id' => 'Role',
            'activation_key' => 'Activation Key',
            'activation_status' => 'Activation Status',
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

        $criteria->compare('administrator_id', $this->administrator_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_text', $this->password_text, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('middle_name', $this->middle_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('activation_key', $this->activation_key, true);
        $criteria->compare('activation_status', $this->activation_status);
        $criteria->compare('status', $this->status);
        $criteria->compare('trash', $this->trash);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('trashed_at', $this->trashed_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.administrator_id DESC',
            ),
        ));
    }

    public function afterValidate() {
        parent::afterValidate();
        if (($this->getScenario() === 'register') || ($this->getScenario() === 'update')) {
            if ($this->password != 'z.$Oq#')
                $this->password = sha1($this->password);
            else {
                if (isset($this->db_password_text)) {
                    $this->password_text = $this->db_password_text;
                }
                $this->password = sha1($this->password_text);
            }
        }
    }

}
