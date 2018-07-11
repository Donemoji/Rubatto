<?php 
	session_start();

	$userid= $_SESSION['userid'];
	$usernick= $_SESSION['usernick'];
	$userlevel= $_SESSION['userlevel'];

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

 				<!-- 본문내용 영역 : 4개 영역 -->

 				<?php
 					//DB의 greet 테이블에서 데이터 가져오기

 					// 총 게시글 수 얻어오기 
 					require "../lib/dbconn.php"; 

 					// utf8로 character set를 읽어오기 
 					// mysqli_query($conn, "set names utf8");
 					mysqli_set_charset($conn, "utf8");

 					// mode값 얻어오기 
 					$mode = $_GET['mode']; 

 					// 검색 모드 인지.. 
 					if($mode=='search'){
 						//검색 리스트 모드
 						$category = $_POST['category'];
 						$search = $_POST['search'];

 						if(!$search){
 							// 검색 단어를 입력하지 않았다면.. 
 							echo ("
 								<script>
 									alert('검색할 단어를 입력하시오..')
 									history.back();
 								</script>
 							");
 							exit;
						}

						// 검색 category 필드의 검색단어가 포함되어 있는지 검색하는 쿼리!
						$sql="SELECT * FROM greet WHERE $category like '%$search%' ORDER BY num DESC";

 					}else{
 						//전체 리스트 모드
 						$sql = "SELECT * FROM greet ORDER BY num DESC";

 					}
 					
 					// 쿼리문 요청 
 					$result = mysqli_query($conn, $sql);

 					// 저장된 레코드 수 (게시글 수)
 					$rowNum = mysqli_num_rows($result);



 				?>

 				<!-- 1. 게시글수와 검색 요청 영역 -->
 				<form name="form_search" method="post" action="list.php?mode=search">
 					<div id="list_search">
 						<!-- 게시글 수 표시 -->
 						<div id="list_search1"> ▷ 총 <?= $rowNum?>개의 게시물이 있습니다.</div>

 						<!-- search 라벨 이미지 -->
 						<div id="list_search2"><img src="../img/select_search.gif"></div>

 						<!-- 검색 카테고리 선택 -->
 						<div id="list_search3">
 							<select name="category">
 								<option value="subject">제목</option>
 								<option value="content">내용</option>
 								<option value="nick">닉네임</option>
 							</select>
 						</div>

 						<!-- 검색 단어 입력 영역 -->
 						<div id="list_search4"><input type="text" name="search"></div>

 						<!-- submit버튼 이미지 -->
 						<div id="list_search5"><input type="image" src="../img/list_search_button.gif"></div>

 					</div>
 				</form>


 				<!-- 2. 표의 제목줄 영역 -->
 				<div id="list_title">
 					<ul>
 						<li id="list_title1"><img src="../img/list_title1.gif"></li>
 						<li id="list_title2"><img src="../img/list_title2.gif"></li>
 						<li id="list_title3"><img src="../img/list_title3.gif"></li>
 						<li id="list_title4"><img src="../img/list_title4.gif"></li>
 						<li id="list_title5"><img src="../img/list_title5.gif"></li>
 					</ul> 					
 				</div>

 				<!-- 3. 가입인사 글 목록 영역 -->

 				<div id="list_content"> 				
 				
 				<!-- 반복문처리가 필요하므로 php로 작업 -->
 				<?php 
 					// 저 위에서 이미 가입인사글 데이터들을 DB에서 읽어온 상태임.($result)
 					//한 페이지에 보여질 글 수..
 					$scale = 10; 

 					//전체 페이지 수.. 
 					$pageNum = ceil($rowNum/$scale);
 					if($pageNum == 0) $pageNum=1;

 					//현재 페이지 번호 
 					$page = $_GET['page']; 
 					if(!$page) $page = 1;

 					// 현재 페이지($page)에서 보여줄 게시글의 시작 row위치 
 					$start = ($page-1)*$scale;

 					// $rowNum:게시글 수, $pageNum:페이지 수, $page:현재 페이지번호, $start:읽어올 게시글 시작위치

 					for($i=$start;$i<$start+$scale && $i<$rowNum;$i++){
 						//커서의 위치를 해당 row위치로 이동.. 
 						mysqli_data_seek($result, $i);

 						// 이동된 위치의 레코드(row) 가져오기
 						$row= mysqli_fetch_array($result);

 						// 해당 레코드에 각 필드값 얻기
 						$item_num = $row[num];
 						$item_id = $row[id];
 						$item_name = $row[name];
 						$item_nick = $row[nick];
 						$item_subject = $row[subject];
 						$item_content = $row[content];
 						$item_date = $row[regist_day];
 						$item_hit = $row[hit];
 						$item_is_html = $row[is_html];

 						// content안의 줄바꿈 문자(\n)를 <br>로
 						$item_content = nl2br($item_content);

 						// 항목 출력은 html로.. 
 				?>
 				<!-- html 영역 -->
 				<div class="list_item">
 					<ul>
 						<li class="list_item1"><?= $item_num?></li>
 						<!-- 클릭 되도록 할것임..<a> 세부 내용 보는곳으로 이동! -->
 						<li class="list_item2"><a href="view.php?num=<?= $item_num?>&page=<?= $page?>"><?= $item_subject?></a></li>
 						
 						<li class="list_item3"><?= $item_nick?></li>
 						<li class="list_item4"><?= $item_date?></li>
 						<li class="list_item5"><?= $item_hit?></li>
 					</ul>
 				</div>

 				<?
 					}
 				?>

				</div>


 				<!-- 4. 페이지번호 및 글쓰기버튼영역 -->
 				<div id="page_num">
 					<a href="list.php?page=<?=$page-1?>"> ◀ 이전 </a>&nbsp;&nbsp;

 					<!-- 페이지 번호 나열 -->
 					<?php  
 						for($i=1;$i<=$pageNum;$i++){
 							if($page==$i) echo "<strong> $i </strong>"; 
 							else echo "<a href='list.php?page=$i'> $i </a>";
 						}
 					?>



 					&nbsp;&nbsp;<a href="list.php?page=<?php if($page<$pageNum) echo $page+1; else echo $page;?>"> 다음 ▶ </a>
 				</div>

 				<div id="buttons">
 					<a href="list.php"><img src="../img/list.png"></a>&nbsp;

 					<!-- 로그인 상태라면 글쓰기 버튼 보이도록 -->
 					<?php  
 						if($userid){
 							echo "<a href='write_form.php'><img src='../img/write.png'></a>";
 						}

 					?>
 				</div>

 				
 			</section>
 		</div>
 		
 	</div>
 
 </body>
 </html>