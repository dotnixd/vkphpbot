джобс
перенести вашу пикчу на презентацию Apple

<?php

require_once "./library/download.php";

function run($vk, $data) {
    if($img = end($data->object->attachments)) {
        if($img->type == "photo") {
            $size = end($img->photo->sizes);
            $filename = download($size->url, "jpg");

            $steve = imagecreatefrompng("./blobs/steve.png");
            $out = imagecreatetruecolor(imagesx($steve), imagesy($steve));
            $src = imagecreatefromjpeg($filename);

            imagecopyresized($out, $src, 228, 49, 0, 0, 779, 461, imagesx($src), imagesy($src));
            imagecopy($out, $steve, 0, 0, 0, 0, imagesx($steve), imagesy($steve));

            imagejpeg($out, $filename);

            $vk->sendImage($data->object->peer_id, $filename, ["message" => "= Ваша пикча ="]);

            unlink($filename);
            return;
        }
    }

    $vk->reply("= Нужно прикрепить пикчу =");
}

?>
