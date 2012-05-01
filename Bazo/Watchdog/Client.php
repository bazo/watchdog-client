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
		
		$endPoint = '/api/log'	
	;
	
	public function __construct($appId, $appKey, $server = 'http://watchdog.pagodabox.com')
	{
		$this->appId = $appId;
		$this->appKey = $appKey;
		$this->endPoint = $server.$this->endPoint;
	}
	
	public function log($message, $level = Alert::ERROR)
	{
		$data = array(
			'appId' => $this->appId,
			'appKey' => $this->appKey,
			'message' => $message,
			'level' => $level
		);
		
		return $this->sendData($data);
	}
	
	public function logNette($netteMessage, $level = Alert::ERROR)
	{
		
		if (is_array($netteMessage)) {
			$message = implode(' ', $netteMessage);
		}
		
		$data = array(
			'appId' => $this->appId,
			'appKey' => $this->appKey,
			'message' => $message,
			'level' => $level,
			'nette' => true,
			'netteMessage' => $netteMessage
		);
		
		return $this->sendData($data);
	}
	
	private function sendData($data)
	{
		$data = array('data' => json_encode($data));
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