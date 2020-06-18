<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\scheduler\Task;

class Cooldown extends Task
{

    private $plugin;

    public function __construct(CosmeticMenu $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun($tick)
    {
        foreach ($this->plugin->tntCooldown as $player) {
            if ($this->plugin->tntCooldownTime[$player] <= 0) {
                unset($this->plugin->tntCooldown[$player]);
                unset($this->plugin->tntCooldownTime[$player]);
            } else {
                $this->plugin->tntCooldownTime[$player]--;
            }
        }
        foreach ($this->plugin->lsCooldown as $player) {
            if ($this->plugin->lsCooldownTime[$player] <= 0) {
                unset($this->plugin->lsCooldown[$player]);
                unset($this->plugin->lsCooldownTime[$player]);
            } else {
                $this->plugin->lsCooldownTime[$player]--;
            }
        }
        foreach ($this->plugin->lCooldown as $player) {
            if ($this->plugin->lCooldownTime[$player] <= 0) {
                unset($this->plugin->lCooldown[$player]);
                unset($this->plugin->lCooldownTime[$player]);
            } else {
                $this->plugin->lCooldownTime[$player]--;
            }
        }
    }

    function getMain(): CosmeticMenu
    {
        return $this->plugin;
    }
}