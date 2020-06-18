<?php

namespace NinjaKnights\CosmeticMenu\cosmetics\Gadgets;

use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\entity\Entity;
use pocketmine\entity\PrimedTNT;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;

class TNTLauncher implements Listener {

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
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        //TNT-Launcher
        if($iname == "TNT-Launcher") {
            if($player->hasPermission("cosmetic.gadgets.tntlauncher")) {
                if(!isset($this->plugin->tntCooldown[$player->getName()])) {
                    $nbt = new CompoundTag("", [
                        "Pos" => new ListTag("Pos", [
                            new DoubleTag("", $player->x),
                            new DoubleTag("", $player->y + $player->getEyeHeight()),
                            new DoubleTag("", $player->z)]),
                        "Motion" => new ListTag("Motion", [
                            new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
                            new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
                            new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))]),
                        "Rotation" => new ListTag("Rotation", [
                            new FloatTag("", $player->yaw),
                            new FloatTag("", $player->pitch)]),]);
                    $tnt = Entity::createEntity("PrimedTNT", $player->getLevel(), $nbt, null);
                    $tnt->setMotion($tnt->getMotion()->multiply(2));
                    $tnt->spawnTo($player);
                    $this->plugin->tntCooldown[$player->getName()] = $player->getName();
                    $time = $this->plugin->getConfig()->getNested("Cooldown.TnT-Launcher");
                    $this->plugin->tntCooldownTime[$player->getName()] = $time;
                } else {
                    $player->sendPopup("§cYou can't use the TNT-Launcher for another " . $this->plugin->tntCooldownTime[$player->getName()] . " seconds.");
                }
            } else {
                $player->sendMessage("You don't have permission to use TNT-Launcher!");
            }
        }
    }

    function getPlugin(): CosmeticMenu {
        return $this->plugin;
    }

}