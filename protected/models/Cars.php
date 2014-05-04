<?php

/**
 * This is the model class for table "cars".
 *
 * The followings are the available columns in table 'cars':
 * @property string $regNo
 * @property string $deviceId
 * @property integer $ownerId
 * @property string $model
 * @property string $make
 *
 * The followings are the available model relations:
 * @property Users $owner
 * @property GpsDevice $device
 */
class Cars extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cars the static model class
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
		return 'cars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('regNo, deviceId, ownerId, model, make', 'required'),
			array('ownerId', 'numerical', 'integerOnly'=>true),
			array('regNo', 'length', 'max'=>10),
			array('deviceId', 'length', 'max'=>50),
			array('model, make', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('regNo, deviceId, ownerId, model, make', 'safe', 'on'=>'search'),
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
			'owner' => array(self::BELONGS_TO, 'Users', 'ownerId'),
			'device' => array(self::BELONGS_TO, 'GpsDevice', 'deviceId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'regNo' => 'Reg No',
			'deviceId' => 'Device',
			'ownerId' => 'Owner',
			'model' => 'Model',
			'make' => 'Make',
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

		$criteria->compare('regNo',$this->regNo,true);
		$criteria->compare('deviceId',$this->deviceId,true);
		$criteria->compare('ownerId',$this->ownerId);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('make',$this->make,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}