<?php

namespace Legoboy\ST;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Loader extends PluginBase{
	
	public static $db;
	
	public function onLoad(){
		if(!file_exists($this->getDataFolder())){
			@mkdir($this->getDataFolder());
		}
		$this->saveDefaultConfig();
		$mysql = self::$db = new \mysqli(!is_null($this->getConfig()->get("server-name")) ? $this->getConfig()->get("server-name") : "localhost", $this->getConfig()->get("username"), $this->getConfig()->get("password"), $this->getConfig()->get("simpleauth-dbname"), !is_null($this->getConfig()->get("port")) ? ((int)$this->getConfig()->get("port")) : 3306);
		if($mysql->connect_error){
			die("Connection failed: " . $mysql->connect_error);
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return;
		}
		$resource = $this->getResource("mysql.sql");
		$mysql->query(stream_get_contents($resource));
		fclose($resource);
	}
	
	public function onEnable(){
		$this->process();
	}
	
	public static function getMySQL(){
		return self::$db;
	}
	
	public function process(){
		$path = $this->getServer()->getPluginManager()->getPlugin("SimpleAuth")->getDataFolder() . "/players/";
		$this->getServer()->getScheduler()->scheduleAsyncTask(new QueryTask($path));
	}
}
