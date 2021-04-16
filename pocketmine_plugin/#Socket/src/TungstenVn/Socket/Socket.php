<?php

namespace TungstenVn\Socket;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\CommandEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\network\mcpe\protocol\CommandRequestPacket;

use TungstenVn\Socket\elephantio\src\Client;
use TungstenVn\Socket\elephantio\src\Engine\SocketIO\Version1X;
class Socket extends PluginBase implements Listener
{
	public $client;
    public function onEnable()
    {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		
		
		ini_set('default_socket_timeout', 5); //set timeout to 1 sec
		
		$version = new Version1X("http://127.0.0.1:80");
		$client = new Client($version);
		$client->initialize();
		$this->client = $client;
		$client->emit("doanxem",["123"]);
		#$read= $client->read();
		#var_dump($read);
		var_dump("activation");
		
		#$this->getServer()->getAsyncPool()->submitTask(new checkUpdate());
		$task = new Receive_Task($this);
		$this->getScheduler()->scheduleRepeatingTask($task, 0);

	
    }
	public $read;
	public function readBro(){
		$this->client->read();
	}
	public function onServerChat(CommandEvent $sv){
		#$this->client->initialize();
		$this->client->emit("doanxem",["123"]);
		$this->read = $this->client->read();
		#$this->client->close();
	}
	public function onChat(PlayerCommandPreprocessEvent $e){
		var_dump("sfsdfsdsdsf");
		$name = $e->getPlayer()->getName();
		if(null != $this->getConfig()->getNested("JailedPeoples.$name")){
		   $cmd = explode(' ',$e->getMessage())[0];
		   if(in_array($cmd,$this->getConfig()->getNested("CommandForJailer"))){
		   }else{
			   if(strpos($cmd, '/')  !== false){
				   $e->setCancelled();
			       $e->getPlayer()->sendMessage("§aị You cant use commands because of being jail");
			   }
			   if(!$this->getConfig()->getNested("isChat")){
			       $e->setCancelled();
			       $e->getPlayer()->sendMessage("§aị You cant chat because of being jail");		     
			   }
		   }
		}
	}
	
	public function onDisable(){
		
		#$this->client->close();
	}
	
}