<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem\command;

use Kkevin14\FirtstItem\FirstItem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class AddFirstItemCommand extends Command
{
    public FirstItem $owner;

    public function __construct(FirstItem $owner)
    {
        parent::__construct('/기본템추가', '서버의 기본템을 추가합니다.', '/기본템추가', []);
        $this->owner = $owner;
        $this->setPermission('firstitem.command.additem');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        $item = $sender->getInventory()->getItemInHand();
        if($item->isNull()){
            $sender->sendMessage('§l§e⦁ §7공기는 기본템으로 추가할 수 없습니다.');
            return;
        }
        $this->owner->db['items'][] = $item->jsonSerialize();
        $itemName = $item->hasCustomName() ? $item->getCustomName() : $item->getName();
        $sender->sendMessage('§l§e⦁ §f' . $itemName . ' §7아이템 §f' . $item->getCount() . '§7개를 추가하였습니다.');
    }
}