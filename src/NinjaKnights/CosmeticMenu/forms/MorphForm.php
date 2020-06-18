<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use jojoe77777\FormAPI\SimpleForm;
use NinjaKnights\CosmeticMenu\CosmeticMenu;
use pocketmine\Player;
use pocketmine\Server;

class MorphForm
{

    private $plugin;

    public function __construct(CosmeticMenu $plugin)
    {
        $this->plugin = $plugin;
    }

    public function openMorphs($player)
    {
        $form = new SimpleForm(function (Player $player, $data) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    if($player->hasPermission("cosmetic.morphs.zombie")){
                        Server::getInstance()->dispatchCommand($player, "morph zombie");
                    }
                break;

                case 1:
                    Server::getInstance()->dispatchCommand($player, "morph remove");
                break;

                case 2:
                    $this->getMain()->getForms()->menuForm($player);    
                break;
            }
        });

        $form->setTitle("Morphs");
        $form->setContent("Pick One");
        $form->addButton("Zombie");
        $form->addButton("Remove");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain(): CosmeticMenu
    {
        return $this->plugin;
    }

}