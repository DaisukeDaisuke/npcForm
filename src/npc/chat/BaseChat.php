<?php

namespace npc\chat;

use pocketmine\Player;

class BaseChat{
	public $content = "";
	public $title = "";
	public $buttons = [];

	public function __construct(){
		
	}

	public function setTitle(String $title){
		$this->title = $title;
	}

	public function getTitle(): String{
		return $this->title;

	}

	public function setContents(String $contents){
		$this->contents = $contents;
	}

	public function getContents(): String{
		return $this->contents;
	}


	public function addButton(String $label){
		$this->buttons[] = [
			"button_name" => $label,
			"data" => null,
			"mode" => 0,
			"text" => "",
			"type" => 1,
		];
	}

	public function getActionArray(): array{
		return $this->buttons;
	}

	public function getActionJson(): String{
		return json_encode($this->buttons, JSON_UNESCAPED_UNICODE);
	}

	public function handleResponse(Player $player, ?int $response){
		
	}
}