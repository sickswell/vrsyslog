<?php

/**
 * This is the model class for System Constants.
 *
 * Use it like this:
 * Constants::getArray(); // Full array: Array[]
 * OR 
 * Constants::getArray(key); // Value of Array [key]
 */

class myConstants
{
	/**
	 * @return array the array or array element
	 */

	private static $Severity = array(
			'0' => 'Emergency',
			'1' => 'Alert',
			'2' => 'Critical',
			'3' => 'Error',
			'4' => 'Warning',
			'5' => 'Notice',
			'6' => 'Informational',
			'7' => 'Debug', 
		),

	public static function getSeverity($index = false) {
        return $index !== false ? self::$Severity[$index] : self::$Severity;
    }
	
}






    

