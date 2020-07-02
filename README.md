# npcForm
![_20200702_112544](https://user-images.githubusercontent.com/17798680/86310215-712add80-bc58-11ea-983e-1cdf37fd1e2b.JPG)
## example

```php
use pocketmine\Player;

use npc\entity\npc;
use npc\chat\SimpleChat;
```
```php
//$player = $event->getPlayer();
//$level = $player->getLevel();
//$pos = $player->asVector3();

$chat = new SimpleChat(function(Player $player, ?int $response){
	$player->sendMessage((String) $response);
});

$chat->setTitle("title");
$chat->setContents("contents");

$chat->addButton("button0");
$chat->addButton("button1");
$chat->addButton("button2");
$chat->addButton("button3");
$chat->addButton("button4");
$chat->addButton("button5");

$entity = npc::create($pos, $level, $chat);//NPC Entity Spawn

```
## License

[NYSL](http://www.kmonos.net/nysl/)

[NYSL English](http://www.kmonos.net/nysl/index.en.html)
