<?php
namespace AntiTower;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;


class AntiTower extends PluginBase{
	
    	public function onEnable(){
		$this->saveResource("config.yml");
		$this->getServer()->getPluginManager()->registerEvents(new PlaceBlockListener($this), $this);
        	$this->getLogger()->info(TextFormat::GREEN."- AntiTower Loaded !");
	}
	
	public function onDisable(){
        	$this->getLogger()->info(TextFormat::RED."- AntiTower Disabled !");
	}
	
}
