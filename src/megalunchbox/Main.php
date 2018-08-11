<?php
/**
 * Created by PhpStorm.
 * User: megal
 * Date: 8/2/2018
 * Time: 3:10 PM
 */

namespace megalunchbox;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{

    public $setPositions = array();
    public $config;
    public $mapsInUse;

    public function onLoad()
    {

    }
    
    public function onEnable()
    {
        mkdir($this->getDataFolder());
        $this->saveResource("maps.yml");
        $this->config = new Config($this->getDataFolder() . "maps.yml", Config::YAML);
    }



    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $this->getLogger()->error("[TF] this command does not work in console");
            return true;
        } else {
            $cmdName = $command->getName();
            if (strtolower($cmdName) == strtolower("teamfight") || strtolower($cmdName) == strtolower("tf")) {
                switch (strtolower($args[0])) {
                    case "createmap" :

                        $pos = $sender->getPosition();

                        if (!isset($this->setPositions[$sender->getName()]["pos1"])) {
                            $sender->sendMessage("[TF] pos1 not set");
                            break;
                        }

                        if (!isset($this->setPositions[$sender->getName()]["pos1"])) {
                            $sender->sendMessage("[TF] pos2 not set");
                            break;
                        }
                        if (!isset($this->setPositions[$sender->getName()]["blueTeamPos"])) {
                            $sender->sendMessage("[TF] blue team spawn is not set");
                            break;
                        }

                        if (!isset($this->setPositions[$sender->getName()]["redTeamPos"])) {
                            $sender->sendMessage("[TF] red team spawn not set");
                            break;
                        }



                        $this->createMap($args[1],
                            $this->setPositions[$sender->getName()]["pos1"]["x"],
                            $this->setPositions[$sender->getName()]["pos1"]["y"],
                            $this->setPositions[$sender->getName()]["pos1"]["z"],
                            $this->setPositions[$sender->getName()]["pos2"]["x"],
                            $this->setPositions[$sender->getName()]["pos2"]["y"],
                            $this->setPositions[$sender->getName()]["pos2"]["z"],
                            $this->setPositions[$sender->getName()]["redTeamPos"],
                            $this->setPositions[$sender->getName()]["blueTeamPos"]
                            );

                        break;

                    case "help":

                        break;

                    case "deletemap" :

                        if (isset($args[1])) {
                            $this->deleteMap($args[1]);
                        }

                        break;

                    case "start" :
                        if ($this->config instanceof Config) {
                            if ($this->config->get($args[1]) != null) {
                                $this->mapsInUse[$args[1]] = true;
                            }
                        }
                        break;

                    case "end" :

                        break;

                    case "pos1" :

                        $this->setPositions[$sender->getName()]["pos1"]["x"] = $sender->getPosition()->x;
                        $this->setPositions[$sender->getName()]["pos1"]["y"] = $sender->getPosition()->y;
                        $this->setPositions[$sender->getName()]["pos1"]["z"] = $sender->getPosition()->z;

                        break;

                    case "pos2" :

                        $this->setPositions[$sender->getName()]["pos2"]["x"] = $sender->getPosition()->x;
                        $this->setPositions[$sender->getName()]["pos2"]["y"] = $sender->getPosition()->y;
                        $this->setPositions[$sender->getName()]["pos2"]["z"] = $sender->getPosition()->z;

                        break;

                    case "spawnpos1" :
                        $this->setPositions[$sender->getName()]["redTeamPos"] = $sender->getPosition();
                        break;

                    case "spawnpos2" :
                        $this->setPositions[$sender->getName()]["blueTeamPos"] = $sender->getPosition();
                        break;
                }
                return true;
            }
        }
    }


    public function createMap(string $mapName, float $x, float $y, float $z, float $x2, float $y2, float $z2, Position $redTeamSpawn, Position $blueTeamSpawn) {
        if ($this->config instanceof Config) {
            $this->config->setNested($mapName, array("x1" => $x, "y1" => $y, "z1" => $z, "x2" => $x2, "y2" => $y2, "z2" => $z2, "redTeamSpawn" => $redTeamSpawn, "blueTeamSpawn" => $blueTeamSpawn));
        }
    }


    public function deleteMap(string $mapName) {
        if ($this->config instanceof Config) {
            $this->config->removeNested($mapName);
        }
    }

    public function startMatch(string $mapName) {

    }

    public function endMatch(string $mapName) {

    }

}