<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;

class RainCloud extends PluginTask
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
            if (in_array($name, $this->plugin->particle1)) {
                if ($this->r < 0) {
                    $this->r++;
                    return true;
                }
                $a = cos(deg2rad($this->r / 0.04)) * 0.5;
                $b = sin(deg2rad($this->r / 0.04)) * 0.5;
                $c = cos(deg2rad($this->r / 0.04)) * 0.8;
                $d = sin(deg2rad($this->r / 0.04)) * 0.8;
                $level->addParticle(new MobSpawnParticle(new Vector3($x - $a, $y + 3, $z - $b)));
                $level->addParticle(new MobSpawnParticle(new Vector3($x - $b, $y + 3, $z - $a)));
        
                $level->addParticle(new SplashParticle(new Vector3($x - $a, $y + 2.3, $z - $b)));
                $level->addParticle(new SplashParticle(new Vector3($x - $b, $y + 2.3, $z - $a)));
        
                $level->addParticle(new MobSpawnParticle(new Vector3($x - $c, $y + 3, $z - $d)));
                $level->addParticle(new MobSpawnParticle(new Vector3($x - $d, $y + 3, $z - $c)));
        
                $level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
                $level->addParticle(new SplashParticle(new Vector3($x, $y + 2.3, $z)));
        
                $this->r++;
            } 	
        }
    }

}