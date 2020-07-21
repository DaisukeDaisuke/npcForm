<?php

namespace npc\chat;

use pocketmine\Player;

class BaseChat{
	public $contents = "";
	public $title = "";
	public $buttons = [];

	public function __construct(){

	}

	public function setTitle(string $title){
		$this->title = $title;
	}

	public function getTitle(): string{
		return $this->title;

	}

	public function setContents(string $contents){
		$this->contents = $contents;
	}

	public function getContents(): string{
		return $this->contents;
	}


	public function addButton(string $label){
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

	public function getActionJson(): string{
		return json_encode($this->buttons, JSON_UNESCAPED_UNICODE);
	}

	public function handleResponse(Player $player, ?int $response){

	}
}