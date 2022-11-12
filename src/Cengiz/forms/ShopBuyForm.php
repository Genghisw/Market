<?php

namespace Cengiz\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\element\Label;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use Cengiz\Shop;

class ShopBuyForm extends CustomForm{

    public function __construct(Player $player, $item, string $text, int $price, $value){
     $para = EconomyAPI::getInstance()->myMoney($player);
      $math = floor($para / $price);
        parent::__construct($text, [
            new Label("info","§3Alacağın eşya: §f".$text."\n§3Fiyat: §f".$price." TL\n§3Paran: §f".EconomyAPI::getInstance()->myMoney($player)." TL\n§3Bu eşyadan §f$math §3adet alabilirsin"),
            new Input("input", "Miktar Gir")
        ], function (Player $player, CustomFormResponse $response) use($item,$price,$text):void{
            $input = $response->getString("input");
            if(empty($input)){
                $player->sendMessage("§c » Miktar girin!");
                return;
            }
            if(!is_numeric($input)) {
                $player->sendMessage("§c » Sayısal değer girin!");
                return;
            }

            if((int)$input < 0){
                $player->sendMessage("§c » Sıfırdan büyük sayı girin!");
                return;
            }
            $item->setCount((int)$input);
            if(!$player->getInventory()->canAddItem($item)){
                $player->sendMessage("§c » Envanterinizde yer yok!");
                return;
            }
            $total = (int)$input * $price;
            if(EconomyAPI::getInstance()->myMoney($player) < $total) {
                $playet->sendMessage("§c » Paranız yetersiz!");
                return;
            }
            EconomyAPI::getInstance()->reduceMoney($player, $total);
            $player->getInventory()->addItem($item);
            $player->sendMessage("§3 » §f".$text." §3adlı eşyadan §f".$input." §3adet satın aldın!\nToplam tutar: §f$total");
        });
    }
}
