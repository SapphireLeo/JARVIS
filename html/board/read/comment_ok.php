<?php
    include "../../db_info.php";
?>

<?php
    session_save_path("../../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else{
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../../login/login.html'</script>";
    }
?>

<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<?php
    $parent_message_id = $_GET['id'];
    $commenter_id = addslashes($ID);
    $content = htmlspecialchars(addslashes($_POST['comment_input']));
    $timestamp = date("Y-m-d H:i:s",time());
    
    if($parent_message_id && $commenter_id && $content && $timestamp) {
        $sql = "INSERT INTO message(writer_id, content, parent_message, message_time)
                          values('".$commenter_id."','".$content."','".$parent_message_id."','".$timestamp."')";
        $result=sq($sql);

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
                $mention_sql = "SELECT message_id, mentioned_user FROM mention 
                                WHERE message_id = '$parent_message_id'
                                AND mentioned_user = '$mentioned_user'";
                $row_count = mysqli_num_rows(sq($mention_sql));
                if ($row_count == 0){   //not mentioned yet
                    $mention_sql = "INSERT INTO mention(message_id, mentioned_user, mentioned_time)
                    VALUES('$parent_message_id', '$mentioned_user', '$timestamp')";
                    sq($mention_sql);
                }
            }
        }

        echo "<script>
                alert('댓글이 작성되었습니다.'); 
                location.href='./read.php?id=$parent_message_id';
              </script>";
     }else {
        echo "<script>
                alert('댓글 작성에 실패했습니다.'); 
                history.back();
              </script>";
    }
	
?>