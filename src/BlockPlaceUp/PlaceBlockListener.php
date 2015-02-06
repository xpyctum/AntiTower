<?php
namespace BlockPlaceUp;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\Player;

class PlaceBlockListener implements Listener{

	private $plugin;
	private $places = array();
	
	public function __construct(BlockPlaceUp $plugin)
	{
		$this->plugin = $plugin;
	}
	
	/**
	 * @param BlockPlaceEvent $e
	 * @priority HIGHEST
	 */
	public function BlockPlaceEvent(BlockPlaceEvent $e){
		if(!$e->isCancelled()){
            $id = $e->getBlock()->getID();
			$user = $e->getPlayer()->getDisplayName();
			if(!isset($this->places[$user])){
				$this->places[$user] = array("uses" => 1, "id" => $id);
			}else{
				
			}
        }
    }
}