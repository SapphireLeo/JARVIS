<?php
    include "../db_info.php";
?>

<head>
	<script type="text/javascript" src="../js/main.js"></script>
</head>
<body>
    <?php
        $following_user = $_POST['following_user'];
        $followed_user = $_POST['followed_user'];
        
        $sql = "SELECT `user_id` FROM `user` 
        WHERE `user_id` = '$followed_user'";
        $row_count = mysqli_num_rows(sq($sql));

        if($row_count > 0){
            $sql = "SELECT * FROM follow 
                WHERE following_user = '$following_user' 
                AND followed_user = '$followed_user'";
            $row_count = mysqli_num_rows(sq($sql));
            if ($row_count == 0){
                $sql = "INSERT INTO follow(following_user, followed_user)
                        VALUES('$following_user', '$followed_user')";
                sq($sql);
            } else {
                $sql = "DELETE FROM follow
                        WHERE following_user='$following_user'
                        AND followed_user='$followed_user'";
                sq($sql);
            }
            echo "<script>
            javascript:post_to_url('./profile.php', 
            {user_id: '$followed_user'});</script>";
        } else {
            echo "<script>alert('해당 유저가 없습니다.');
            javascript:post_to_url('./profile.php', {user_id: '$followed_user'});
            </script>";
        }
    ?>
</body>


    
