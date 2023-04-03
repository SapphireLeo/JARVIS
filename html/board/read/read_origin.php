<?php
    include "../db_info.php";
?>
<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
	<link rel="stylesheet" type="text/css" href="./css/read.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
</head>
<body>
	<?php
		$bno = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
		$hit = mysqli_fetch_array(sq("select * from board where idx ='".$bno."'"));
		$hit = $hit['hit'] + 1;
		$fet = sq("update board set hit = '".$hit."' where idx = '".$bno."'");
		$sql = sq("select * from board where idx='".$bno."'"); /* 받아온 idx값을 선택 */
		$board = $sql->fetch_array();
	?>
<!-- 글 불러오기 -->
<div id="board_read">
	<h2>
		<?php echo $board['title']; ?>
	</h2>
	<hr>
		<div id="user_info">
			<?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회:<?php echo $board['hit']; ?>
				<div id="bo_line"></div>
			</div>
			<div id="bo_content">
				<?php echo nl2br("$board[content]"); ?>
			</div>
</div>
	<!-- 목록, 수정, 삭제 -->
	<div id="bo_ser">
		<ul>
			<li><a href="../index.php">[목록으로]</a></li>
			<!-- <li><a href="modify.php?idx=<?php // echo $board['idx']; ?>">[수정]</a></li> -->
			<!-- <li><a href="delete.php?idx=<?php // echo $board['idx']; ?>">[삭제]</a></li> -->
		</ul>
	</div>
<!--- 댓글 불러오기 -->
<div class="reply_view">
	<h3>댓글목록</h3>
		<?php
			$sql3 = sq("select * from reply where con_num='".$bno."' order by idx desc");
			while($reply = $sql3->fetch_array()) { 
		?>
		<div class="dap_lo">
			<div>
				<b><?php echo $reply['name'];?></b>
			</div>
				<div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
				<div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
				<div class="rep_me rep_menu"></div>
		</div>
	<?php } ?>

	<!--- 댓글 입력 폼 -->
	<div class="dap_ins">
		<form action="reply_ok.php?idx=<?php echo $bno; ?>" method="POST">
			<input type="text" name="dat_user" id="dat_user" class="dat_user" size="15" placeholder="아이디">
			<input type="password" name="dat_pw" id="dat_pw" class="dat_pw" size="15" placeholder="비밀번호">
			<div style="margin-top:10px; ">
				<textarea name="content" class="reply_content" id="re_content" ></textarea>
				<button id="rep_bt" class="re_bt">댓글</button>
			</div>
		</form>
	</div>
</div><!--- 댓글 불러오기 끝 -->
<div id="foot_box"></div>
</div>
</body>
</html>