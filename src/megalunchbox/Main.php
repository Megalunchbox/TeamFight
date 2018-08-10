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
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{

    public $config;

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
            $this->getLogger()->error("[TeamFight] this command does not work in console");
            return true;
        } else {
            $cmdName = $command->getName();
            if (strtolower($cmdName) == strtolower("teamfight") || strtolower($cmdName) == strtolower("tf")) {
                switch (strtolower($args[0])) {
                    case "createmap" :

                        break;

                    case "help":

                        break;

                    case "deletemap" :

                        break;

                    case "start" :

                        break;

                    case "end" :

                        break;

                }
            }
        }
    }


    public function createMap(string $name, float $x, float $y, float $z, float $x2, float $y2, float $z2) {
        if ($this->config instanceof Config) {
            $this->config->setNested($name, array("x1" => $x, "y1" => $y, "z1" => $z, "x2" => $x2, "y2" => $y2, "z2" => $z2));
        }
    }

    public function deleteMap(string $mapName) {

    }

}