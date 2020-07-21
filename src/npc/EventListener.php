<?php

namespace npc;

use npc\entity\npc;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\NpcRequestPacket;
use pocketmine\Server;

class EventListener implements Listener{
	/** @var main */
	public $plugin;
	/** @var integer[] */
	public $npc;

	public function __construct(main $plugin){
		$this->plugin = $plugin;
	}

	public function DataPacketReceive(DataPacketReceiveEvent $event){
		if($event->getPacket() instanceof NpcRequestPacket){
			$packet = $event->getPacket();
			if(($entity = Server::getInstance()->findEntity($packet->entityRuntimeId)) === null){
				return;
			}
			if(!$entity instanceof npc){
				return;
			}
			switch($packet->requestType){
				//npc setting
				/*
				case NpcRequestPacket::REQUEST_SET_ACTIONS:
					//$entity->setAction($packet->commandString);
					break;
				case NpcRequestPacket::REQUEST_SET_NAME:
					//$entity->setName($packet->commandString);
					break;
				case NpcRequestPacket::REQUEST_SET_INTERACTION_TEXT:
					//$entity->setContents($packet->commandString);
					break;
				*/

				//npc form response
				case NpcRequestPacket::REQUEST_EXECUTE_ACTION:
					//Wait for the reception of "REQUEST_EXECUTE_CLOSING_COMMANDS".
					$this->npc[$event->getPlayer()->getName()] = $packet->actionType;
					break;
				case NpcRequestPacket::REQUEST_EXECUTE_CLOSING_COMMANDS:
					$player = $event->getPlayer();
					$response = $this->npc[$player->getName()] ?? null;
					unset($this->npc[$player->getName()]);

					$entity->handleResponse($player, $response);
					break;
			}
		}
	}
}

