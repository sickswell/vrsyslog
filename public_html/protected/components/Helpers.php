<?php

/**
 * This is a System-wide helper class.
 *
 * Helpers::getArray(); // Full array: Array[]
 * OR 
 * Helpers::getArray(key); // Value of Array [key]
 */

class Helpers
{

	private static $Severity = array(
			'0' => 'Emergency',
			'1' => 'Alert',
			'2' => 'Critical',
			'3' => 'Error',
			'4' => 'Warning',
			'5' => 'Notice',
			'6' => 'Informational',
			'7' => 'Debug',
		);

	public static function getSeverity($index = false) {
        return $index !== false ? self::$Severity[$index] : self::$Severity;
    }

    private static $SeverityColors = array(
			'0' => 'inverse',
			'1' => 'important',
			'2' => 'important',
			'3' => 'important',
			'4' => 'warning',
			'5' => 'success',
			'6' => 'info',
			'7' => 'default', 
		);

    public static function getSeverityColor($index = false) {
        return $index !== false ? self::$SeverityColors[$index] : self::$SeverityColors;
    }
	
    private static $MorrisColors = array(
			'0' => '#363636',
			'1' => '#A34B47',
			'2' => '#BF0741',
			'3' => '#BF0741',
			'4' => '#E29300',
			'5' => '#5E884A',
			'6' => '#5785AC',
			'7' => '#DEECF7', 
		);

     public static function getMorrisColors($index = false) {
        return $index !== false ? self::$MorrisColors[$index] : self::$MorrisColors;
    }

	private static $Facility = array(
			'0' => 'kernel',
			'1' => 'user',
			'2' => 'mail',
			'3' => 'daemon',
			'4' => 'authorization',
			'5' => 'syslog',
			'6' => 'printer',
			'7' => 'news',
			'8' => 'UUCP',
			'9' => 'clock',
			'10' => 'authpriv',
			'11' => 'FTP',
			'12' => 'NTP',
			'13' => 'log audit',
			'14' => 'log alert',
			'15' => 'cron',
			'16' => 'local0',
			'17' => 'local1',
			'18' => 'local2',
			'19' => 'local3',
			'20' => 'local4',
			'21' => 'local5',
			'22' => 'local6',
			'23' => 'local7',
		);

	public static function getFacility($index = false) {
        return $index !== false ? self::$Facility[$index] : self::$Facility;
    }

}	
