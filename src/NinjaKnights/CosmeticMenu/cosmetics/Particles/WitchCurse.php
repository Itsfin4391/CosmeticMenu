<?php

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use NinjaKnights\CosmeticMenu\particleeffects\WitchCurseEffect;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;

class WitchCurse extends PluginTask {

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
            if(in_array($name, $this->plugin->particle7)) {
                if($this->r < 0) {
                    $this->r++;
                    return true;
                }
                $a = cos($this->r * 0.1) * 2;
                $b = sin($this->r * 0.1) * 2;
                $level->addParticle(new WitchCurseEffect(new Vector3($x + $a, $y + 1, $z + $b)));
                $level->addParticle(new WitchCurseEffect(new Vector3($x - $a, $y + 1, $z - $b)));
                $level->addParticle(new WitchCurseEffect(new Vector3($x + $b, $y + 1, $z - $a)));
                $level->addParticle(new WitchCurseEffect(new Vector3($x - $b, $y + 1, $z + $a)));
                $this->r++;
            }
        }
    }

}