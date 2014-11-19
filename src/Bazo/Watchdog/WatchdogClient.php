<?php

namespace Bazo\Watchdog;

/**
 * Description of WatchdogClient
 *
 * @author Martin
 */
class WatchdogClient
{

	private $appId;
	private $appKey;
	private $endPoint = '/api/log';


	public function __construct($appId, $appKey, $server)
	{
		$this->appId = $appId;
		$this->appKey = $appKey;
		$this->endPoint = $server . $this->endPoint;
	}


	public function log($message, $level = Alert::ERROR)
	{
		$data = [
			'appId' => $this->appId,
			'appKey' => $this->appKey,
			'message' => $message,
			'level' => $level
		];

		return $this->sendData($data);
	}


	public function logNette($netteMessage, $level = Alert::ERROR)
	{

		if (is_array($netteMessage)) {
			$message = implode(' ', $netteMessage);
		} else {
			$message = $netteMessage;
		}

		$data = [
			'appId' => $this->appId,
			'appKey' => $this->appKey,
			'message' => $message,
			'level' => $level,
			'nette' => TRUE,
			'netteMessage' => $netteMessage
		];

		return $this->sendData($data);
	}


	private function sendData($data)
	{
		$data = ['data' => json_encode($data)];
		$ch = curl_init($this->endPoint);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);
	}


}

