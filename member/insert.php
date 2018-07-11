<?php 

	header('Content-Type:text/html; charset=utf-8');

	//member_form.php로 부터 post로 전달된 값들 받기
	$id= $_POST['id'];
	$pass= $_POST['pass'];
	$name= $_POST['name'];
	$nick= $_POST['nick'];
	$hp = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
	$email= $_POST['email1']."@".$_POST['email2'];

	//추가적으로 DB에 저장할 회원가입일, 등급변수 생성
	$regist_day= date("Y-m-d (H:i)");
	$level= 9; //최초등급은 9등급으로 시작!

	//DB에 저장
	// DB에 접속하기
	require "../lib/dbconn.php";

	// 먼저 중복 id가 있는지 검사!
	$sql= "SELECT * FROM member WHERE id='$id'";

	$result= mysqli_query($conn, $sql);
	$rowNum= mysqli_num_rows($result);

	if( $rowNum ){//개수가 0(false)가 아니면..
		// 중복되었다..
		// 경고창 뜨이고 이전페이지(member_form.php)로 이동.
		echo ("
			<script>
				alert('해당 아이디가 존재합니다.');
				history.back();
			</script>
			");

		exit;
	}

	// 여기까지 왔다는 것은 중복 id가 없다는 것!

	//한글처리
	mysqli_query($conn, "set names utf8");

	// 위에서 받아온 값들을 member 테이블에 insert
	$sql= "INSERT INTO member(id, pass, name, nick, hp, email, regist_day, level) ";
	$sql.= "VALUES('$id', '$pass', '$name', '$nick', '$hp', '$email', '$regist_day', $level)";

	mysqli_query($conn, $sql);
	mysqli_close();

	//회원가입이 정상적으로 마쳤다면..
	//자동으로 다시 Main Page(index.php)로 이동
	echo ("
		<script>
			location.href='../index.php';
		</script>
		");
 ?>