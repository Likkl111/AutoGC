<?php

namespace AutoGC;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class Main extends PluginBase {

    protected function onEnable(): void {
        $this->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            private Main $plugin;

            public function __construct(Main $plugin) {
                $this->plugin = $plugin;
            }

            public function onRun(): void {
                // Выполнение команды GC в консоль
                Server::getInstance()->dispatchCommand(new class extends \pocketmine\command\ConsoleCommandSender {
                    public function getName(): string {
                        return "AutoGC";
                    }
                }, "gc");

                // Отправка сообщения в чат всем игрокам
                foreach(Server::getInstance()->getOnlinePlayers() as $player){
                    $player->sendMessage("§aСервер был почищен от мусора!");
                }
            }
        }, 20 * 60); // каждые 60 секунд
    }
}
