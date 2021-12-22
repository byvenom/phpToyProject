<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	function submitchk(){
		if(form.userid = ""){
			alert("id를 입력해주세요");
			return false;
		}
	}

</script>
<form name="form" method='post' action='signup_ok.php' onsubmit="return submitchk(this);">
<div style="display:flex;height:100%;min-height:600px;">
<table style="margin:auto;">
<tr>
	<td colspan="2"><h1 align="center">회원 가입</h1></td>	
</tr>
<tr>
	<th>ID</th>
	<td><input type='text' id='userid' name='userid' tabindex='1'/></td>
	
</tr>
<tr>
	<th>PW</th>
	<td><input type='password' name='password' tabindex='2'/></td>
</tr>
<tr>
	<th>NAME</th>
	<td><input type="text" name='name' tabindex='3'/></td>
</tr>
<tr>
	<td colspan='2' align="center"><input type="submit" value="가입" tabindex='4'/></td>
</tr>
</table>
</div>
</form>