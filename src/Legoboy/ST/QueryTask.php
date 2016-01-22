<?php

namespace Legoboy\ST;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use Legoboy\ST\Loader as ST;

class QueryTask extends AsyncTask{
	
	private $path;
	
	const KEY_MYSQL = 'st.mysql';
	const USERS = 0;
	
	public function __construct($path){
		$this->path = $path;
	}

	public function onRun(){
		foreach(glob($this->path . "*/*.yml") as $file){
			$data = yaml_parse_file($file);
			var_dump($data);
			$player = strtolower(basename($file, ".yml"));
			$regdate = $data['registerdate'];
			$logindate = $data['logindate'];
			$ip = $data["lastip"];
			$password = $data['hash'];
			$result = $this->db->query("INSERT INTO simpleauth_players (name, hash, registerdate, logindate, lastip)
										VALUES ('$pname', '$hash', '$regdate', '$logindate', '$ip')");
			if($result){
				self::USERS++;
			}else{
				$this->getLogger()->critical("Unable to sumbit user to MySQL Database: Query error.");
				continue;
			}
		}
	}

    public function onCompletion(Server $server){
        $base = $server->getPluginManager()->getPlugin("SimpleTransfer");
        if($base instanceof PluginBase){
            $base->getLogger()->warning("All users SUCCESSFULLY queried into database.");
        }
    }
	
	//PEMapModder's code
	
	/**
	 * @return \mysqli
	 */
	 
	public function getConnection(){
		$mysql = $this->getFromThreadStore(sef::KEY_MYSQL);
		if(!($mysql instanceof \mysqli)){
			$mysql = ST::getMySQL();
			$this->saveToThreadStore(self::KEY_MYSQL, $mysql);
		}
		return $mysql;
	}
	
	public function saveToThreadStore($identifier, $value){
		global $store;
		if(!$this->isGarbage()){
			$store[$identifier] = $value;
		}
	}
	
	public function getFromThreadStore($identifier){
		global $store;
		return $this->isGarbage() ? null : $store[$identifier];
	}
}
