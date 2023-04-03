<?php 

$hash_tag = "#yes";
$hash_tag_list = explode("#", $hash_tag);
$index = 0;
foreach($hash_tag_list as $hash){
    if ($hash) echo "/".$hash;
}

?>