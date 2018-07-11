<?php 
	session_start();

	// 세션에 저장되어 있는 회원정보 중 id, nick, level값 읽어오기.
	$userid= $_SESSION['userid'];
	$usernick= $_SESSION['usernick'];
	$userlevel= $_SESSION['userlevel'];
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>루바또</title>

 	<!-- 스타일 시트 연결 -->
 	<link rel="stylesheet" type="text/css" href="css/common.css">
 </head>
 <body>

 	<div id="wrap">
 		<header id="header">
 			<!-- 공통사용 php문서 외부 추가하기: 공통모듈 php는 lib폴더에 적용 -->
 			<? include("./lib/top_login.php");?> 			
 		</header>

 		<nav id="menu">
 			<!-- 공통모듈 사용. -->
 			<? include "./lib/top_menu.php"; ?> 			
 		</nav>

 		<div id="content">
 			<!-- 메인화면 이미지 -->
 			<div id="main_img">
 				<img src="./img/main_img.jpg">
 			</div>
 			
 		</div>
 		
 	</div>
 
 </body>
 </html>