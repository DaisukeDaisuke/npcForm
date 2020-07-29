<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace npc\entity;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class npc extends Entity{
	public const NETWORK_ID = 51;

	public $width = 0.6;
	public $height = 1.8;
	public $eyeHeight = 1.6;
	//protected $baseOffset = 1.6;//...?

	public $chat = null;

	public function __construct(Level $level, CompoundTag $nbt, $chat = null){//?BaseChat
		parent::__construct($level, $nbt);
		$this->setCanSaveWithChunk(false);//Disable save on PocketMine-MP side...
		$this->setChat($chat);
	}

	protected function initEntity(): void{
		parent::initEntity();

		//$this->propertyManager->setString(self::DATA_NPC_SKIN_INDEX, $this->player->getSkin()->getSkinId());

		$this->setChatEnable(true);
	}

	public function setChatEnable(bool $enable){
		$this->propertyManager->setByte(self::DATA_HAS_NPC_COMPONENT, (int) $enable);
	}

	public function isChatEnable(): bool{
		return (bool) ($this->propertyManager->getByte(self::DATA_HAS_NPC_COMPONENT));
	}

	public function setText(string $text){
		$this->propertyManager->setString(self::DATA_INTERACTIVE_TAG, $text);
	}

	public function getText(): string{
		return $this->propertyManager->getString(self::DATA_INTERACTIVE_TAG);
	}

	public function setChat($chat){//?BaseChat
		$this->chat = $chat;
		if($chat !== null){
			$this->setText($chat->getContents());
			$this->setNameTag($chat->getTitle());
			$this->setActionJson($chat->getActionJson());
		}
	}

	public function getChat(){//: ?BaseChat
		return $this->chat;
	}

	public function setActionJson(string $json){//
		$this->propertyManager->setString(self::DATA_NPC_ACTIONS, $json);
	}

	public function getActionJson(): string{//
		return $this->propertyManager->getString(self::DATA_NPC_ACTIONS);
	}

	public function getName(): string{
		return "NPC";
	}

	protected function sendSpawnPacket(Player $player): void{
		parent::sendSpawnPacket($player);
	}

	public static function create(Vector3 $pos, ?Level $level = null, $chat, bool $spawnAll = true): self{//BaseChat $chat
		if($pos instanceof Position){
			$level = $pos->getLevel();
		}
		$nbt = self::createBaseNBT($pos, null, lcg_value() * 360, 0);

		$entity = new static($level, $nbt, $chat);

		if($spawnAll){
			$entity->spawnToAll();
		}

		return $entity;
	}

	public function handleResponse(Player $player, ?int $response){
		$chat = $this->getChat();
		if($chat !== null){
			$chat->handleResponse($player, $response);
		}
	}

	public function attack(EntityDamageEvent $source): void{
		if($source->getCause() === EntityDamageEvent::CAUSE_VOID){
			parent::attack($source);
		}
	}
}
