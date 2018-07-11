<?php 
	session_start();
 ?>

<meta charset="utf-8">

<?php 
	
	//POST로 전달받은 id, password확인하기
	$id= $_POST['id'];
	$pass= $_POST['pass'];

	//id가 비어있는지 확인
	if(!$id){
		//경고창 보여주고 이전 페이지로 이동.
		echo ("
			<script>
				alert('아이디를 입력하세요.');
				history.back();
			</script>
			");

		exit;
	}

	//pass가 비어 있는지 확인
	if(!$pass){
		echo ("
			<script>
				alert('비밀번호를 입력하세요.');
				history.go(-1);
			</script>
			");
		exit;
	}

	// 위 if문에 걸리지 않았으면 이 아래 코드가 실행..
	// id, pass가 회원명단에 있는지 검사!

	//DB접속
	require "../lib/dbconn.php";

	//utf8 방식으로 읽으라는 요청문 
	mysqli_query($conn, "set names utf8");

	// 해당 id,pass확인 쿼리문 작성
	$sql= "SELECT * FROM member WHERE id='$id' and pass='$pass'";
	// 쿼리요청
	$result= mysqli_query($conn, $sql);
	// 결과로부터 찾아진 레코드의 개수 확인
	$rowNum= mysqli_num_rows($result);

	if(!$rowNum){ //찾아온 개수가 0개라면.
		// id,pass가 맞지 않는 상황..
		// 경과창 및 이전페이지 이동.
		echo ("
			<script>
				alert('아이디와 비밀번호를 확인하세요.');
				history.go(-1);
			</script>
			");
		exit;
	}


	//위의 if문에 걸리지 않았으면 로그인성공상황!!
	// 위 요청결과($result)로 부터 사용자 데이터 읽어오기
	$row= mysqli_fetch_array($result);

	//세션에 저장할 변수들 얻어오기
	$userid= $row[id];
	$username= $row[name];
	$usernick= $row[nick];
	$userlevel= $row[level];

	// 세션에 저장하기..(반드시 이 문서의 시작에 session_start()가 있어야함.)
	$_SESSION['userid']= $userid;
	$_SESSION['username']= $username;
	$_SESSION['usernick']= $usernick;
	$_SESSION['userlevel']= $userlevel;

	// 세션저장이 끝났으면 로그인 되었다고 볼수 있으므로
	// 다시 Main Page(index.php)로 이동
	echo ("
		<script>
			location.href='../index.php';
		</script>
		");

 ?>