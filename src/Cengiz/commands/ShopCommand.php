<?php

namespace Cengiz\commands;

use pocketmine\{
  player\Player,
  Server,
  command\Command,
  command\CommandSender
};
use Cengiz\forms\ShopMainForm;

class ShopCommand extends Command{
  public function __construct(){
    parent::__construct("market", "Market menüsünü açar", "/market");
  }
  public function execute(CommandSender $player, string $lbl, array $args){
    $player->sendForm(new ShopMainForm($player));
  }
}
