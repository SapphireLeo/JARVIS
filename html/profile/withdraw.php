<?php
    include "../db_info.php";
?>

<?php
    session_save_path("../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else {
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../login/login.html'</script>";
    }
?>

<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>

<?php
    if($ID) {
        $sql = "DELETE FROM `user`
                WHERE `user_id` = '$ID'";
        $result=sq($sql);
        echo "<script>
                alert('회원 탈퇴에 성공했습니다.'); 
                location.href='../logout/logout.php';
              </script>";
     }else {
        echo "<script>
                alert('회원 탈퇴에 실패했습니다.'); 
                history.back();
              </script>";
    }
	
?>