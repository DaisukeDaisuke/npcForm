<?php

namespace npc\chat;

use pocketmine\Player;

class SimpleChat extends BaseChat{
	//@see BaseChat
	/** @var ?callable */
	public $callable = null;

	public function __construct(?callable $callable = null){
		parent::__construct();
		$this->setCallable($callable);
	}

	public function getCallable(): ?callable{
		return $this->callable;
	}

	public function setCallable(?callable $callable){
		$this->callable = $callable;
	}

	public function handleResponse(Player $player, ?int $response){
		if(isset($this->callable)){
			($this->callable)($player, $response);
		}
	}
}
