<?php

/**
 * This is the model class for table "gpsDevice".
 *
 * The followings are the available columns in table 'gpsDevice':
 * @property string $deviceId
 * @property string $phoneNumber
 * @property string $password
 * @property string $authorizedNumbers
 *
 * The followings are the available model relations:
 * @property Cars[] $cars
 * @property TrackingInfo[] $trackingInfos
 */
class GpsDevice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GpsDevice the static model class
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
		return 'gpsDevice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deviceId, phoneNumber, password, authorizedNumbers', 'required'),
			array('deviceId, password', 'length', 'max'=>20),
			array('phoneNumber', 'length', 'max'=>13),
			array('authorizedNumbers', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('deviceId, phoneNumber, password, authorizedNumbers', 'safe', 'on'=>'search'),
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
			'cars' => array(self::HAS_MANY, 'Cars', 'deviceId'),
			'trackingInfos' => array(self::HAS_MANY, 'TrackingInfo', 'phoneNumber'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'deviceId' => 'Device',
			'phoneNumber' => 'Phone Number',
			'password' => 'Password',
			'authorizedNumbers' => 'Authorized Numbers',
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

		$criteria->compare('deviceId',$this->deviceId,true);
		$criteria->compare('phoneNumber',$this->phoneNumber,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('authorizedNumbers',$this->authorizedNumbers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}