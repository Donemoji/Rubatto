<?php 

	session_start();

	//post로 전달된 데이터 받아오기
	$id= $_POST['id'];
	$pass= $_POST['pass'];
	$name= $_POST['name'];
	$nick= $_POST['nick'];
	$hp = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
	$email= $_POST['email1']."@".$_POST['email2'];

	//DB접속..
	require "../lib/dbconn.php";

	//한글처리
	mysqli_query($conn, "set names utf8");

	// 업데이트 쿼리
	$sql= "UPDATE member SET pass='$pass', name='$name', nick='$nick', hp='$hp', email='$email' WHERE id='$id'";

	// 쿼리요청
	$result=mysqli_query($conn, $sql);

	mysqli_close($conn);

	// 세션의 정보를 변경..
	$_SESSION['username']= $name;
	$_SESSION['usernick']= $nick;

	// 업테이트가 완료후 다시 메인페이지로 이동
	echo ("
		<script>
			location.href='../index.php';
		</script>
		");

 ?>