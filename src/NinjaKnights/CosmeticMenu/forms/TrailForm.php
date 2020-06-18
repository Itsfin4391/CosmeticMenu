<?php

namespace NinjaKnights\CosmeticMenu\forms;

use jojoe77777\FormAPI\SimpleForm;
use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\Player;

class TrailForm {

    private $plugin;

    public function __construct(CosmeticMenu $plugin) {
        $this->plugin = $plugin;
    }

    public function openTrails($player) {
        $form = new SimpleForm(function(Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.trails.flame")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->getMain()->trail1)) {

                            $this->getMain()->trail1[] = $name;

                            if(in_array($name, $this->plugin->trail2)) {
                                unset($this->plugin->trail2[array_search($name, $this->plugin->trail2)]);
                            } elseif(in_array($name, $this->plugin->trail3)) {
                                unset($this->plugin->trail3[array_search($name, $this->plugin->trail3)]);
                            } elseif(in_array($name, $this->plugin->trail4)) {
                                unset($this->plugin->trail4[array_search($name, $this->plugin->trail4)]);
                            }

                        } else {

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
                    }
                    break;

                case 1:
                    if($player->hasPermission("cosmetic.trails.snow")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->plugin->trail2)) {

                            $this->plugin->trail2[] = $name;

                            if(in_array($name, $this->plugin->trail1)) {
                                unset($this->plugin->trail1[array_search($name, $this->plugin->trail1)]);
                            } elseif(in_array($name, $this->plugin->trail3)) {
                                unset($this->plugin->trail3[array_search($name, $this->plugin->trail3)]);
                            } elseif(in_array($name, $this->plugin->trail4)) {
                                unset($this->plugin->trail4[array_search($name, $this->plugin->trail4)]);
                            }

                        } else {

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
                    }
                    break;

                case 2:
                    if($player->hasPermission("cosmetic.trails.heart")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->plugin->trail3)) {

                            $this->plugin->trail3[] = $name;

                            if(in_array($name, $this->plugin->trail1)) {
                                unset($this->plugin->trail1[array_search($name, $this->plugin->trail1)]);
                            } elseif(in_array($name, $this->plugin->trail2)) {
                                unset($this->plugin->trail2[array_search($name, $this->plugin->trail2)]);
                            } elseif(in_array($name, $this->plugin->trail4)) {
                                unset($this->plugin->trail4[array_search($name, $this->plugin->trail4)]);
                            }

                        } else {

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
                    }
                    break;

                case 3:
                    if($player->hasPermission("cosmetic.trails.smoke")) {
                        $name = $player->getName();

                        if(!in_array($name, $this->plugin->trail4)) {

                            $this->plugin->trail4[] = $name;

                            if(in_array($name, $this->plugin->trail1)) {
                                unset($this->plugin->trail1[array_search($name, $this->plugin->trail1)]);
                            } elseif(in_array($name, $this->plugin->trail2)) {
                                unset($this->plugin->trail2[array_search($name, $this->plugin->trail2)]);
                            } elseif(in_array($name, $this->plugin->trail3)) {
                                unset($this->plugin->trail3[array_search($name, $this->plugin->trail3)]);
                            }

                        } else {

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
                    }
                    break;

                case 4:
                    $name = $player->getName();

                    if(in_array($name, $this->plugin->trail1)) {
                        unset($this->plugin->trail1[array_search($name, $this->plugin->trail1)]);
                    } elseif(in_array($name, $this->plugin->trail2)) {
                        unset($this->plugin->trail2[array_search($name, $this->plugin->trail2)]);
                    } elseif(in_array($name, $this->plugin->trail3)) {
                        unset($this->plugin->trail3[array_search($name, $this->plugin->trail3)]);
                    } elseif(in_array($name, $this->plugin->trail4)) {
                        unset($this->plugin->trail4[array_search($name, $this->plugin->trail4)]);
                    }
                    break;

                case 5:
                    $this->getMain()->getForms()->menuForm($player);
                    break;
            }
        });

        $form->setTitle("Trails");
        $form->setContent("Pick One");
        $form->addButton("Flame Trail");
        $form->addButton("Snow Trail");
        $form->addButton("Heart Trail");
        $form->addButton("Smoke Trail");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain(): CosmeticMenu {
        return $this->plugin;
    }

}