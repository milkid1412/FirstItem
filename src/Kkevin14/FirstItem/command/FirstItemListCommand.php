<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem\command;

use Kkevin14\FirtstItem\FirstItem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\player\Player;

class FirstItemListCommand extends Command
{
    public FirstItem $owner;

    public function __construct(FirstItem $owner)
    {
        parent::__construct('/기본템목록', '서버의 기본템 목록을 확인합니다.', '/기본템목록', []);
        $this->owner = $owner;
        $this->setPermission('firstitem.command.itemlist');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        $item_list = '§l§e⦁ §7추가된 아이템:' . "\n";
        $i = 0;
        foreach($this->owner->db['items'] as $item){
            $item = Item::jsonDeserialize($item);
            $itemName = $item->hasCustomName() ? $item->getCustomName() : $item->getName();
            $item_list .= '§l§e⦁ §f' . $i . '번 - §7' . $itemName . '::' . $item->getCount() . "\n";
            $i++;
        }
        $item_list = rtrim($item_list, "\n");
        $sender->sendMessage($item_list);
    }
}