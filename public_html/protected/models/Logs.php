<?php

/**
 * This is the model class for table "SystemEvents".
 *
 * The followings are the available columns in table 'SystemEvents':
 * @property string $ID
 * @property string $CustomerID
 * @property string $ReceivedAt
 * @property string $DeviceReportedTime
 * @property integer $Facility
 * @property integer $Priority
 * @property string $FromHost
 * @property string $Message
 * @property integer $NTSeverity
 * @property integer $Importance
 * @property string $EventSource
 * @property string $EventUser
 * @property integer $EventCategory
 * @property integer $EventID
 * @property string $EventBinaryData
 * @property integer $MaxAvailable
 * @property integer $CurrUsage
 * @property integer $MinUsage
 * @property integer $MaxUsage
 * @property integer $InfoUnitID
 * @property string $SysLogTag
 * @property string $EventLogType
 * @property string $GenericFileName
 * @property integer $SystemID
 */
class Logs extends CActiveRecord
{
	public $start=FALSE;
	public $end=FALSE;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['TBL_name'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ReceivedAt, Facility, Priority, FromHost, Message, SysLogTag, daterange', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'ReceivedAt' => 'Received At',
			'DeviceReportedTime' => 'Device Reported Time',
			'Facility' => 'Facility',
			'Priority' => 'Priority',
			'FromHost' => 'From Host',
			'Message' => 'Message',
			'InfoUnitID' => 'Info Unit',
			'SysLogTag' => 'Sys Log Tag',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		//daterange
		$datefilter=new DatefilterForm;
		$datefilter->daterange= $this->ReceivedAt;
	 	// validate
	 	if($datefilter->validate()) {
	 		$this->start = ($datefilter->startdateTS ? date("Y-m-d", $datefilter->startdateTS) : false);
	 		$this->end = ($datefilter->enddateTS ? date("Y-m-d", ($datefilter->enddateTS)) : false);
	 		if ($this->start & $this->end) {
	 			$criteria->compare('ReceivedAt','>='.$this->start);
	 			$criteria->compare('ReceivedAt','<='.$this->end.' 23:59:59');
	 		}
		} else {
 			//filter normal
 			$criteria->compare('ReceivedAt',$this->ReceivedAt,true);	
 		}

		$criteria->compare('Facility',$this->Facility);
		$criteria->compare('Priority',$this->Priority);
		$criteria->compare('FromHost',$this->FromHost,true);
		$criteria->compare('Message',$this->Message,true);
		$criteria->compare('SysLogTag',$this->SysLogTag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
