<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem\command;

use Kkevin14\FirtstItem\FirstItem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class EditWelcomeMessageCommand extends Command
{
    public FirstItem $owner;

    public function __construct(FirstItem $owner)
    {
        parent::__construct('/환영말', '서버의 환영말을 수정합니다.', '/환영말 (메시지)', []);
        $this->owner = $owner;
        $this->setPermission('firstitem.command.editwelcome');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        if(!isset($args[0])){
            $sender->sendMessage('§l§e⦁ §7사용법: ' . $this->getUsage());
            return;
        }
        $args = implode(' ', $args);
        $this->owner->db['welcome'] = $args;
        $sender->sendMessage('§l§e⦁ §7서버 환영말이 §f"' . $args . '§f"§7로 설정되었습니다.');
    }
}