<?php

/**
 * LoggerForm class.
 * LoggerForm is the data structure for keeping Logger data.
 * It is used by the 'logger' action of 'SiteController'.
 */
class LoggerForm extends CFormModel
{
	public $facility=1; // 0-23
	public $severity=6; // 0-7
	public $hostname="Test_host"; // no embedded space, no domain name, only a-z A-Z 0-9 and other authorized characters
	public $fqdn;
	public $ip_from;
	public $process;
	public $content='Test message';
	public $msg;
	public $server='localhost';   // Syslog destination server
	public $port;     // Standard syslog port is 514
	public $timeout;  // Timeout of the UDP connection (in seconds)

	/**
	 * Validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('facility, severity, hostname, content, server', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'content'=>'Log message',
		);
	}
}