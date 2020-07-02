<?php

namespace npc;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;

use pocketmine\network\mcpe\protocol\NpcRequestPacket;

use npc\entity\npc;
use npc\chat\SimpleChat;

class EventListener implements Listener{
	/** @var main */
	public $plugin;

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
					//「REQUEST_EXECUTE_CLOSING_COMMANDS」の受信を待ちます。
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
