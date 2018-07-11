<?php 
	session_start();

	$userid= $_SESSION['userid'];
	$username= $_SESSION['username'];
	$usernick= $_SESSION['usernick'];
 ?>

 <meta charset="utf-8">

 <?php 

 	//로그인 안되면 작성 불가
 	if(!$userid){
 		echo ("
 			<script>
 				alert('로그인 후 이용 가능합니다.');
 				histroy.go(-1);
 			</script>
 			");

 		exit;
 	}

 	// post로 전달된 content, parent 얻어오기
 	$content= $_POST['content'];
 	$parent= $_POST['parent'];

 	// 콘테츠가 비어있으면 저장이 안되도록..
 	if(!$content){
 		echo ("
 			<script>
 				alert('내용을 입력하세요.');
 				histroy.go(-1);
 			</script>
 			");

 		exit;
 	}

 	$regist_day= date("Y-m-d (H:i)");

 	require "../lib/dbconn.php";

 	mysqli_query($conn, "set names utf8");

 	// memo_ripple테이블에 저장하는 쿼리문.
 	$sql= "INSERT INTO memo_ripple (parent, id, name, nick, content, regist_day) ";
 	$sql.= "VALUES('$parent','$userid', '$username', '$usernick', '$content', '$regist_day')";

 	// 쿼리요청
 	mysqli_query($conn, $sql);
 	mysqli_close($conn);

 	echo ("
 		<script>
 			location.href='memo.php';
 		</script>
 		");


  ?>