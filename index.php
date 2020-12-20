<?php

require_once "vendor/autoload.php";

use DigitalStar\vk_api\vk_api;

$vk = vk_api::create(getenv("TOKEN"), "5.104")->setConfirm(getenv("PHRASE"));
$dat = $vk->initVars();

if(!isset($dat->type)) return;
if($dat->type != "message_new") return;

$cmds = explode(" ", $dat->object->text);
if(count($cmds) == 0) return;

$cmd = substr($cmds[0], 1);

$data = json_decode(file_get_contents("./handlers.json"), true);

foreach($data as $entry) {
    foreach($entry["aliases"] as $alias) {
        if($alias == $cmd) {
            require_once "./commands/$entry[handler]/main.php";

            run($vk, $dat);
        }
    }
}

?>
