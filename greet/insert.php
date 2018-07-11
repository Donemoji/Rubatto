<?php 
	session_start();

	// 세션이 저장된 id, name, nickname
	$userid= $_SESSION['userid'];
	$username= $_SESSION['username'];
	$usernick= $_SESSION['usernick'];
 ?>

 <meta charset="utf-8">

 <?php 
 	//로그인 안된 사람은 저장 불가!
 	if(!$userid){
 		echo ("
 			<script>
 				alert('로그인 후 이용 가능합니다.');
 				history.back();
 			</script>
 			");
 		exit;
 	}

 	// post방식으로 전달된, 제목, 내용 얻어오기
 	$subject= $_POST['subject'];
 	$content= $_POST['content'];

 	// 제목이 없으면 저장 불가!
 	if(!$subject){
 		echo ("
 			<script>
 				alert('제목을 입력하세요.');
 				history.back();
 			</script>
 			");
 		exit;
 	}

 	// 내용이 없으면 저장 불가!
 	if(!$content){
 		echo ("
 			<script>
 				alert('내용을 입력하세요.');
 				history.back();
 			</script>
 			");
 		exit;
 	}

 	// html쓰기 허용여부 확인
 	$is_html= $_POST['is_html'];

 	if( $is_html!='y'){//html쓰기가 허용되지 않으면.
 		//'<','>'' 같은 html문법 문자들을 특수문자(&lt; &gt;)로 변환하기.!!
 		$content= htmlspecialchars($content);
 	}

 	// 글 저장 날짜
 	$regist_day= date('Y-m-d (H:i:s)');

 	// db접속
 	require "../lib/dbconn.php";

 	// 한글깨짐방지
 	mysqli_set_charset($conn, "utf8");

 	// insert 쿼리문..
 	$sql= "INSERT INTO greet(id, name, nick, subject, content, regist_day, hit, is_html) ";
 	$sql.="VALUES('$userid','$username','$usernick','$subject','$content','$regist_day', '0', '$is_html')";

 	// 쿼리 요청
 	mysqli_query($conn, $sql);
 	mysqli_close();

 	// 글쓰기가 완료되면 다시 가입인사 목록 페이지로 이동.
 	// 새글은 언제나 최신글이니 무조건 1page로 이동.
 	echo ("
 		<script>
 			location.href='list.php';
 		</script>
 		");



  ?>