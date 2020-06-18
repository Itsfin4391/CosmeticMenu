<?php

namespace NinjaKnights\CosmeticMenu;

use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\GadgetsEvents;
use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\TNTLauncher;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\BlizzardAura;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\BloodHelix;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\BulletHelix;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\ConduitHalo;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\CupidsLove;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\EmeraldTwirl;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\FlameRings;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\RainCloud;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\WitchCurse;
use NinjaKnights\CosmeticMenu\cosmetics\Suits\Frog;
use NinjaKnights\CosmeticMenu\cosmetics\Suits\Youtube;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Flames;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Heart;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Smoke;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Snow;
use NinjaKnights\CosmeticMenu\forms\GadgetForm;
use NinjaKnights\CosmeticMenu\forms\MainForm;
use NinjaKnights\CosmeticMenu\forms\MorphForm;
use NinjaKnights\CosmeticMenu\forms\ParticleForm;
use NinjaKnights\CosmeticMenu\forms\SuitForm;
use NinjaKnights\CosmeticMenu\forms\TrailForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class CosmeticMenu extends PluginBase implements Listener {

    public $world;
    public $tntCooldown = [];
    public $tntCooldownTime = [];
    public $lsCooldownTime = [];
    public $lsCooldown = [];
    public $lCooldown = [];
    public $lCooldownTime = [];
    public $particle1 = ["Rain Cloud"];
    public $particle2 = ["Flame Rings"];
    public $particle3 = ["Blizzard Aura"];
    public $particle4 = ["Cupid's Love"];
    public $particle5 = ["Bullet Helix"];
    public $particle6 = ["Conduit Halo"];
    public $particle7 = ["Witch Curse"];
    public $particle8 = ["Blood Helix"];
    public $particle9 = ["Emerald Twril"];
    public $particle10 = ["Test"];
    public $trail1 = ["Flame Trail"];
    public $trail2 = ["Snow Trail"];
    public $trail3 = ["Heart Trail"];
    public $trail4 = ["Smoke Trail "];
    public $suit1 = ["Suit"];
    public $suit2 = ["Suit"];
    /**
     * @var Forms
     */
    private $forms;
    private $gadgets;
    private $particles;
    private $morphs;
    private $trails;
    private $suits;
    /** @var Config */
    private $config;
    /**
     * @var bool
     */
    private $cosmeticItemSupport;
    /**
     * @var string
     */
    private $pluginVersion;
    /**
     * @var mixed|string|string[]|null
     */
    private $cosmeticName;
    /**
     * @var array
     */
    private $cosmeticDes;
    /**
     * @var mixed|null
     */
    private $cosmeticForceSlot;
    /**
     * @var mixed|null
     */
    private $cosmeticItemType;
    /**
     * @var bool
     */
    private $cosmeticCommandSupport;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new GadgetsEvents($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new TNTLauncher($this), $this);
        $this->getScheduler()->scheduleRepeatingTask(new BlizzardAura($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new BloodHelix($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new BulletHelix($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new ConduitHalo($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new CupidsLove($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new EmeraldTwirl($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new FlameRings($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new RainCloud($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new WitchCurse($this), 3);

        $this->getScheduler()->scheduleRepeatingTask(new Flames($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new Snow($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new Heart($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new Smoke($this), 3);

        $this->getScheduler()->scheduleRepeatingTask(new Cooldown($this), 20);

        $this->getScheduler()->scheduleRepeatingTask(new Youtube($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new Frog($this), 3);

        $this->loadPlugins();
        $this->loadFormClass();

        $configPath = $this->getDataFolder() . "config.yml";
        $this->saveDefaultConfig();
        $this->config = new Config($configPath, Config::YAML);
        $this->config->getAll();
        $version = $this->config->get("Version");
        $this->pluginVersion = $this->getDescription()->getVersion();
        if($version < "2.1") {
            $this->getLogger()->warning("You have updated CosmeticMenu to v" . $this->pluginVersion . " but have a config from v$version! Please delete your old config for new features to be enabled and to prevent unwanted errors!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }

        if($this->config->getNested("Cosmetic.Enabled")) {
            $this->cosmeticItemSupport = true;
            $this->cosmeticName = (str_replace("&", "§", $this->config->getNested("Cosmetic.Name")));
            $this->cosmeticDes = [str_replace("&", "§", $this->config->getNested("Cosmetic.Des"))];
            $this->cosmeticItemType = $this->config->getNested("Cosmetic.Item");
            $this->cosmeticForceSlot = $this->config->getNested("Cosmetic.Force-Slot");
        } else {
            $this->cosmeticItemSupport = false;
            $this->getLogger()->info("The Cosmetic Item is disabled in the config.");
        }

        if($this->config->getNested("Command")) {
            $this->cosmeticCommandSupport = true;
        } else {
            $this->cosmeticCommandSupport = false;
            $this->getLogger()->info("The Cosmetic Command is disabled in the config.");
        }
    }

    private function loadPlugins(): void {

    }

    private function loadFormClass(): void {
        $this->forms = new MainForm($this);
        $this->gadgets = new GadgetForm($this);
        $this->particles = new ParticleForm($this);
        $this->morphs = new MorphForm($this);
        $this->trails = new TrailForm($this);
        $this->suits = new SuitForm($this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        switch($cmd->getName()) {
            case "cosmetics":
                if($sender->hasPermission("cosmetic.cmd")) {
                    if($this->cosmeticCommandSupport) {
                        $this->getForms()->menuForm($sender);
                    }
                } else {
                    $sender->sendMessage("You don't have permission to use this command.");
                }
                break;
        }
        return true;
    }

    function getForms(): MainForm {
        return $this->forms;
    }

    function getMain(): CosmeticMenu {
        return $this;
    }

    function getConfig(): Config {
        return $this->config;
    }

    function getGadgets(): GadgetForm {
        return $this->gadgets;
    }

    function getParticles(): ParticleForm {
        return $this->particles;
    }

    function getMorphs(): MorphForm {
        return $this->morphs;
    }

    function getTrails(): TrailForm {
        return $this->trails;
    }

    function getSuits(): SuitForm {
        return $this->suits;
    }

    public function getCosmeticItemSupport(): bool {
        return $this->cosmeticItemSupport;
    }

    /**
     * @return string
     */
    public function getPluginVersion(): string {
        return $this->pluginVersion;
    }

    /**
     * @return string
     */
    public function getCosmeticName(): string {
        return $this->cosmeticName;
    }

    /**
     * @return array
     */
    public function getCosmeticDes(): array {
        return $this->cosmeticDes;
    }

    /**
     * @return int
     */
    public function getCosmeticForceSlot(): int {
        return $this->cosmeticForceSlot;
    }

    /**
     * @return string
     */
    public function getCosmeticItemType(): string {
        return $this->cosmeticItemType;
    }

    /**
     * @return bool
     */
    public function getCosmeticCommandSupport(): bool {
        return $this->cosmeticCommandSupport;
    }


}