<?php 
	session_start();

	$userid= $_SESSION['userid'];
	$usernick= $_SESSION['usernick'];
	$userlevel= $_SESSION['userlevel'];

	// DB에서 현재글 번호 데이터 읽어오기
	$page= $_GET['page'];
	$num= $_GET['num'];

	require "../lib/dbconn.php";
	mysqli_set_charset($conn, "utf8");

	$sql= "SELECT * FROM greet WHERE num='$num'";
	$result= mysqli_query($conn, $sql);

	$row= mysqli_fetch_array($result);

	$item_id= $row[id];
	$item_nick= $row[nick];
	$item_subject= $row[subject];
	$item_content= $row[content];
	$is_html= $row[is_html];

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>가입인사</title>

 	<!-- 공통적용 css적용 -->
 	<link rel="stylesheet" type="text/css" href="../css/common.css">
 	<!-- 가입인사 전용 css적용 -->
 	<link rel="stylesheet" type="text/css" href="../css/greet.css">
 </head>
 <body>

 	<div id="wrap">
 		<header id="header">
 			<?php include "../lib/top_login2.php" ?>
 		</header>

 		<nav id="menu">
 			<?php include "../lib/top_menu2.php" ?>
 		</nav>

 		<div id="content">
 			<aside id="col1">
 				<div id="left_menu">
 					<?php include "../lib/left_menu.php" ?> 
 				</div> 								
 			</aside>

 			<!-- 가입인사 리스트 폼 영역! -->
 			<section id="col2">

 				<!-- 타이틀 이미지 영역 -->
 				<div id="title">
 					<img src="../img/title_greet.gif">
 				</div>

 				<!-- 글쓰기 영역 : 5개영역-->

 				<!-- 글쓰기 타이틀 이미지 영역 -->
 				<div id="write_form_title">
 					<img src="../img/write_form_title.gif">
 				</div>

 				<!-- 가로선 -->
 				<div class="write_line"></div>

 				<form name="form_write" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>">
 					<div id="write_area">
 						<!-- 닉네임 표시 영역 / html쓰기 선택버튼 -->
 						<div id="write_row1">
 							<!-- 라벨 -->
 							<div class="col1"> 닉네임 </div>
 							<!-- 닉네임 표시 -->
 							<div class="col2"> <?= $usernick?> </div>
 							<!-- html쓰기 체크박스 버튼 -->
 							<div class="col3"> <input type="checkbox" name="is_html" value="y" <? if($is_html=='y') echo "checked";?>> HTML 쓰기</div>
 						</div>

 						<!-- 가로선 -->
 						<div class="write_line"></div>

 						<!-- 글 제목 작성 영역-->
 						<div id="write_row2">
 							<div class="col1"> 제목 </div>
 							<div class="col2"> <input type="text" name="subject" value="<?= $item_subject?>"></div>
 						</div>

 						<!-- 가로선 -->
 						<div class="write_line"></div>

 						<!-- 글 내용 작성 영역 -->
 						<div id="write_row3">
 							<div class="col1"> 내용 </div>
 							<div class="col2"> <textarea rows="15" cols="80" name="content"><?= $item_content?></textarea></div>
 						</div> 						
 					</div>

 					<!-- 글작성 완료 및 목록 버튼 영역 -->
 					<div id="write_buttons">
 						<!-- 완료버튼 이미지: submit되야 함. -->
 						<input type="image" src="../img/ok.png">&nbsp;
 						<!-- insert.php로 제출하는 버튼이 아니므로..input요소로 만들면 안됨. -->
 						<a href="list.php"><img src="../img/list.png"></a> 						
 					</div>

 				</form>
 				
 			</section>
 		</div>
 		
 	</div>
 
 </body>
 </html>