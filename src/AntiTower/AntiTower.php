<?php
namespace AntiTower;

use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;



class AntiTower extends PluginBase{

	private $config, $plugin;
	
	public function onLoad()
	{
		$this->saveDefaultConfig();
	}
	public function onEnable()
	{
		$this->saveResource("config.yml");
		$blocks = $this->getConfig()->get("max-blocks");
		if(!is_numeric($blocks)){
			$this->getServer()->shutdown();
		}
		$this->getServer()->getPluginManager()->registerEvents(new PlaceBlockListener($this), $this);
	}
	
	public function onDisable(){
		
	}
}