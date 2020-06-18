<?php

namespace NinjaKnights\CosmeticMenu\cosmetics\Gadgets;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\entity\Egg;
use pocketmine\entity\Entity;
use pocketmine\entity\Snowball;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\EnumTag;
use pocketmine\network\mcpe\protocol\AddActorPacket;

class GadgetsEvents implements Listener {

    private $plugin;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;
    }

    public function ExplosionPrimeEvent(ExplosionPrimeEvent $event) {
        $event->setBlockBreaking(false);
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $name = $player->getName();
        $iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
        $inv = $player->getInventory();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        //Lightning Stick
        if($iname == CosmeticMenu::LIGHTNINGSTICKITEM) {
            if($player->hasPermission("cosmetic.gadgets.lightningstick")) {
                if(!isset($this->plugin->lsCooldown[$player->getName()])) {
                    $block = $event->getBlock();
                    $lightning = new AddActorPacket();
                    $lightning->entityRuntimeId = Entity::$entityCount++;
                    $lightning->type = "minecraft:lightning_bolt";
                    $lightning->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
                    $lightning->motion = $player->getMotion();
                    $lightning->metadata = [];
                    foreach($player->getLevel()->getPlayers() as $players) {
                        $players->dataPacket($lightning);
                    }
                    $this->plugin->lsCooldown[$player->getName()] = $player->getName();
                    $time = $this->plugin->getConfig()->getNested("Cooldown.Lightning Stick");
                    $this->plugin->lsCooldownTime[$player->getName()] = $time;
                } else {
                    $player->sendPopup("§cYou can't use the Lightning Stick for another " . $this->plugin->lsCooldownTime[$player->getName()] . " seconds.");
                }
            } else {
                $player->sendMessage("You don't have permission to use §l§dLightning §eStick!");
            }
        }
        //Leaper
        if($iname == CosmeticMenu::LEAPER) {
            if($player->hasPermission("cosmetic.gadgets.leaper")) {
                if(!isset($this->plugin->lCooldown[$player->getName()])) {

                    $yaw = $player->yaw;
                    if(0 <= $yaw and $yaw < 22.5) {
                        $player->knockBack($player, 0, 0, 1, 1.5);
                    } elseif(22.5 <= $yaw and $yaw < 67.5) {
                        $player->knockBack($player, 0, -1, 1, 1.5);
                    } elseif(67.5 <= $yaw and $yaw < 112.5) {
                        $player->knockBack($player, 0, -1, 0, 1.5);
                    } elseif(112.5 <= $yaw and $yaw < 157.5) {
                        $player->knockBack($player, 0, -1, -1, 1.5);
                    } elseif(157.5 <= $yaw and $yaw < 202.5) {
                        $player->knockBack($player, 0, 0, -1, 1.5);
                    } elseif(202.5 <= $yaw and $yaw < 247.5) {
                        $player->knockBack($player, 0, 1, -1, 1.5);
                    } elseif(247.5 <= $yaw and $yaw < 292.5) {
                        $player->knockBack($player, 0, 1, 0, 1.5);
                    } elseif(292.5 <= $yaw and $yaw < 337.5) {
                        $player->knockBack($player, 0, 1, 1, 1.5);
                    } elseif(337.5 <= $yaw and $yaw < 360.0) {
                        $player->knockBack($player, 0, 0, 1, 1.5);
                    }
                    $player->sendPopup("§aLeap!");

                    $this->plugin->lCooldown[$player->getName()] = $player->getName();
                    $time = $this->plugin->getConfig()->getNested("Cooldown.Leaper");
                    $this->plugin->lCooldownTime[$player->getName()] = $time;

                } else {
                    $player->sendPopup("§cYou can't use the Leaper for another " . $this->plugin->lCooldownTime[$player->getName()] . " seconds.");
                }
            } else {
                $player->sendMessage("You don't have permission to use §l§2Leaper!");
            }
        }

    }

    function getMain(): CosmeticMenu {
        return $this->plugin;
    }

}
