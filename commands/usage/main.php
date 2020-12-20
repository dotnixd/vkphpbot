справка;использование
информация об использовании той или иной команды

<?php

function run($vk, $data) {
    $toks = explode(" ", $data->object->text);
    if(count($toks) < 2) {
        $vk->reply("= Недостаточно аргументов. Использование: \"/справка <команда>\" =");
        return;
    }

    $dat = json_decode(file_get_contents("./handlers.json"), true);

    $h = "";

    foreach($dat as $entry) {
        foreach($entry["aliases"] as $alias) {
            if($alias == $toks[1]) {
                $h = $entry["handler"];
            }
        }
    }

    if(!$h) {
        $vk->reply("= Такой команды не существует =");
        return;
    }

    $vk->sendImage($data->object->peer_id, "./usages/$h.png", ["message" => "= Использование команды \"/$toks[1]\": ="]);
}

?>
