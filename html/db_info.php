<?php
    $db = new mysqli("localhost", "bookswap", "sweteam#6", "bookswap");

    function sq($query) {
        global $db;
        return $db->query($query);
    }
?>