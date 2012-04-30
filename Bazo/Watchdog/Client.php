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
		$appKey
	;
	
	public function __construct($appId, $appKey)
	{
		$this->appId = $appId;
		$this->appKey = $appKey;
	}
}