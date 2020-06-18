<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use NinjaKnights\CosmeticMenu\particleeffects\Conduit;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;

class ConduitHalo extends PluginTask
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
            if (in_array($name, $this->plugin->particle6)) {
                $size = 0.6;
                $a = cos(deg2rad($this->r / 0.06)) * $size;
                $b = sin(deg2rad($this->r / 0.06)) * $size;
                $level->addParticle(new Conduit(new Vector3($x - $a, $y + 2, $z - $b)));
                $level->addParticle(new Conduit(new Vector3($x - $a, $y + 2, $z - $b)));
                $this->r++;
            } 	
        }
    }

}