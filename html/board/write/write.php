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

<head>
    <meta charset="UTF-8">
    <title>별글</title>
    <link rel="stylesheet" type="text/css" href="./write.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
    <link rel="stylesheet" type="text/css" href="../../css/main.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
</head>
<body>
    <?php
        $fet=mysqli_fetch_array(sq("SELECT nickname FROM `user` WHERE `user_id`='".$ID."'"));
        $writer_nickname=$fet['nickname'];
    ?>
    <header>
        <div id="write_title" class="title">Write</div>
        <a class="goto_board" href="../board.php">back to board</a>
    </header>
    <section id="write_wrap" class="wrap">
        <div id="write_header">
            <p>글 쓰기</p>
            <div><?php echo $writer_nickname;?></div>
        </div>
            <div id="write">
                <form enctype="multipart/form-data" action="write_ok.php" method="post">

                    <!-- 보이지 않게 POST로 작성자의 ID 전달 -->
                    <input type="hidden" name="id" value="<?php echo $ID?>"/>
                    <div id="text_input">
                        <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
                    </div>
                    <div id="hash_tag_input">
                        <p>#해시태그:</p>
                        <input name="hash_tag" placeholder="#해시#태그를#입력하세요">
                    </div>
                    <!-- 사진 업로드 -->
                    <div id="image_input">
                        <input id="upload_name" class="upload_name" placeholder="첨부 사진" disabled>
                        <label for="image_submit">사진 업로드</label>
                        <input id="image_submit" name="image" type="file" onchange="getFileName()"/>
                    </div>
                    <div class="foot">
                        <button class="form_btn" type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer>
    </footer>
    </body>
</html>

<script>
function getFileName() {
    var fileInput = document.getElementById("image_submit");
    for( var i = 0; i < fileInput.files.length; i++ ){
        document.getElementById("upload_name").value
        =fileInput.files[i].name; // 파일명 출력
    }
};
</script>
