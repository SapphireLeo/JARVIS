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
	$user_id = $_POST['user_id'];

	$default_user_image_url = '../assets/image/user.png';
?>

<html>
	<head>
		<title>Profile</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css?v=<?php echo date("Y-m-d H:i:s",time());?>" />
		<script type="text/javascript" src="../js/main.js">
			
		</script>
	</head>
	<body class="is-preload">
		<?php
			$sql = "SELECT * FROM `user` WHERE `user_id` = '".$user_id."'";
            $result = sq($sql);
            $user_info=mysqli_fetch_array($result);
            $nickname = $user_info['nickname'];
			$password = $user_info['user_pw'];
			$birthday = $user_info['birthday'];
			$location_do = $user_info['location_do'];
			$location_city = $user_info['location_city'];
			$belong = $user_info['belong'];
			$introduce = $user_info['introduce'];
			if ($introduce == null){
				$introduce = "";
			}
		?>

			<nav id="nav">
				<div onclick="location.href='../board/board.php'">go to board</div>
			</nav>

			<article id="top" class="wrapper style1">
				<div class="container">
					<div class="row">
						<div class="col-4 col-5-large col-12-medium">
							<span class="image fit"><img src="
								<?php 
									$image_query = "SELECT image_data FROM profile_images WHERE `user_id`='$user_id'";
									# if there is a profile image
									if ($image_result=mysqli_fetch_array(sq($image_query))){
										echo 'data:image/jpeg;base64,'.$image_result['image_data'];
									} else {    # if there is no profile image
										echo $default_user_image_url;
									}
								?>
							"/></span>
						</div>
						<div class="col-8 col-7-large col-12-medium">
							<header>
								<h1><?php echo $nickname; ?></h1>
							</header>
							<p><?php 
									if ($introduce == ""){
										echo "There is no introducory.";
									} else {
										echo $introduce;
									}?>
									</p>
							<a class="button large scrolly" id="change_btn"
								<?php 
									if ($ID != $user_id) echo 
									"onclick='javascript:post_to_url
									(\"./follow.php\", {following_user: \"$ID\", followed_user: \"$user_id\"});'";
									else echo 
									"";
								?>>	
								<?php
									if ($ID == $user_id){
										echo 'change my profile';
									} else {
										$sql = "SELECT * FROM follow 
												WHERE following_user='$ID' AND followed_user = '$user_id'";
										$result = sq($sql);
										$row_count = mysqli_num_rows($result);
										if ($row_count == 0){
											echo 'follow this user';
										} else {
											echo 'unfollow this user';
										}
									}
								?>
							</a>
						</div>
					</div>
				</div>
			</article>

			<article id="work" class="wrapper style2" style="
			<?php if ($ID != $user_id){ echo 'display:none';}?>">
				<div class="container">
					<header>
						<h2>Profile</h2>
					</header>
					<div class="row aln-center">
						<div class="col-12">
							<form method="post" action="profile_update.php" enctype="multipart/form-data">
								<div class="row">
									<input type="hidden" name="ID" id="ID" value="<?php echo $ID;?>" />
									<div class="col-2 col-12-small">
										<p class="style">Nickname</p>
									</div>
									<div class="col-4 col-12-small">
										<input type="text" name="nickname" id="nickname" class="profile" value="<?php echo $nickname;?>" readonly/>
									</div>
									<div class="col-2 col-12-small">
										<p class="style">Password</p>
									</div>
									<div class="col-4 col-12-small">
										<input type="password" name="password" id="password" class="profile" value="<?php echo $password;?>" readonly/>
									</div>
									<div class="col-2 col-12-small">
										<p class="style">Belong to</p>
									</div>
                                    <div class="col-2 col-12-small">
										<input type="text" name="belong" id="belong" class="profile" value="<?php echo $belong;?>" readonly/>
									</div>
									<div class="col-2 col-12-small">
										<p class="style">location</p>
									</div>
									<div class="col-2 col-12-small">
										<input type="text" name="location_do" id="location_do" class="profile" value="<?php echo $location_do;?>" readonly/>
									</div>
									<div class="col-1 col-12-small">
										<p class="style">do</p>
									</div>
									<div class="col-2 col-12-small">
										<input type="text" name="location_city" id="location_city" class="profile" value="<?php echo $location_city;?>" readonly/>
									</div>
									<div class="col-1 col-12-small">
										<p class="style">city</p>
									</div>
									<div class="col-2 col-12-small">
										<p class="style">Birthday</p>
									</div>
									<div class="col-4 col-12-small">
										<input type="date" name="birthday" id="birthday" class = "profile korean" class="profile" value="<?php echo $birthday?>" readonly/>
									</div>
									<div class="col-6 image_input">
										<input id="upload_name" class="upload_name" placeholder="프로필 사진" disabled>
										<label for="image_submit">사진 업로드</label>
										<input id="image_submit" name="image" type="file" onchange="getFileName()"/>
									</div>
									<div class="col-12">
										<textarea name="introduce" id="introduce" class = "korean profile" value="<?php echo $introduce?>" readonly></textarea>
									</div> 
									<div class="col-12">
										<ul class="actions">
											<li class="apply"><input type="submit" value="Apply" /></li>
											<li class="withdraw"><a href="./withdraw.php?id=<?php echo $ID ?>">Withdraw</a></li>
										</ul>
									</div>
								</div>
							</form>
						</div>
					<footer>
					</footer>
				</div>
			</article>

			<article id="portfolio" class="wrapper style3">
				<?php
					$sql = "SELECT message_id, content FROM `message` 
							WHERE writer_id = '$user_id' AND parent_message is null
							ORDER BY message_time DESC";
					$result = sq($sql);
				?>
				<div class="container">
					<header>
						<h2>Activity</h2>
					</header>
					<div class="row">
						<?php 
							while($article=mysqli_fetch_array($result)) {
								$message_id=$article['message_id'];
								$content=$article['content'];
								$url = "../board/read/read.php?id=".$message_id;
						?>
						<div class="col-4 col-6-medium col-12-small">
							<article class="box style2">
								<a href=<?php echo $url ?> class="image featured"><img src="
								<?php
									$image_query="SELECT image_data FROM images WHERE message_id=$message_id";
									//이미지를 결과값으로 받아와서 표시, 받아온 결과 이미지가 없을 경우 기본 이미지 출력
									if($image_result=mysqli_fetch_array(sq($image_query))){
										echo "data:image/jpeg;base64,".$image_result['image_data'];
									}else {
										echo 'images/pic03.jpg';
									}
								?>"/></a>
								<h3><a href=<?php echo $url ?>>
									<?php 
										if(strlen($content) > 100){
											//content가 30자를 넘어가면 ...표시
											$content=str_replace($content,mb_substr($content,0, 30,"utf-8")."...", $content);
										}
										echo $content 
									?>
								</a></h3>
								<p>
									<?php 
										$tag_list=sq("SELECT tag FROM hash_tag WHERE message_id=$message_id");
										while($tag = $tag_list->fetch_array()){
											echo "#". $tag['tag'] ." "; 
										}
									?>
								</p>
							</article>
						</div>
						<?php } ?>
					</div>
					<footer>
					</footer>
				</div>
			</article>

			<article id="contact" class="wrapper style4" style="
			<?php if ($ID != $user_id){ echo 'display:none';}?>">
				<div class="container medium">
					<header>
						<h2>Follow</h2>
					</header>
					<?php 
						$sql = "SELECT followed_user, nickname FROM follow NATURAL JOIN `user`
								WHERE following_user = '$user_id'
								AND followed_user = `user_id`";
						$result = sq($sql);
					?>
					<div class="row aln-center">
						<div class="col-12">
							<div class="row aln-center">
								<?php 
									while($follow=mysqli_fetch_array($result)) {
										$followed_user=$follow['followed_user'];
										$followed_user_nickname=$follow['nickname'];
								?>
								<div class="col-4 col-6-medium col-12-small"
									onclick="javascript:post_to_url('../profile/profile.php', {user_id: '<?php echo $followed_user ?>'})"
									style="cursor:pointer;z-index:5;">
									<section class="box style1">
										<img src="
											<?php
												$image_query="SELECT image_data FROM profile_images WHERE `user_id`='$followed_user'";
												//이미지를 결과값으로 받아와서 표시, 받아온 결과 이미지가 없을 경우 기본 이미지 출력
												if($image_result=mysqli_fetch_array(sq($image_query))){
													echo "data:image/jpeg;base64,".$image_result['image_data'];
												}
												else echo $default_user_image_url;
											?>
										" class = "friend_img"></span>
										<h3>
											<?php echo $followed_user_nickname ?>
										</h3>
									</section>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<footer>
					</footer>
				</div>
			</article>

			<article id="contact" class="wrapper style4" style="
			<?php if ($ID != $user_id){ echo 'display:none';}?>">
				<div class="container medium">
					<header>
						<h2>You might know</h2>
					</header>
					<?php 
						$sql = "SELECT `user_id`, nickname FROM `user`
								WHERE belong = '$belong'
								AND `user_id` != '$ID'
								OR location_city = '$location_city'
								AND `user_id` != '$ID'
									EXCEPT
								SELECT `user_id`, nickname FROM `user` NATURAL JOIN follow
								WHERE `user_id` = followed_user
								AND following_user = '$ID'";
						$result = sq($sql);
					?>
					<div class="row aln-center">
						<div class="col-12">
							<div class="row aln-center">
								<?php 
									while($users=mysqli_fetch_array($result)) {
										$p_friend=$users['user_id'];
										$p_friend_nickname=$users['nickname'];
								?>
								<div class="col-4 col-6-medium col-12-small"
									onclick="javascript:post_to_url('../profile/profile.php', {user_id: '<?php echo $p_friend ?>'})"
									style="cursor:pointer;z-index:5;">
									<section class="box style1">
										<img src="
											<?php
												$image_query="SELECT image_data FROM profile_images WHERE `user_id`='$p_friend'";
												//이미지를 결과값으로 받아와서 표시, 받아온 결과 이미지가 없을 경우 기본 이미지 출력
												if($image_result=mysqli_fetch_array(sq($image_query))){
													echo "data:image/jpeg;base64,".$image_result['image_data'];
												}
												else echo $default_user_image_url;
											?>
										" class = "friend_img"></span>
										<h3>
											<?php echo $p_friend_nickname ?>
										</h3>
									</section>
								</div>
								<?php } ?>
							</div>

							<div class="row aln-center" style="margin:auto; margin-top: 2em;">
							<form id="follow_by_id" method="post" action="follow_by_id.php" style="padding:0px;">
								<div class="col-6 col-12-small">
									<input type="hidden" name="following_user" value="<?php echo $ID;?>" />
									<input type="text" name="followed_user" id="user_id" placeholder="ID here"/>
									<input type="submit" name="submit_btn" id="submit_btn" value="< Follow"/>
								</div>
							</div>
						</div>
					</div>
					<footer>
						<ul id="copyright">
							<li>&copy; All rights reserved.</li><li>Design: JARVIS</a></li>
						</ul>
					</footer>
				</div>
			</article>
	</body>
	<script>
		function profile_change_mode(event) {
			
			var elementsArray = document.getElementsByClassName('profile');
			if (elementsArray[0].readOnly == false) {
				for(var value of elementsArray){
					value.readOnly=true;
					value.style.borderColor="transparent";
					value.style.borderBottom="1px solid black";
				}
			} else {
				for(var value of elementsArray){
					value.readOnly=false;
					value.style.border="1px solid #d9d9d9";
				}
			}
		}
		function getFileName() {
			var fileInput = document.getElementById("image_submit");
			for( var i = 0; i < fileInput.files.length; i++ ){
				document.getElementById("upload_name").value
				=fileInput.files[i].name; // 파일명 출력
			}
		};
		document.getElementById("change_btn").addEventListener("click", profile_change_mode);
	</script>
</html>