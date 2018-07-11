<?php  
	session_start(); 

	// 세션이 저장된 id, name, nickname
	$userid= $_SESSION['userid'];
	$username= $_SESSION['username'];
	$usernick= $_SESSION['usernick'];
	$userlevel= $_SESSION['userlevel'];

	// GET으로 전달되 num, page값 얻어오기 
	$num = $_GET['num']; 
	$page = $_GET['page']; 

	// 선택된 num의 가입인사글 DB에서 읽어오기
	require "../lib/dbconn.php";
	mysqli_set_charset($conn, "utf8");

	$sql= "SELECT * FROM greet WHERE num='$num'";
	$result= mysqli_query($conn, $sql);


	// 레코드(한줄)은 1개만 존재할 것임.!(num로 검색했기에.)
	$row= mysqli_fetch_array($result);

	// 읽어온 레코드에서 각 필드값들 얻어오기
	$item_num= $row[num];
	$item_id= $row[id];
	$item_name= $row[name];
	$item_nick= $row[nick];
	$item_hit= $row[hit];
	$item_date= $row[regist_day];
	$is_html= $row[is_html];
	$item_content= $row[content];



	// 제목(띄어쓰기 여러개를 적용하기 위해)
	$item_subject= str_replace(" ","&nbsp;", $row[subject]);

	// 내용
	// html쓰기를 했다면 태그문을 사용하는 것이므로 띄어쓰기나, 줄바꿈을 신경쓸필요 없음.
	if( $is_html!="y"){
		$item_content= str_replace(" ","&nbsp;", $item_content);
		$item_content= str_replace("\n","<br>", $item_content);//nl2br()같은 작업.
	}

	// view.php가 실행된다는 것은 그 글을 한번 조회했다는 뜻임.
	// 조회수를 증가!
	$new_hit= $item_hit +1;
	$sql= "UPDATE greet SET hit=$new_hit WHERE num=$num";
	mysqli_query($conn, $sql);

	// 읽어온 DB값들을 브라우저에 이쁘게 출력하기.(html)

 ?>

<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title></title>

 	<!-- 공통스타일 적용 -->
 	<link rel="stylesheet" type="text/css" href="../css/common.css">
 	<!-- view.php전용 스타일 -->
 	<link rel="stylesheet" type="text/css" href="../css/greet.css">

 	<script type="text/javascript">
 		// 삭제버튼 눌렀을때 호출되는 함수
 		function del( href ){
 			if(  confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?") ){
 				//페이지를 delete.php로 이동
 				location.href= href;
 			}
 		}
 	</script>
 </head>
 <body>

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

 				<div id="title">
 					<img src="../img/title_greet.gif">
 				</div>

 				<!-- 내용물 표시 영역 -->
 				<!-- 1. view 타이틀 영역 -->
 				<div id="view_title">
 					<div id="view_title1"> <?= $item_subject ?> </div>
 					<div id="view_title2"> <?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?> </div>
 				</div>

 				<!-- 2. view 내용물 영역 -->
 				<div id="view_content">
 					<?= $item_content ?> 					
 				</div>

 				<!-- 3. 버튼들 영역 -->
 				<div id="view_button">
 					<!-- 목록보기 버튼 -->
 					<a href="list.php?page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;

 					<!-- 수정 삭제는 본인글만 가능. or 레벨1단계 or 관리자계정 가능.-->
 					<?php 
 						if( $userid==$item_id || $userlevel==1 || $userid=="admin"){
 					?>
 							<a href="modify_form.php?num=<?=$item_num?>&page=<?=$page?>"><img src="../img/modify.png"></a>&nbsp;
 							<!-- 삭제는 한번 더 삭제의사를 물어보는 경고창을 보여주고 -->
 							<!-- 그 경고차에서 확인/취소를 선택(confirm())하도록.. -->
 							<!-- 그 결과가 확인 선택이면 그때 delete.php가 실행되도록! -->
 							<!-- a를 눌렀을때 Javascript로 del()함수 호출! -->
 							<a href="javascript:del('delete.php?num=<?=$item_num?>')"><img src="../img/delete.png"></a>&nbsp;

 					<?php
 						}
 					?>

 					<!-- 로그인 되어 있다면 글쓰기 가능 -->
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