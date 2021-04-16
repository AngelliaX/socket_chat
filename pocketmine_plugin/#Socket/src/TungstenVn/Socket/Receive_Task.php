<?php

namespace TungstenVn\Socket;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Player;
use pocketmine\scheduler\Task;


class Receive_Task extends Task
{
	public $owner;
	private $readNumb = 0;
	public function __construct(Socket $owner)
	{
		$this->owner = $owner;
		
		/*
		while(true){
		$read = $this->owner->client->read();
		var_dump($read);
		};*/
	}
	private $timer = 0;
	public function onRun(int $currentTick)
	{	 
	    
		#$this->owner->readBro();
	    $read = $this->owner->client->read();
		print("==========id: ".$this->readNumb.", msg: $read\n");
		$this->owner->client->close();
		$this->owner->client->initialize();


	    return;
	    if($this->readNumb >=1){
			$this->owner->client->close();
			$this->readNumb = 0;
			$this->owner->client->initialize();
			#$this->owner->client->emit("doanxem",["123"]);
		    $this->owner->client->read();
			var_dump("reset");
			return;
		}
		$read = $this->owner->client->read();
		print("==========id: ".$this->readNumb.", msg: $read\n");
		$this->readNumb++;
	}
}