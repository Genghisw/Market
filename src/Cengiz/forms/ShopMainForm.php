<?php

namespace Cengiz\forms;

use dktapps\pmforms\FormIcon;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\player\Player;
use Cengiz\Shop;

class ShopMainForm extends MenuForm{

    public function __construct(){
        $options = [];
        
        foreach(array_keys(Shop::getConfigs()->get("Kategoriler")) as $value) {
            $resim = Shop::getConfigs()->get("Kategoriler")[$value]["Resim"];
            $options[] = new MenuOption($value, new FormIcon($resim, FormIcon::IMAGE_TYPE_PATH));
        }

        parent::__construct("Market","",$options, 
  function(Player $player, int $selected):void{
            $text = $this->getOption($selected)->getText();
            $player->sendForm(new ShopCategoriesForm($text,$player));
        });
    }
}
