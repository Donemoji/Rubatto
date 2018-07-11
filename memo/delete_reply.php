<?php 

	// get방식으로 전달된 댓글의 번호(num) 얻어오기
	$num= $_GET['num'];

	require "../lib/dbconn.php";

	// 삭제 쿼리문
	$sql= "DELETE FROM memo_ripple WHERE num='$num'";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	// 다시 이전페이지(memo페이지)
	echo ("
		<script>
			location.href='memo.php';
		</script>
		");

 ?>