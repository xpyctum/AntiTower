<?php
namespace AntiTower;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\Player;
use pocketmine\level\Level; 
use pocketmine\math\Vector3;
use pocketmine\block\Air;

class PlaceBlockListener implements Listener{

	private $plugin;
	private $places = array();
	
	public function __construct(AntiTower $plugin)
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
			$x = $e->getBlock()->getX(); $y = $e->getBlock()->getY(); $z = $e->getBlock()->getZ();
			if(!isset($this->places[$user])){
				$this->places[$user] = array("uses" => 1, "id" => $id, "Loc" => new Vector3($x,$y,$z));
			}else{
				if($e->getPlayer()->hasPermission("antitower.admin")){
			
				}else{
				$max = $this->plugin->getConfig()->get("max-blocks");
				$lastid = $this->places[$user]["id"];
				$uses = $this->places[$user]["uses"];
				$lastY = $this->places[$user]["Loc"]->getY();
				// $this->plugin->getLogger()->notice(var_dump($lastY));
				// $this->plugin->getLogger()->notice(var_dump($y-1));
				if($lastY == $y-1){
					//$this->plugin->getLogger()->notice(var_dump($lastY));
					if($id == $lastid){
						if($uses == $max){
							$e->getPlayer()->sendMessage("[AntiTower] Now, you can't build towers!");
							$level = $e->getBlock()->getLevel();
							for ($i = 1; $i <= $max; $i++) {
								$pos = new Vector3($x, $y-$i, $z);
								//$this->plugin->getLogger()->notice($i);
								$block = new Air();
								$level->setBlock($pos, $block);
							}
							$e->setCancelled();
							unset($this->places[$user]);
						}else{
							$this->places[$user]["uses"] = $this->places[$user]["uses"]+1;
							$this->places[$user]["Loc"] = new Vector3($x,$y,$z);
							/* $this->plugin->getLogger()->notice(var_dump($this->places[$user]["uses"])); */
						}
					}else{
						unset($this->places[$user]);
					}
				}
				}
			}
        }
    }
}