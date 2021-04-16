<?php

namespace TungstenVn\Socket;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use TungstenVn\Socket\elephantio\src\Client;
use TungstenVn\Socket\elephantio\src\Engine\SocketIO\Version1X;
class checkUpdate extends AsyncTask
{

    /**
     *
     */
    public function onRun(): void
    {
		ini_set('default_socket_timeout', 1); //set timeout to 1 sec
		
		$version = new Version1X("http://127.0.0.1:80");
		
		$client = new Client($version);
		$client->initialize();
		$this->client = $client;
		$client->emit("doanxem",["123"]);
		
		$readNumb = 0;
       while(true){
		   if($readNumb >=1){
			$client->close();
			$this->readNumb = 0;
			$client->initialize();
			#$this->owner->client->emit("doanxem",["123"]);
		    #$this->owner->client->read();
		   }else{
			$read = $client->read();
		    var_dump($read);
			var_dump($readNumb);
	 	    $readNumb++;  
		   }
		    
	   }
        #$this->setResult($content);
    }

    /**
     * @param Server $server
     */
    public function onCompletion(Server $server): void
    {
        $content = $this->getResult();
		var_dump($content);
    }
}
