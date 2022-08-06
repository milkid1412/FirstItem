<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem\command;

use Kkevin14\FirtstItem\FirstItem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class DeleteFirstItemCommand extends Command
{
    public FirstItem $owner;

    public function __construct(FirstItem $owner)
    {
        parent::__construct('/기본템제거', '서버의 기본템을 제거합니다.', '/기본템제거 (번호)', ['기본템삭제']);
        $this->owner = $owner;
        $this->setPermission('firstitem.command.deleteitem');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        if(!isset($args[0]) || !is_numeric($args[0])){
            $sender->sendMessage('§l§e⦁ §7사용법: ' . $this->getUsage());
            return;
        }
        if(!isset($this->owner->db['items'][(int) $args[0]])){
            $sender->sendMessage('§l§e⦁ §7' . $args[0] . '번 아이템은 존재하지 않습니다.');
            return;
        }
        unset($this->owner->db['items'][(int) $args[0]]);
        $this->owner->db['items'] = array_values($this->owner->db['items']);
        $sender->sendMessage('§l§e⦁ §7' . $args[0] . '번 아이템이 삭제되었습니다.');
    }
}