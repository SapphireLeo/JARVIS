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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Read Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/main.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
    <link rel="stylesheet" href="./read.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
    <script type="text/javascript" src="../../js/main.js"></script>
</head>
<body>
    <?php
        $message_id=$_GET['id'];
        $fet=sq("UPDATE message SET hit=hit+1 WHERE message_id='".$message_id."'");
        $result=sq("SELECT writer_id, message_id, nickname, content, hit, message_time FROM message NATURAL JOIN `user` 
                    WHERE `user_id`=`writer_id` AND message_id=$message_id");
        $article=$result->fetch_array();
        $writer_id=$article['writer_id'];
    ?>
    <header>
        <div id="read_title" class="title">Read</div>
        <a class="goto_board" href="../board.php">back to board</a>
    </header>
    <section id="read_wrap" class="wrap">
        <div id="writer">
            <p onclick = "javascript:post_to_url('../../profile/profile.php', {user_id: '<?php echo $article['writer_id'] ?>'})">
                <?php echo $article['nickname'];?>
            </p>
        </div>
        <div id="article">	
            <div id="image">
                <?php
                    $image_query="SELECT image_data FROM images WHERE message_id=$message_id";

                    //이미지를 결과값으로 받아와서 표시, 받아온 결과 이미지가 없을 경우 생략
                    if($image_result=mysqli_fetch_array(sq($image_query))){
                        echo '<img src="data:image/jpeg;base64,'.$image_result['image_data'].'"/>';
                    }
                    echo '<br>';
                ?>
            </div>
            <div id="content">
                <?php echo $article['content']; ?>
            </div>
            <div id="hash_tag">
                <?php 
                    $tag_list=sq("SELECT tag FROM hash_tag WHERE message_id=$message_id");
                    while($tag = $tag_list->fetch_array()){
                        echo "#". $tag['tag'] ." "; 
                    }
                ?>
            </div>
        </div>
        <div id="read_info">
            <?php 
                $result=sq("SELECT count(*) as cc FROM message NATURAL JOIN `user`
                WHERE `user_id`=`writer_id` AND parent_message=$message_id");
                $comment_count = $result->fetch_array()
            ?>
            <div id="comment_count">댓글 <?php echo $comment_count['cc'];?></div>
            <div id="hit_count">조회수  <?php echo $article['hit'];?></div>
            <div id="time_stamp"><?php echo $article['message_time'];?> 작성</div>
            <div id="modify"><a <?php 
                if($ID != $writer_id) echo "style='display:none;' ";
                echo "href=./delete_ok.php?id=$message_id";
            ?>>삭제</a></div>
        </div>
        <div>
            <!-- 댓글 입력창 -->
            <form action="./comment_ok.php?id=<?php echo $message_id;?>" method="POST">
                <input type="text" name="comment_input" id="comment_input" placeholder="댓글을 입력해 주세요.">
                <button class="form_btn" type="submit">댓글 등록</button>
            </form>
        </div>
        <div id="comment_list">
            <?php
                $result=sq("SELECT message_id, nickname, writer_id, content, message_time FROM message NATURAL JOIN `user`
                            WHERE `user_id`=`writer_id` AND parent_message=$message_id ORDER BY message_time DESC");
                while($comments = $result->fetch_array()) {
            ?>
            <table>
                <thead>
                    <th> <?php echo $comments['nickname']; ?> </th>
                    <td> <?php echo $comments['message_time']; ?> </td>
                </thead>
                <tbody>
                    <td colspan="2"> <?php echo nl2br($comments['content']); ?> </td>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </section>
    <footer>
    </footer>
</body>
</html>

<sciprt>
</script>