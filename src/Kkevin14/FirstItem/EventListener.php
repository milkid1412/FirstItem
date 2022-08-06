<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;

class EventListener implements Listener
{
    public FirstItem $owner;

    public function __construct(FirstItem $owner)
    {
        $this->owner = $owner;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        if(!$player->hasPlayedBefore()){
            $name = $player->getName();
            if(($msg = $this->owner->db['welcome']) !== ''){
                $player->sendMessage('§l§e⦁ §7' . str_replace($msg, '(n)', $name));
            }
            if(!empty($this->owner->db['items'])){
                foreach($this->owner->db['items'] as $item){
                    $item = Item::jsonDeserialize($item);
                    $player->getInventory()->addItem($item);
                }
            }
        }
    }
}