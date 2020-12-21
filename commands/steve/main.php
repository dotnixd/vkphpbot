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
            $src = imagecreatefromjpeg($filename);
            $out = imagecreate(imagesx($src), imagesy($src) + 100);

            imagecopy($out, $src, 0, 0, 0, 0, imagesx($src), imagesy($src));
            imagecopy($out, $steve, intval(imagesx($src) / 3), imagesy($out) - imagesy($steve), 0, 0, imagesx($steve), imagesy($steve));

            imagepng($out, $filename);

            $vk->sendImage($data->object->peer_id, $filename, ["message" => "= Ваша пикча ="]);

            unlink($filename);
            return;
        }
    }


}

?>
