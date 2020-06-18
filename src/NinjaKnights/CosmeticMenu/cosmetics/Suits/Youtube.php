<?php

declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\cosmetics\Suits;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\scheduler\Task;
use pocketmine\utils\Color;

class Youtube extends Task {

    /** @var int */
    protected $step = 0;
    /** @var Color */
    protected $color;
    private $plugin;
    private $armors;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;

        $this->armors = [
            ItemFactory::get(Item::LEATHER_CAP),
            ItemFactory::get(Item::LEATHER_TUNIC),
            ItemFactory::get(Item::LEATHER_LEGGINGS),
            ItemFactory::get(Item::LEATHER_BOOTS)];

        $this->color = new Color(255, 0, 0);

    }

    public function onRun($tick) {
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $inv = $player->getInventory();

            $players = $player->getLevel()->getPlayers();
            $level = $player->getLevel();
            $location = $player->getLocation();

            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();

            $this->updateColor();
            $armors = array_map(function(Armor $armor): Armor {
                $armor->setCustomColor($this->color);
                return $armor;
            }, $this->armors);

            if(in_array($name, $this->plugin->suit1)) {
                //$level->dropItem(new Vector3($x, $y + 0.3, $z), Item::get(ITEM::GOLDEN_APPLE));
                $player->getArmorInventory()->setContents($armors);
            }
        }
    }

    protected function updateColor(): void {
        $step = $this->step++;
        if($step <= 16) {
            $this->color->setG($step * 200);
            $this->color->setB($step * 200);
        } elseif($step <= 32) {
            $this->color->setG(255 - 200 * $step);
            $this->color->setB(255 - 200 * $step);
        } elseif($step <= 80) {
            $this->color->setG($step * 200);
            $this->color->setB($step * 200);
        } elseif($step <= 96) {
            $this->color->setG(255 - 200 * $step);
            $this->color->setB(255 - 200 * $step);
        } else {
            $this->step = 0;
        }
    }

}