<?php 
	session_start();

	$userid= $_SESSION['userid'];
	$username= $_SESSION['username'];
	$usernick= $_SESSION['usernick'];
 ?>

<meta charset="utf-8">

<?php 

	// 로그인 안된 사람은 글 작성 않고 종료
	if(!$userid){
		//경고창 보여주고 다시 이전페이지(memo.php)이동
		echo ("
			<script>
				alert('로그인 후 이용 가능합니다.');
				history.go(-1);
			</script>
			");

		exit;
	}

	//post로 받은 content값 얻어오기
	$content= $_POST['content'];

	//혹시 content작성 없이 저장버튼을 눌렀을수도 있으니
	if(!$content){
		echo ("
			<script>
				alert('내용을 입력하세요.');
				history.go(-1);
			</script>
			");

		exit;
	}

	//글작성날짜(저장일자)
	$regist_day= date('Y-m-d (h:i)');

	// DB접속
	require "../lib/dbconn.php";

	mysqli_query($conn, "set names utf8");

	//저장을 위한 query
	$sql= "INSERT INTO memo(id, name, nick, content, regist_day) ";
	$sql.= "VALUES('$userid', '$username', '$usernick', '$content', '$regist_day')";

	mysqli_query($conn, $sql);
	mysqli_close($conn);

	//글작성이 끝났으면 다시 낙서장페이지로 이동.
	echo ("
		<script>
			location.href='memo.php';
		</script>
		");

 ?>