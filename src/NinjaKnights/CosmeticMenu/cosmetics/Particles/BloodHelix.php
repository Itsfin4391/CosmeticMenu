<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\scheduler\Task as PluginTask;

class BloodHelix extends PluginTask
{

    public function __construct(CosmeticMenu $plugin)
    {
        $this->plugin = $plugin;
        $this->r = 0;
    }

    public function onRun($tick)
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $level = $player->getLevel();

            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();
            if (in_array($name, $this->plugin->particle8)) {

            }
        }
    }

}