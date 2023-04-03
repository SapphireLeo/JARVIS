<?php
    include "../../db_info.php";
?>

<?php
    session_save_path("../../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else {
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../../login/login.html'</script>";
    }
?>

<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<?php
    $message_id = $_GET['id'];
    
    if($message_id) {
        $sql = "DELETE FROM `message`
                WHERE message_id = '$message_id' 
                OR parent_message = '$message_id'";
        $result=sq($sql);
        echo "<script>
                alert('글이 성공적으로 삭제되었습니다.'); 
                location.href='../board.php';
              </script>";
     }else {
        echo "<script>
                alert('글 삭제에 실패했습니다.'); 
                history.back();
              </script>";
    }
	
?>