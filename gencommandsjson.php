<?php

$commands = glob("./commands/*");

$data = [];

foreach($commands as $cmd) {
    $filename = pathinfo($cmd)["basename"];

    $content = explode("\n", file_get_contents("$cmd/main.php"));

    $aliases = explode(";", $content[0]);
    $desc = $content[1];

    $entry = [
        "aliases" => $aliases,
        "description" => $desc,
        "handler" => $filename
    ];

    array_push($data, $entry);
}

file_put_contents("./handlers.json", json_encode($data, JSON_UNESCAPED_UNICODE));

?>
