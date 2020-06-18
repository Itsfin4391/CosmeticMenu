<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\inventory\transaction\action\DropItemAction;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;

class EventListener implements Listener {

    private $plugin;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event) {
        if($this->plugin->getCosmeticItemSupport()) {
            $world = $this->plugin->getConfig()->get("WorldName");
            $this->plugin->reloadConfig();

            $player = $event->getPlayer();
            $air = Item::get(0, 0, 1);
            $item = Item::get($this->plugin->getCosmeticItemType());
            $item->setCustomName($this->plugin->getCosmeticName());
            $item->setLore($this->plugin->getCosmeticDes());
            $slot = $this->plugin->getConfig()->getNested("Cosmetic.Slot");
            if($this->plugin->getServer()->getLevelByName($world)) {
                $player->getInventory()->setItem($slot + 1, $air, true);
                $player->getInventory()->setItem($slot, $item, true);
            } else {
                $player->getInventory()->setItem($slot, $item, false);
            }
        }
    }

    public function onRespawn(PlayerRespawnEvent $event) {
        if($this->plugin->getCosmeticItemSupport()) {
            $world = $this->plugin->getConfig()->get("WorldName");
            $this->plugin->reloadConfig();

            $player = $event->getPlayer();
            $air = Item::get(0, 0, 1);
            $item = Item::get($this->plugin->getCosmeticItemType());
            $item->setCustomName($this->plugin->getCosmeticName());
            $item->setLore($this->plugin->getCosmeticDes());
            $slot = $this->plugin->getConfig()->getNested("Cosmetic.Slot");
            if($this->plugin->getServer()->getLevelByName($world)) {
                $player->getInventory()->setItem($slot + 1, $air, true);
                $player->getInventory()->setItem($slot, $item, true);
            } else {
                $player->getInventory()->setItem($slot, $item, false);
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        if($this->plugin->getCosmeticItemSupport()) {
            $item = Item::get($this->plugin->getCosmeticItemType());
            $item->getCustomName($this->plugin->getCosmeticName());
            $item->getLore($this->plugin->getCosmeticDes());
            $player->getInventory()->removeItem($item);
        }
        $name = $player->getName();

        //Suits
        $player->removeAllEffects();
        $armors = [
            ItemFactory::get(Item::AIR),
            ItemFactory::get(Item::AIR),
            ItemFactory::get(Item::AIR),
            ItemFactory::get(Item::AIR)];
        $player->getArmorInventory()->setContents($armors);
        if(in_array($name, $this->plugin->suit1)) {
            unset($this->plugin->suit1[array_search($name, $this->plugin->suit1)]);
        } elseif(in_array($name, $this->plugin->suit2)) {
            unset($this->plugin->suit2[array_search($name, $this->plugin->suit2)]);
        }

        //Particles
        if(in_array($name, $this->plugin->particle1)) {
            unset($this->plugin->particle1[array_search($name, $this->plugin->particle1)]);
        } elseif(in_array($name, $this->plugin->particle2)) {
            unset($this->plugin->particle2[array_search($name, $this->plugin->particle2)]);
        } elseif(in_array($name, $this->plugin->particle3)) {
            unset($this->plugin->particle3[array_search($name, $this->plugin->particle3)]);
        } elseif(in_array($name, $this->plugin->particle4)) {
            unset($this->plugin->particle4[array_search($name, $this->plugin->particle4)]);
        } elseif(in_array($name, $this->plugin->particle5)) {
            unset($this->plugin->particle5[array_search($name, $this->plugin->particle5)]);
        } elseif(in_array($name, $this->plugin->particle6)) {
            unset($this->plugin->particle6[array_search($name, $this->plugin->particle6)]);
        } elseif(in_array($name, $this->plugin->particle7)) {
            unset($this->plugin->particle7[array_search($name, $this->plugin->particle7)]);
        } elseif(in_array($name, $this->plugin->particle8)) {
            unset($this->plugin->particle8[array_search($name, $this->plugin->particle8)]);
        } elseif(in_array($name, $this->plugin->particle9)) {
            unset($this->plugin->particle9[array_search($name, $this->plugin->particle9)]);
        } elseif(in_array($name, $this->plugin->particle10)) {
            unset($this->plugin->particle10[array_search($name, $this->plugin->particle10)]);
        }

        //Trails
        if(in_array($name, $this->plugin->trail1)) {
            unset($this->plugin->trail1[array_search($name, $this->plugin->trail1)]);
        } elseif(in_array($name, $this->plugin->trail2)) {
            unset($this->plugin->trail2[array_search($name, $this->plugin->trail2)]);
        } elseif(in_array($name, $this->plugin->trail3)) {
            unset($this->plugin->trail3[array_search($name, $this->plugin->trail3)]);
        } elseif(in_array($name, $this->plugin->trail4)) {
            unset($this->plugin->trail4[array_search($name, $this->plugin->trail4)]);
        }
    }

    public function onInventoryTransaction(InventoryTransactionEvent $event) {
        if($this->plugin->getCosmeticItemSupport() && $this->plugin->getCosmeticForceSlot()) {
            $transaction = $event->getTransaction();
            foreach($transaction->getActions() as $action) {
                $item = $action->getSourceItem();
                $source = $transaction->getSource();
                if($source instanceof Player && $this->isCosmeticItem($item)) {
                    if($action instanceof SlotChangeAction || $action instanceof DropItemAction) {
                        $event->setCancelled();
                    }
                }
            }
        }
    }

    private function isCosmeticItem(Item $item): bool {
        if($this->plugin->getCosmeticItemSupport()) {
            if($item->getCustomName() == $this->plugin->getCosmeticName() && $item->getId() == $this->plugin->getCosmeticItemType() && $item->getLore() == $this->plugin->getCosmeticDes()) {
                return true;
            }
            $itemName = $item->getCustomName();
            if($itemName == CosmeticMenu::TNTLAUNCHERITEM || $itemName == CosmeticMenu::LIGHTNINGSTICKITEM || $itemName == CosmeticMenu::LEAPER || $itemName == CosmeticMenu::BACKITEM) {
                return true;
            }
        }
        return false;
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $name = $player->getName();
        $iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
        $inv = $player->getInventory();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        if($block->getId() === 0) {
            $player->sendPopup("§cPlease wait");
            return true;
        }

        //Back
        if($iname == CosmeticMenu::BACKITEM) {
            if(!$this->plugin->getCosmeticItemSupport()) {
                foreach($player->getInventory()->getContents() as $item) {
                    if($this->isCosmeticItem($item)) {
                        $player->sendMessage("removing cosmetic items");
                        $player->getInventory()->remove($item);
                    }
                }
                return true;
            }

            $slot = $this->plugin->getConfig()->getNested("Cosmetic.Slot");
            $item = Item::get(0, 0, 1);
            $inv->setItem($slot + 1, $item);

            $item1 = Item::get($this->plugin->getCosmeticItemType());
            $item1->setCustomName($this->plugin->getCosmeticName());
            $item1->setLore($this->plugin->getCosmeticDes());
            $player->getInventory()->setItem($slot, $item1, true);

        }

        if($this->plugin->getCosmeticItemSupport()) {
            if($item->getCustomName() == $this->plugin->getCosmeticName() && $item->getId() == $this->plugin->getCosmeticItemType() && $item->getLore() == $this->plugin->getCosmeticDes()) {
                $this->getMain()->getForms()->menuForm($player);
            }
        }
    }

    function getMain(): CosmeticMenu {
        return $this->plugin;
    }
}