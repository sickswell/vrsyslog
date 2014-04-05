<?php

/**
 * DatefilterForm class.
 * DatefilterForm is the data structure for keeping Date Filter data.
 * It is used by Views and Actions requiring filtering by Date range.
 */
class DatefilterForm extends CFormModel
{
	public $startdateTS=false;
	public $enddateTS=false; 
	public $daterange='';
	

	public function checkrange($attribute,$params)
	{
		$dates = explode(' - ', $this->daterange);

		if (sizeof($dates) == 2) {

			$this->startdateTS = CDateTimeParser::parse($dates[0], 'yyyy-MM-dd');
			$this->enddateTS = CDateTimeParser::parse($dates[1], 'yyyy-MM-dd');

			if(!$this->startdateTS or !$this->enddateTS) {
				$message='Invalid dates.';
				$this->addError($attribute,strtr($message,$params));
			} else {
				if ($this->enddateTS > time()) {
					$message='End date can NOT be greater than today.';
					$this->addError($attribute,strtr($message,$params));
					$this->startdateTS = false;
					$this->enddateTS = false;
				} else {
					if ($this->enddateTS < $this->startdateTS) {
						$message='End date MUST be greater or equal to Start date.';
						$this->addError($attribute,strtr($message,$params));
						$this->startdateTS = false;
						$this->enddateTS = false;
					}
				}
			}
		} else {
			$message='Invalid Date range.';
			$this->addError($attribute,strtr($message,$params));
		}

	}

	/**
	 * Validation rules.
	 */
	public function rules()
	{
		return array(
			array('daterange', 'checkrange'),
		);
	}

	/**
	 * Attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'startdateTS'=>'Start date timestamp',
			'enddateTS'=>'End date timestamp',
			'daterange'=>'Date range',
		);
	}
}