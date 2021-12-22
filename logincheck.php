<style>
	a {text-decoration-line : none;}
</style>
<?
session_start();

if(!isset($_SESSION['user_id'] )) {
	header("location: login.php");
	//echo "<script>alert('로그인이 필요합니다.')</script>";
}else{
echo "<div style='width:100%;'><div style='width:50%;float:left;box-sizeing:border-box'><a href='index.php'>홈으로</a>&nbsp;&nbsp;<a href='favorite.php'>즐겨찾기</a>&nbsp;&nbsp;<a href='lotto_a.php'>Lotto</a>&nbsp;&nbsp;<a href='map.php'>Map</a>&nbsp;&nbsp;<a href='api.php'>API</a>&nbsp;&nbsp;<a href='example.php'>주가</a>&nbsp;&nbsp;<a href='cal.php'>캘린더</a></div><div style='text-align:right;width:50%;float:left;box-sizeing:border-box;'><span style='background:-webkit-linear-gradient(top, rgb(255, 180, 0), rgb(255, 0, 255));-webkit-background-clip:text;-webkit-text-fill-color:transparent'>".$_SESSION['user_name']."</span>님 환영합니다. <input class='button_l' onclick=\"location.href='logout.php'\" type='button' value='로그아웃'></div></div><br/>";
}
?>