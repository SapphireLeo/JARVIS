<?php
    include "../db_info.php";
?>
<?php
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
?>
<?php
    $ID = addslashes($_POST['ID']);
    $PW1 = addslashes($_POST['password1']);
    $PW2 = addslashes($_POST['password2']);
    $NICKNAME = addslashes($_POST['nickname']);
    $LOCATION_DO = addslashes($_POST['location_do']);
    $LOCATION_CITY = addslashes($_POST['location_city']);
    $BIRTHDAY = $_POST['birthday'];
    
    if($PW1 == $PW2) {
        $sql1 = "SELECT * FROM user WHERE `user_id` = '" . $ID . "'";
        $result1 = sq($sql1);
        $row_count1 = mysqli_num_rows($result1);

        if($row_count1 == 0) {
            $sql2 = "INSERT INTO user(`user_id`, user_pw, nickname, location_do, location_city, birthday) 
            VALUES('".$ID."','".$PW1."','".$NICKNAME."','".$LOCATION_DO."','".$LOCATION_CITY."','". $BIRTHDAY."')";
            $result2 = sq($sql2);
            echo "<script>alert('성공적으로 회원가입되었습니다.');
            location.href='../login/login.html';</script>";
        } else {
            echo "<script>alert('이미 같은 ID로 가입한 유저가 있습니다.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('비밀번호가 서로 다릅니다.'); history.back();</script>";
    }
?>

<script>
</script>