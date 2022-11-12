<?php

namespace Cengiz\forms;

use dktapps\pmforms\FormIcon;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use Cengiz\Shop;

class ShopCategoriesForm extends MenuForm{

    public function __construct($value){
      $this->value = $value;
      $options = [];
        foreach(array_keys(Shop::getConfigs()->get("Kategoriler")[$value]) as $kategoriler){
            if($kategoriler != "Resim") {
                $resim = Shop::getConfigs()->get("Kategoriler")[$value][$kategoriler]["Resim"];
                $options[] = new MenuOption($kategoriler, new FormIcon($resim, FormIcon::IMAGE_TYPE_PATH));
            }
        }

        parent::__construct($value, "", $options, function(Player $player, int $selected) use($value) :void
        {
            $text = $this->getOption($selected)->getText();
            $exp = explode(":", Shop::getConfigs()->get("Kategoriler")[$value][$text]["Item"]);
            $item = ItemFactory::getInstance()->get($exp[0],$exp[1]);
            $price = (int)$exp[2];
            $player->sendForm(new ShopBuyForm($player,$item, $text, $price, $value));
        });
    }
}
