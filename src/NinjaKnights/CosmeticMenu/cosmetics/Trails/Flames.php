<?php

namespace NinjaKnights\CosmeticMenu\cosmetics\Trails;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\level\particle\FlameParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;

class Flames extends PluginTask {

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;
        $this->r = 0;
    }

    public function onRun($tick) {
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $level = $player->getLevel();

            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();
            if(in_array($name, $this->plugin->trail1)) {
                $size = 0.6;
                $a = cos(deg2rad($this->r / 0.06)) * $size;
                $b = sin(deg2rad($this->r / 0.06)) * $size;
                $level->addParticle(new FlameParticle(new Vector3($x - $a, $y + 0.3, $z - $b)));
                $this->r++;
            }
        }
    }


}