<!DOCTYPE html>
<html>
<head>
	<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title></title>
</head>
<body>
	姓名:
	<input type="text" name="" id="name">
	<br><br>
	密码:
	<input type="text" name="" id="pwd">
	<button id="submit" onclick="add()">提交</button>
</body>
<script type="text/javascript" src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
	function add(){
		var name=$("#name").val()
		var pwd=$("#pwd").val()
		//console.log($('mate[name=csrf-token]').attr('content'))
		$.ajax({
			url:"<?php echo url('loginaction')?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr('content'),
				name:name,
				pwd:pwd,
			},
			dataType:'json',
			type:'post',
			success:function(res){
				if (res.status=='ok') {
					//location.href='<?php echo url('personal/list') ?>'
					alert("登录成功！")
				}
				if (res.status=='error') {
					alert(res.data)
					$("#name").val('')
					$("#pwd").val('')
				}
			}
		})
	}
</script>
</html>
