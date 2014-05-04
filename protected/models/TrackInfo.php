<?php

/**
 * This is the model class for table "trackInfo".
 *
 * The followings are the available columns in table 'trackInfo':
 * @property string $id
 * @property string $pNumber
 * @property string $eventTime
 * @property string $coordinates
 * @property string $sms
 *
 * The followings are the available model relations:
 * @property GpsDevice[] $gpsDevices
 */
class TrackInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TrackInfo the static model class
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
		return 'trackInfo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pNumber, eventTime, coordinates, sms', 'required'),
			array('pNumber', 'length', 'max'=>13),
			array('coordinates', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pNumber, eventTime, coordinates, sms', 'safe', 'on'=>'search'),
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
			'gpsDevices' => array(self::HAS_MANY, 'GpsDevice', 'phoneNumber'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pNumber' => 'Phone Number',
			'eventTime' => 'Event Time',
			'coordinates' => 'Coordinates',
			'sms' => 'Sms',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('pNumber',$this->pNumber,true);
		$criteria->compare('eventTime',$this->eventTime,true);
		$criteria->compare('coordinates',$this->coordinates,true);
		$criteria->compare('sms',$this->sms,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}