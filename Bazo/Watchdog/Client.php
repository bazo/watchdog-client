<?php
namespace Bazo\Watchdog;
/**
 * Description of WatchdogClient
 *
 * @author Martin
 */
class Client
{
	private 
		$appId,
		$appKey,
		
		$endPoint = 'http://watchdog.local/api/log'	
	;
	
	public function __construct($appId, $appKey)
	{
		$this->appId = $appId;
		$this->appKey = $appKey;
	}
	
	public function log($message, $level = 'error')
	{
		$data = array(
			'appId' => $this->appId,
			'appKey' => $this->appKey,
			'message' => $message,
			'level' => $level
		);
		
		$ch = curl_init($this->endPoint);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);
	}
}