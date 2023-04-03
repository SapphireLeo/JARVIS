<?php
    include "../db_info.php";
?>
<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>

<?php
    
    function image_upload($user_id){
        $sql = "SELECT `user_id` FROM profile_images WHERE `user_id` = '$user_id'";
        $row_count = mysqli_num_rows(sq($sql));
        /*** check if a file was uploaded ***/
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imgData = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
            $imgType = $_FILES['image']['type'];
            if($row_count == 0){
                $sql = "INSERT INTO profile_images(image_type, image_data, `user_id`) 
                        VALUES('$imgType', '$imgData', '$user_id')";
                sq($sql);
            } else {
                $sql = "UPDATE profile_images 
                        SET image_type = '$imgType', image_data = '$imgData'
                        WHERE `user_id` = '$user_id'";
                sq($sql);
            }
        }
    }
    
?>
<html>
    <head>
        <script type="text/javascript" src="../js/main.js"></script>
    </head>
    <body>
        <?php
            $ID = addslashes($_POST['ID']);
            $nickname = addslashes($_POST['nickname']);
            $password = addslashes($_POST['password']);
            $belong = addslashes($_POST['belong']);
            $location_do = addslashes($_POST['location_do']);
            $location_city = addslashes($_POST['location_city']);
            $birthday = addslashes($_POST['birthday']);
            $introduce = addslashes($_POST['introduce']);

            $query_array= array();

            if($nickname){
                $query_array[0] = "nickname = '$nickname'";
            }
            if($password){
                $query_array[1] = "user_pw = '$password'";
            }
            if($belong){
                $query_array[2] = "belong = '$belong'";
            }
            if($location_do){
                $query_array[3] = "location_do = '$location_do'";
            }
            if($location_city){
                $query_array[4] = "location_city = '$location_city'";
            }
            if($birthday){
                $query_array[5] = "birthday = '$birthday'";
            }
            if($introduce){
                $query_array[6] = "introduce = '$introduce'";
            }
            $joined_query = join(",", $query_array);

            image_upload($ID);
            if($joined_query){
                $sql = "UPDATE `user` SET $joined_query WHERE user_id = '".$ID."'";
                $result=sq($sql);
                echo "<script>
                        alert('성공적으로 정보가 수정되었습니다.');
                        javascript:post_to_url('./profile.php', {user_id: '$ID'});
                    </script>";
            }
        ?>
    </body>
</html>


