<?php
namespace AntiTower;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;


class AntiTower extends PluginBase{

	private $config;
    /* @var $plugin */
    private $plugin;
	
	public function onLoad()
	{
		$this->saveDefaultConfig();
	}
	public function onEnable()
	{
		$this->saveResource("config.yml");
		$blocks = $this->getConfig()->get("max-blocks");
		if(!is_numeric($blocks)){
            if (empty($this->getConfig()->get("max-blocks"))) {
                $this->getConfig()->set("max-blocks")[5];
            }
		}
		$this->getServer()->getPluginManager()->registerEvents(new PlaceBlockListener($this), $this);
	}
	
	public function onDisable(){
		
	}

    /**
     * @return Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
