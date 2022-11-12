<?php

namespace Cengiz;

use pocketmine\{
  player\Player,
  Server,
  utils\Config,
  plugin\PluginBase
};
use Cengiz\commands\ShopCommand;

class Shop extends PluginBase{

    public static Config $cfg;
    public static Shop $shop;
    public function onLoad():void{
      self::$shop = $this;
      $this->saveResource("market.yml");
      @mkdir($this->getDataFolder());
      @mkdir($this->getDataFolder()."market.yml");
      self::$cfg = new Config($this->getDataFolder() . "market.yml", Config::YAML);
    }
    public function onEnable():void{
        $this->getLogger()->info("Market aktif");
        $this->getServer()->getCommandMap()->register("market", new ShopCommand($this));
    }
    public static function getInstance():?Shop{
      return self::$shop;
    }
    public static function getConfigs():?Config{
        return self::$cfg;
    }
}
