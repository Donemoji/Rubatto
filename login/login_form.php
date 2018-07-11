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
	<title>루바또</title>

	<!-- 공통 스타일시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<!-- 로그인폼 전용 스타일시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/login.css">
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
			<!-- 왼쪽 사이드 -->
			<aside id="col1">
				<div id="left_menu">
					<?php include "../lib/left_menu.php"; ?>
				</div>				
			</aside>

			<!-- 본문 -->
			<section id="col2">
				<!-- meber테이블에 저장되어 있는 id 검사하여 로그인하는 php실행(login.php) -->
				<form action="login.php" method="post" name="login_form">
					<!-- 타이틀 영역 -->
					<div id="title">
						<img src="../img/title_login.gif">						
					</div>

					<!-- 로그인 폼 영역 -->
					<div id="form_login">
						<!-- 로그인 화면 안내메세지 이미지 -->
						<img src="../img/login_msg.gif" id="login_msg">

						<!-- 좌물쇠영역의 float에 영향을 받지 않게.. -->
						<div class="clear"></div>

						<!-- 자물쇠모양 이미지 -->
						<div id="login1">
							<img src="../img/login_key.gif">
						</div>

						<!-- 사용자 입력 요소 영역 -->
						<div id="login2">
							<!-- 로그인 입력 및 버튼영역 -->
							<div id="id_input_button">
								<!-- 아이디, 비번 라벨 -->
								<div id="id_pw_label">
									<ul>
										<li><img src="../img/id_title.gif"></li>
										<li><img src="../img/pw_title.gif"></li>
									</ul>									
								</div>

								<!-- 아이디,비번 input -->
								<div id="id_pw_input">
									<ul>
										<li><input type="text" name="id" class="login_input"></li>
										<li><input type="text" name="pass" class="login_input"></li>
									</ul>									
								</div>

								<!-- 로그인 버튼 -->
								<div id="login_button">
									<!-- type='image'면 submit의 기능을 가짐 -->
									<input type="image" src="../img/login_button.gif">									
								</div>
								
							</div>

							<!-- 위의 css작업중에 float이 있음. -->
							<!-- 그 영향을 없애는 용도 -->
							<div class="clear"></div>

							<!-- 사이에 가로선 그리기 -->
							<!-- css를 이용해서 선처럼보이게 .. 높이값과 배경색이용 -->
							<div id="login_line"></div>


							<!-- 회원가입 안내 영역 -->
							<div id="join_button">
								<!-- 안내메세지 -->
								<img src="../img/no_join.gif">

								<!-- 사이간격 공백문자로 띄우기-->
								&nbsp;&nbsp;&nbsp;&nbsp;

								<!-- 회원가입페이지로 이동하는 버튼 -->
								<a href="../member/member_form.php">
									<img src="../img/join_button.gif">
								</a>
								
							</div>							
						</div>						
					</div>
					
				</form>
				
			</section>
		</div>
		
	</div>

</body>
</html>