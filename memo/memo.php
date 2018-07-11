<?php 
	session_start();

	$userid= $_SESSION['userid'];
	$usernick= $_SESSION['usernick'];
	$userlevel= $_SESSION['userlevel'];
 ?>

<!-- 페이지 제작 -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>낙서장</title>

	<!-- 공통 스타일시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<!-- 낙서장 전용 스타일시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/memo.css">
</head>
<body>

	<!-- 공통모듈 include -->
	<div id="wrap">
		
		<header id="header">
			<?php include "../lib/top_login2.php"; ?>
		</header>

		<nav id="menu">
			<?php include "../lib/top_menu2.php"; ?>
		</nav>

		<div id="content">
			<aside id="col1">
				<div id="left_menu">
					<?php include "../lib/left_menu.php"; ?>
				</div>				
			</aside>

			<section id="col2">				
				<!-- 제목 -->
				<div id="title">
					<img src="../img/title_memo.gif">
				</div>

				<!-- 낙서장 폼 입력영역  -->
				<div id="memo_row1">
					<!-- 낙서글 저장하는 insert.php로 제출 -->
					<form action="insert.php" method="post" name="memo_form">						
						<!-- 닉네임이 보여지는 영역 -->
						<div id="memo_nick"> ▷ <?= $usernick?> </div>

						<!-- 글 입력 textarea 영역 -->
						<div id="memo1">
							<textarea rows="6" cols="90" name="content"></textarea>
						</div>

						<!-- submit용 이미지버튼 영역 -->
						<div id="memo2">
							<input type="image" src="../img/memo_button.gif">
						</div>						
					</form>					
				</div>
				<!-- #memo_row1영역 종료-->

				<!-- 메모글 list(목록) 보기 영역 -->
				<?php 

					// DB의 memo테이블에 저장되 있는 글 가져오기
					require "../lib/dbconn.php";

					// 읽어오는 데이터를 utf8로 읽도록.
					mysqli_query($conn, "set names utf8");

					// 전제 저장 데이터들(레코드row들) 읽어오기
					// 가장 최근글이 먼저 나오도록 정렬(num 내림차순)
					$sql= "SELECT * FROM memo ORDER BY num DESC";
					$result= mysqli_query($conn, $sql);
					//저장글 총 개수(row의 개수)
					$rowNum= mysqli_num_rows($result);

					// 한페이지에 보여질 수 있는 메모글의 수
					$scale=5;

					// 총 페이지 수(한페이지에 5($scale)개 메모글)
					// (1~5: 1page, 6~10:2page, 11~15: 3page ....)
					$pageNum= ceil($rowNum/$scale);
					if($pageNum==0) $pageNum=1;//게시글 0개면 1page


					//페이지수 많기에 현재 페이가 몇페이지 인지. 알 필요가 있음.
					//이 html의 마지막에 페이지번호가 있고 이를 서택했을때 page값을 GET방식으로 memo.php다시 로드.
					$page= $_GET['page']; 
					if(!$page) $page=1;

					//현재 페이지($page)에서 보여줄 5개($scale)의 메모글 출력하기.
					//$result에서 특정 row로 커서를 이동해서 읽어오기.
					//커서를 이동시킬 위치(읽어올 시작위치) 계산하기.
					//(page 1 - 시작번호 0, page2- 시작번호 5, 4page는 시작번호 15)
					// DB 테이블의 row번호는 0번부터임..

					$start= ($page-1)*$scale;

					// $rowNum:총 메모글 수, $pageNum:총 페이지 수, $page: 현재 페이지번호, $start: 현재 페이지에서 읽어들일 row의 시작번호.
					for($i= $start; $i<$start+$scale && $i<$rowNum; $i++){
						// 해당하는 row를 위치로 커서를 이동!!
						mysqli_data_seek($result, $i);

						// 이동한 row에서 레코드 읽어오기
						$row= mysqli_fetch_array($result);

						// memo테이블의 한 레코드의 필드값들 얻어오기
						$memo_num= $row['num'];
						$memo_id= $row['id'];
						$memo_name= $row['name'];
						$memo_nick= $row['nick'];
						$memo_content= $row['content'];
						$memo_date= $row['regist_day'];

						// content의 내용에 줄바꿈이 '\n'이라서 브라우저에서 줄이 안바뀜.
						$memo_content= nl2br($memo_content);//'\n' --> <br>

						// 읽어온 값들을 출력!!
						//모양설계를 위해 html문법 사용.하기위해 php영역 분리.
				 ?>
				 	<!-- 이 분리된 공간 사이는 html문법 영역 -->
				 	<!-- 메모글의 제목영역(번호, 닉네임, 작성일) -->
				 	<div class="memo_list_title">
				 		<!-- 각 항목(번호,닉네임,작성일)의 css를 편하게 하기 위해 block요소로 표시. -->
				 		<ul>
				 			<li class="list_title1"><?=$memo_num?></li>
				 			<li class="list_title2"><?=$memo_nick?></li>
				 			<li class="list_title3"><?=$memo_date?></li>

				 			<!-- 작성자 본인 또는 관리자계정만 삭세하도록 -->
				 			<li class="list_title4">
				 				<?php 
				 					if($memo_id == $userid || $userid == "admin"){
				 						echo "<a href='delete.php?num=$memo_num'>삭제</a>";
				 					}
				 				 ?>
				 			</li>
				 		</ul>				 		
				 	</div>

				 	<!-- 메모글 내용 영역 -->
				 	<div class="memo_list_content">
				 		<?= $memo_content ?>				 		
				 	</div>

				 	<!-- ................................... -->
				 	<!-- 댓글(reply) 리스트 및 작성 영역 -->
				 	<div class="reply">
				 		<!-- 댓글 라벨 영역 -->
				 		<div class="reply_label">댓글</div>
				 		<!-- 댓글 리스트 표시 및 작성 영역-->
				 		<div class="reply_area">
				 			<!-- 댓글들 목록 -->
				 			<div class="reply_list">
				 				<!-- 현재 메모글에 해당하는 댓글들을 memo_ripple테이블에서 읽어오기 -->
				 				<?php 

				 					// memo_ripple테이블에서 현재 메모들의 댓글들(parent필드값을 확인)
				 					$sql= "SELECT * FROM memo_ripple WHERE parent='$memo_num'";
				 					// 쿼리요청
				 					$reply_result= mysqli_query($conn, $sql);

				 					// 댓글의 수만큼 읽어오기
				 					while( $reply_row= mysqli_fetch_array($reply_result) ){
				 						$reply_num= $reply_row[num];
				 						$reply_id= $reply_row[id];
				 						$reply_nick= $reply_row[nick];
				 						$reply_content= $reply_row[content];
				 						$reply_date= $reply_row[regist_day];

				 						$reply_content= nl2br($reply_content);

				 						// 읽어온 댓글 데이터를 출력.
				 						// 모양 꾸미기 위해 html로 ..
				 				 ?>
				 				 	<!-- 이 영역은 html -->
				 				 	<div class="reply_list_title">
								 		<!-- 각 항목(닉네임,작성일)의 css를 편하게 하기 위해 block요소로 표시. -->
								 		<ul>
								 			<li class="list_title1"><?=$reply_nick?></li>
								 			<li class="list_title2"><?=$reply_date?></li>

								 			<!-- 작성자 본인 또는 관리자계정만 삭세하도록 -->
								 			<li class="list_title3">
								 				<?php 
								 					if($reply_id == $userid || $userid == "admin"){
								 						echo "<a href='delete_reply.php?num=$reply_num'>삭제</a>";
								 					}
								 				 ?>
								 			</li>
								 		</ul>				 		
								 	</div>

								 	<!-- 댓글 내용 영역 -->
								 	<div class="reply_list_content">
								 		<?= $reply_content ?>				 		
								 	</div>

				 				 <?
				 					}//while
				 				 ?>
				 				
				 			</div>
				 			<!-- 댓글 작성 영역 -->
				 			<div class="reply_write">
				 				<!-- 작성 내용을 insert_reply.php로 제출 -->
				 				<form name="form_reply" method="post" action="insert_reply.php">
				 					<textarea name="content" rows="3" cols="80"></textarea>
				 					<input type="image" src="../img/memo_ripple_button.png">
				 					<!-- 메모글번호 전송이 필요하여.. -->
				 					<input type="hidden" name="parent" value="<?=$memo_num?>">
				 					
				 				</form>				 				
				 			</div>				 			
				 		</div>				 		
				 	</div>

				 	<!-- 댓글 영역 안에서 부여된 float영향 없애기 -->
				 	<div class="clear"></div>

				 <?
					}//for
				 ?>

				<!-- 페이지 번호 영역 -->
				<div id="page_num">
					<a href="memo.php?page=<?=$page-1?>">◀ 이전 </a>&nbsp;&nbsp;

					<!-- 사이에 페이지 번호 나열.. -->
					<?php 
						for($i=1; $i<=$pageNum; $i++){
							//현재 페이지는 안눌러지게.
							if($page==$i) echo "<strong> $i </strong>";
							else echo "<a href='memo.php?page=$i'> $i </a>";
						}

					 ?>

					&nbsp;&nbsp;<a href="memo.php?page=<?if($page<$pageNum) echo $page+1; else echo $page;?>"> 다음 ▶</a>
				</div>
			</section>
		</div>

	</div>

</body>
</html>