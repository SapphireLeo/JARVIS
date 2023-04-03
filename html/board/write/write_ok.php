<?php
    include "../../db_info.php";
?>
<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>

<?php
    
    function image_upload($message_id){
        /*** check if a file was uploaded ***/
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];
            $sql = "INSERT INTO images(image_type, image_data, message_id) VALUES('".$imgType."', '".base64_encode($imgData)."', '".$message_id."')";
            echo sq($sql);
        }
    }
    
?>

<?php
    $ID = addslashes($_POST['id']);
    $content = addslashes($_POST['content']);
    $hash_tag = addslashes($_POST['hash_tag']);
    $timestamp = date("Y-m-d H:i:s",time());

    $hash_tag_list = explode("#", $hash_tag);
    
    if($ID && $content){
        //message insert
        $result=sq("INSERT INTO `message`(writer_id, content, message_time) values('".$ID."','".$content."', '".$timestamp."')");
        $last_insert_id=$db->insert_id;

        //images insert
        image_upload($last_insert_id);

        //hastag insert
        foreach($hash_tag_list as $tag){
            if ($tag) {
                $result=sq("SELECT * from hash_tag 
                            WHERE message_id = '$last_insert_id' AND tag = '$tag'");
                $row_count = mysqli_num_rows($result);
                if ($row_count==0){
                    $sql = "INSERT INTO hash_tag(message_id, tag) values('".$last_insert_id."','".$tag."')";
                    $result = sq($sql);
                }
            }
        }

        //mention insert
        $sql = "SELECT followed_user, nickname FROM follow NATURAL JOIN `user`
                WHERE following_user = '$ID' 
                AND followed_user = `user_id`";
        $result=sq($sql);
        while($friend=mysqli_fetch_array($result)){
            $mentioned_user = $friend['followed_user'];
            $search_str = "@".$friend['nickname'];
            $content = "_".$content;
            if(strpos($content, $search_str)){
                $mention_sql = "INSERT INTO mention(message_id, mentioned_user, mentioned_time)
                VALUES('$last_insert_id', '$mentioned_user', '$timestamp')";
                sq($mention_sql);
            }
        }

        

        echo "<script>
                alert('글쓰기 완료되었습니다.');
                location.href='../board.php';
            </script>";
    }else{
        echo "<script>
                alert('글쓰기에 실패했습니다.');
                history.back();
            </script>";
    }

    
?>

