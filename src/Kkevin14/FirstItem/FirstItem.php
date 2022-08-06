<?php
declare(strict_types=1);

namespace Kkevin14\FirtstItem;

use Kkevin14\FirtstItem\command\AddFirstItemCommand;
use Kkevin14\FirtstItem\command\DeleteFirstItemCommand;
use Kkevin14\FirtstItem\command\EditWelcomeMessageCommand;
use Kkevin14\FirtstItem\command\FirstItemListCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class FirstItem extends PluginBase
{
    public Config $database;

    public array $db;

    protected function onEnable(): void
    {
        $this->database = new Config($this->getDataFolder() . 'data.yml', Config::YAML, [
            'welcome' => '',
            'items' => []
        ]);
        $this->db = $this->database->getAll();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->registerAll('Kkevin14', [new AddFirstItemCommand($this), new DeleteFirstItemCommand($this), new FirstItemListCommand($this), new EditWelcomeMessageCommand($this)]);
    }

    /**
     * @throws \JsonException
     */
    public function onDisable(): void
    {
        $this->database->setAll($this->db);
        $this->database->save();
    }
}