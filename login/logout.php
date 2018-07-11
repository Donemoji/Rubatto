<?php 

	//로그아웃은 세션변수들만 삭제하면 됨.
	session_start();

	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['usernick']);
	unset($_SESSION['userlevel']);

	//로그아웃 되었으니 다시 메인페이지로 이동.
	echo ("
		<script>
			location.href='../index.php';
		</script>
		");

 ?>