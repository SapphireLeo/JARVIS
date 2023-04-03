<?php
    include "../db_info.php";
?>

<?php
    session_save_path("../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } 
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>JARVIS</title>
        <link rel="stylesheet" href="../css/main.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
        <link rel="stylesheet" href="./board.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
        </script>
    </head>
    <body class="frame">
        <div class="search tema">
            <img src = "../assets/image/search.png">
            <input onkeyup="filter()" type="text" id="searchbox" class="korean" placeholder="글쓴이 또는 제목을 검색하세요.">
        </div>
        <div class="article_list">
            <?php
                $sql = "SELECT message_id, content, nickname, hit, message_time 
                        FROM message NATURAL JOIN `user` NATURAL JOIN follow
                        WHERE following_user = '$ID' 
                        AND followed_user = writer_id
                        AND writer_id = `user_id` 
                        AND parent_message is null 
                        ORDER BY message_time DESC";
                $result1 = sq($sql);
                while($board=mysqli_fetch_array($result1)){
                    $content=$board['content'];
                    $writer=$board['nickname'];
                    $hit=$board['hit'];
                    $time=$board['message_time'];
                    $url="./read/read.php?id=".$board['message_id'];
                    if(strlen($content) > 100){
                        //content가 100자를 넘어가면 ...표시
                        $content=str_replace($board["content"],mb_substr($board["content"],0, 100,"utf-8")."...", $board['content']);
                    }
                ?>
                <p onclick="read_page('<?php echo $url ?>')">
                    <table>
                        <thead>
                            <th> <?php echo $writer ?> </th>
                            <td class="hit text_highlight">
                                <?php echo $hit ?>
                            </td>
                            <td class="time"> <?php echo $time ?> </td>
                        </thead>
                        <tbody>
                            <td colspan="3"> <?php echo $content ?> </td>
                        </tbody>
                    </table>
                </p>
            <?php } ?>
        </div>
    </body>
    <script type="text/javascript">
            function read_page(url){
                parent.read_page(url);
            }
            function filter(){
      
                var searching, name_list, items, i;

                searching = document.getElementById("searchbox").value.toUpperCase();
                item_list = document.getElementsByClassName("item");
                for(var item of item_list){
                    name_list = item.getElementsByClassName("name");
                    if(name_list[0].innerHTML.toUpperCase().indexOf(searching) > -1
                    || name_list[1].innerHTML.toUpperCase().indexOf(searching) > -1){
                        item.style.display = "flex";
                    } else {
                        item.style.display = "none";
                    }
                }
            }
    </script>
</html>
