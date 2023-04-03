<?php
    include "../db_info.php";
?>

<?php
    session_save_path("../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else{
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../login/login.html'</script>";
    }
?>


<head>
    <meta charset="utf-8">
    <title>JARVIS</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
    <link rel="stylesheet" href="./board.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
    <script type="text/javascript" src="../js/main.js">
    </script>
</head>
<body>
    <header>
        <h1 id = "board_title" class = "title">Articles</h1>
        <?php
            $sql = "SELECT nickname FROM `user` WHERE `user_id` = '".$ID."'";
            $result = sq($sql);
            $user_info=mysqli_fetch_array($result);
            $mynick = $user_info['nickname'];

            $sql = "SELECT image_data FROM profile_images WHERE `user_id`='".$ID."'";
            $result = sq($sql);
            $row_count = mysqli_num_rows($result);
            $user_image = null;
            if ($row_count == 1){ 
                $user_image=mysqli_fetch_array($result);
            }
        ?>
        <div id = "profile" onclick = "javascript:post_to_url('../profile/profile.php', {user_id: '<?php echo $ID ?>'})">
            <p>
                <?php echo $mynick; ?>
            </p>
            <img style="cursor:pointer" src = "
                <?php 
                    # if there is a profile image
                    if ($user_image != null){
                        echo 'data:image/jpeg;base64,'.$user_image['image_data'];
                    } else {    # if there is no profile image
                        echo '../assets/image/user.png';
                    }
                ?>
            "/>
        </div>
    </header>
    <section id="board_wrap" class="wrap">
        <p class="menubar">
            <a href="./board_recent.php" target="board_frame">recent</a>
            <a href="./board_following.php" target="board_frame">following</a>
            <a href="./board_mentioned.php" target="board_frame">mentioned</a>
        </p>
        <iframe src="./board_recent.php" title="articles" name="board_frame"></iframe>
        
        </div>
    </section>
    <footer>
        <div>
            <input class = "form_btn bg_gray"  type ='button' value = 'Sign off' style="float: left;" onclick="location.href='../logout/logout.php'">
            <input class = "form_btn bg_tema1" type ='button' value = 'Write' style="float:right" onclick="location.href='./write/write.php'">
        </div>
    </footer>
    
</body>
<script>
    function read_page(url){
            location.href=url;
    }
</script>
