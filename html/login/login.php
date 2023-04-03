<?php
    include "../db_info.php";
?>

<?php
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
?>

<?php
    $ID = $_POST['ID'];
    $PW = $_POST['password'];
    
    $sql = "SELECT * FROM user WHERE `user_id` = '" . $ID . "' AND user_pw = '" . $PW . "'";
    echo $sql;
    $result = sq($sql);
    $row_count = mysqli_num_rows($result);
    
    if($row_count != 0) {
        session_save_path("../session");
        session_start();
        $session_path = session_save_path().'/sess_'.session_id();
        session_regenerate_id(true);
        $fet=mysqli_fetch_array($result);
        $_SESSION['ID']=$fet['user_id'];
        $_SESSION['PW']=$fet['user_pw'];
        echo "<script>location.href='../board/board.php';</script>";
    } else {
        echo "<script>alert('아이디가 없거나, 비밀번호가 틀립니다.');</script>";
    }
?>

<script>
    history.back();
</script>