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

        if($following_user != $followed_user){
            $sql = "SELECT `user_id` FROM `user` 
            WHERE `user_id` = '$followed_user'";
            $row_count = mysqli_num_rows(sq($sql));

            if($row_count > 0){ //if there is user
                $sql = "SELECT * FROM follow 
                    WHERE following_user = '$following_user' 
                    AND followed_user = '$followed_user'";
                $row_count = mysqli_num_rows(sq($sql));
                if ($row_count == 0){   // target is not followed yet
                    $sql = "INSERT INTO follow(following_user, followed_user)
                            VALUES('$following_user', '$followed_user')";
                    sq($sql);
                } else {    //already following the target
                    echo "<script> alert('이미 팔로우 중인 유저입니다.');
                    javascript:post_to_url('./profile.php', 
                    {user_id: '$following_user'});</script>";
                }
                echo "<script> alert('해당 ID를 팔로우했습니다.');
                javascript:post_to_url('./profile.php', 
                {user_id: '$following_user'});</script>";
            } else { //if there is no user having target ID
                echo "<script>alert('해당 ID를 보유한 유저가 없습니다.');
                javascript:post_to_url('./profile.php', {user_id: '$following_user'});
                </script>";
            }
        } else{
            echo "<script>alert('자기 자신을 팔로우할 수 없습니다.');
                javascript:post_to_url('./profile.php', {user_id: '$following_user'});
                </script>";
        }
        
        
    ?>
</body>


    
