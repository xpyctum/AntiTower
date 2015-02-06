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
				$max = $this->plugin->getConfig()->get("max-blocks");
				$lastid = $this->places[$user]["id"];
				$uses = $this->places[$user]["uses"];
				if($id == $lastid){
					if(!$uses > $max){
						$e->getPlayer()->sendMessage("Now, you can't build towers!");
						$level = $e->getLevel();
						$i = 1;
						while($i <= $max){
							$x = $e->getX(); $y = $e->getY(); $z = $e->getZ();
							$pos = new Vector3($x, $y-$i, $z);
							$block = new Air();
							$level->setBlock($pos, $block);
							$i++;
						}
						$e->setCancelled();
					}else{
						$this->places[$user]["uses"]+1;
					}
				}else{
					unset($this->places[$user]);
				}
			}
        }
    }
}