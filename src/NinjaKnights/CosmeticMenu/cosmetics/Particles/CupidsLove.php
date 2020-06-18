<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;

class CupidsLove extends PluginTask
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
            if (in_array($name, $this->plugin->particle4)) {
                $size = 1.2;
                $a = cos(deg2rad($this->r / 0.09)) * $size;
                $b = sin(deg2rad($this->r / 0.09)) * $size;
                $c = sin(deg2rad($this->r / 0.2)) * $size;
                $level->addParticle(new HeartParticle(new Vector3($x - $a, $y + $c + 1.4, $z - $b)));
                $this->r++;
            } 	
        }
    }

}