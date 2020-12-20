<?php

function utf_chunk($text, $len) {
    if(mb_detect_encoding($text) == "UTF-8") {
        return mb_convert_encoding(
                chunk_split(
                    mb_convert_encoding($text, "KOI8-R","UTF-8"), $len, "\n"
                ),
                "UTF-8", "KOI8-R"
            );
    } else {
        return chunk_split($text, $len, "\n");
    }
}

?>