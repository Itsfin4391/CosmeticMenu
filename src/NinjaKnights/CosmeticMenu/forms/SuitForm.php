<?php

namespace NinjaKnights\CosmeticMenu\forms;

use jojoe77777\FormAPI\SimpleForm;
use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;

class SuitForm {

    private $plugin;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;
    }

    public function openSuits($player) {
        $form = new SimpleForm(function(Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                //Youtube Suit
                case 0:
                    if($player->hasPermission("cosmetic.suits.youtube")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->getMain()->suit1)) {

                            $player->removeAllEffects();
                            $this->getMain()->suit1[] = $name;

                            if(in_array($name, $this->plugin->suit2)) {
                                unset($this->plugin->suit2[array_search($name, $this->plugin->suit2)]);
                            }

                        } else {

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

                        }

                    }
                    break;
                //Frog Suit
                case 1:
                    if($player->hasPermission("cosmetic.suits.frog")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->getMain()->suit2)) {

                            $player->removeAllEffects();
                            $this->getMain()->suit2[] = $name;

                            if(in_array($name, $this->plugin->suit1)) {
                                unset($this->plugin->suit1[array_search($name, $this->plugin->suit1)]);
                            }

                        } else {

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

                        }

                    }
                    break;

                case 2:
                    $player->removeAllEffects();
                    $armors = [
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR)];
                    $player->getArmorInventory()->setContents($armors);
                    $name = $player->getName();
                    if(in_array($name, $this->plugin->suit1)) {
                        unset($this->plugin->suit1[array_search($name, $this->plugin->suit1)]);
                    } elseif(in_array($name, $this->plugin->suit2)) {
                        unset($this->plugin->suit2[array_search($name, $this->plugin->suit2)]);
                    }
                    break;

                case 3:
                    $this->getMain()->getForms()->menuForm($player);
                    break;
            }
        });
        $form->setTitle("Suits");
        $form->setContent("Pick One");
        $form->addButton("Youtube Suit");
        $form->addButton("Frog Suit");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain(): CosmeticMenu {
        return $this->plugin;
    }


}