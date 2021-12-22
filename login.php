<?
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script>alert('이미 로그인 되있습니다.');
	location.replace('index.php');</script>";
}else{


?>
<script>
	function signUp(){
		var options = 'top=10, left=10, width=500, height=600, status=no, menubar=no, toolbar=no, resizable=no';
		window.open('signup.php','sign up',options)
	}
</script>
<!DOCTYPE html>
<meta charset="utf-8" />
<form method='post' action='login_ok.php'>
<div style="display:flex;height:100%;min-height:600px;">
<table style="margin:auto;">
<tr>
	<td colspan="2"><h1 align="center">로그인</h1></td>	
</tr>
<tr>
	<td>아이디</td>
	<td><input type='text' name='user_id' tabindex='1'/></td>
	<td rowspan='2'><input type='submit' tabindex='3' value='로그인' style='height:50px'/></td>
</tr>
<tr>
	<td>비밀번호</td>
	<td><input type='password' name='user_pw' tabindex='2'/></td>
</tr>
<tr>
<td><input type='button' value="회원가입" onclick="signUp();"/></td>
</tr>
</table>
</div>
</form>

<? } ?>