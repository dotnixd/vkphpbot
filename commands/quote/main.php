цитата
сгенерировать цитату из пересланных сообщений

<?php

require_once "./library/hash.php";
require_once "./library/download.php";

function run($vk, $data) {

    $msgs = [];

    if($data->object->reply_message) {
        $msgs = [$data->object->reply_message];
    } elseif($data->object->fwd_messages) {
        $msgs = $data->object->fwd_messages;
    } else {
        $vk->reply("= Нужно переслать сообщения =");

        return;
    }

    $id = $msgs[0]->from_id;
    if($id < 0) {
        $vk->reply("= Цитирование сообщений групп невозможно =");

        return;
    }

    $text = "";

    foreach($msgs as $m) {
        $text .= chunk_split($m->text, 32) . "\n";
    }

    $user = $vk->userInfo($id, ["fields" => "photo_200"]);
    $fnameava = download($user["photo_200"], "jpg");

    $font = "./blobs/font.ttf";

    $ava = imagecreatefromjpeg($fnameava);
    $quote = imagecreatefrompng("./blobs/quote.png");

    $color = imagecolorallocate($quote, 255, 255, 255);

    imagecopy($quote, $ava, 120, 240, 0, 0, 200, 200);
    imagettftext($quote, 30, 0, 370, 350, $color, $font, $text);

    date_default_timezone_set("Europe/Moscow");
    imagettftext($quote, 20, 0, 120, 680, $color, $font, "(c) $user[first_name] $user[last_name], " . date("Y-m-d H:i:s"));

    $filename = generateHash(40) . ".png";

    imagepng($quote, $filename);
    $vk->sendImage($data->object->peer_id, $filename, ["message" => "= Ваша цитата ="]);

    unlink($filename);
    unlink($fnameava);
}

?>