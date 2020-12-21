джобс
перенести вашу пикчу на презентацию Apple

<?php

require_once "./library/hash.php";
require_once "./library/download.php";

function run($vk, $data) {
    if($img = end($data->object->attachments)) {
        if($img->type == "photo") {
            $size = end($img->photo->sizes);
            $filename = download($size->url, "jpg");

            $steve = imagecreatefrompng("./blobs/steve.png");
            $src = imagecreatefromjpeg($filename);
            $out = imagecreatetruecolor(1280, 770);

            imagecopyresized($out, $src, 0, 0, 0, 0, imagesx($src), imagesy($src), 1280, 720);
            imagecopyresized($out, $steve, intval(imagesx($src) / 3), imagesy($out) - imagesy($steve), 0, 0, imagesx($steve), imagesy($steve), imagesx($steve) - 70, imagesy($steve) - 70);

            $hash = generateHash(40) . ".png";

            imagepng($out, $hash);

            $vk->sendImage($data->object->peer_id, $hash, ["message" => "= Ваша пикча ="]);

            unlink($filename);
            unlink($hash);
            return;
        }
    }


}

?>
