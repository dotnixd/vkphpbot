кам;cum
оформить 1ое декабря

<?php

require_once "./library/download.php";

function run($vk, $data) {
    if($img = end($data->object->attachments)) {
        if($img->type == "photo") {
            $size = end($img->photo->sizes);

            $filename = download($size->url, "jpg");
    
            $cum = imagecreatefrompng("./blobs/cum.png");
            $pic = imagecreatefromjpeg($filename);

            $image = imagecreatetruecolor(imagesx($cum), imagesy($cum));
            imagecopyresized($image, $pic, 0, 0, 0, 0, imagesx($cum), imagesy($cum), imagesx($pic), imagesy($pic));
            imagecopyresized($image, $cum, 0, 0, 0, 0, imagesx($cum), imagesy($cum), imagesx($cum), imagesy($cum));
            imagepng($image, $filename, 9);

            $vk->sendImage($data->object->peer_id, $filename, ["message" => "= Ваша пикча ="]);

            unlink($filename);

            return;
        }
    }

    $vk->reply("= Нужно прикрепить пикчу =");
}

?>
