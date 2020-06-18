<?php

declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\cosmetics\Suits;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\scheduler\Task;
use pocketmine\utils\Color;

class Frog extends Task {

    private $plugin;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;

        $this->armors = [
            ItemFactory::get(Item::LEATHER_CAP),
            ItemFactory::get(Item::LEATHER_TUNIC),
            ItemFactory::get(Item::LEATHER_LEGGINGS),
            ItemFactory::get(Item::LEATHER_BOOTS)];

        $this->color = new Color(5, 79, 0);
    }

    public function onRun($tick) {
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();

            $armors = array_map(function(Armor $armor): Armor {
                $armor->setCustomColor($this->color);
                return $armor;
            }, $this->armors);
            if(in_array($name, $this->plugin->suit2)) {
                $player->getArmorInventory()->setContents($armors);
                $effect = Effect::getEffect(8);
                $player->addEffect(new EffectInstance($effect, 999, 1));

            }
        }
    }


}