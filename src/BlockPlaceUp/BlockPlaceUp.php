<?php
namespace BlockPlaceUp;

use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;

class BlockPlaceUp extends PluginBase{

	private $config, $plugin, $factionsPro;
	
	public function onLoad()
	{
		$this->saveDefaultConfig();
	}
	public function onEnable()
	{
		$blocks = $this->getConfig()->get("max-blocks");
		if(!is_numeric($blocks)){
			$this->getServer()->shutdown();
		}
		$this->getServer()->getPluginManager()->registerEvents(new PlaceBlockListener($this), $this);
	}
	
	public function onDisable(){
		
	}
}