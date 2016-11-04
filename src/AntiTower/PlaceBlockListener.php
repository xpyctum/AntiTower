<?php
namespace AntiTower;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\math\Vector3;
use pocketmine\block\Air;
use pocketmine\utils\TextFormat;

class PlaceBlockListener implements Listener{
	
	
	protected $plugin;
	
	private $places = [];
	
	public function __construct(AntiTower $plugin){
		$this->plugin = $plugin;
	}
	
	/**
	 * @param BlockPlaceEvent $e
	 * @priority LOWEST
	 */
	public function BlockPlaceEvent(BlockPlaceEvent $e){
		if(!$e->isCancelled()){
            		$id = $e->getBlock()->getID();
			$user = $e->getPlayer()->getDisplayName();
			$x = $e->getBlock()->getX(); $y = $e->getBlock()->getY(); $z = $e->getBlock()->getZ();
			if(!isset($this->places[$user])){
                		/** @array Vector3 */
				$this->places[$user] = array("uses" => 1, "id" => $id, "Loc" => new Vector3($x,$y,$z));
			}else{
				if(!$e->getPlayer()->hasPermission("antitower.admin")){
                    			$max = $this->plugin->getConfig()->get("max-blocks");
                    			$lastid = $this->places[$user]["id"];
                    			$uses = $this->places[$user]["uses"];
                    			$lastY = $this->places[$user]["Loc"]->getY();
                    			if ($lastY == $y - 1) {
                        			if ($id == $lastid) {
                            				if ($uses == $max) {
                               				 	$e->getPlayer()->sendMessage(TextFormat::RED."[AntiTower] You can't build towers!");
                                				$e->getPlayer()->sendMessage(TextFormat::RED."[AntiTower] Removing...");
                                				$level = $e->getBlock()->getLevel();
                                				for ($i = 1; $i <= $max; $i++) {
                                    					$pos = new Vector3($x, $y - $i, $z);
                                    					$outaded = $level->getBlock($pos);
                                    					$e->getPlayer()->getInventory()->addItem($outaded);
                                    					$block = new Air();
                                   					$level->setBlock($pos, $block);
                                				}
                                				$e->setCancelled();
                                				unset($this->places[$user]);
                            				} else {
                                				$this->places[$user]["uses"] = $this->places[$user]["uses"] + 1;
                                				$this->places[$user]["Loc"] = new Vector3($x, $y, $z);
                                				/* $this->plugin->getLogger()->notice(var_dump($this->places[$user]["uses"])); */
                            				}
                       				} else {
                            				unset($this->places[$user]);
                        			}
                    			}
                		}
			}
        	}
    	}
}
