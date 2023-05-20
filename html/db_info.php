<?php
    $db = new mysqli("localhost", "jarvis", "database#6", "jarvis");

    function sq($query) {
        global $db;
        return $db->query($query);
    }
?>