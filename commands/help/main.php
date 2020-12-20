хелп;помощь
получить список команд

<?php

function run($vk, $data) {
    $message = "= Список команд =";

    $data = json_decode(file_get_contents("./handlers.json"), true);

    foreach($data as $entry) {
        if($entry["handler"] == "help") continue;

        $message .= "\n= " . implode(", ", $entry["aliases"]) . " - " . $entry["description"] . " =";
    }

    $message .= "\n\n= Вы можете использовать команду \"/справка <команда>\", если вы не понимаете, как использовать ту или иную команду =";

    $vk->reply($message);
}

?>
