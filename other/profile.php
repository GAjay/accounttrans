<?php
	include('../configure/config.php');
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$sql=("SELECT * FROM `users` WHERE `username`='$user'");
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result);
?>
<html>
	<head>
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
	</head>
	<body style="margin:2%"><br>
		<h4>Hello <?php echo $row['partyname'];?> You Can Change Your profile Attribute</h4><br>
		<form action="update.php" method="post" onkeypress="return event.keyCode != 13;">
			<label>Name: </label><input type="text" name="name" value="<?php echo $row['partyname'];?>"><br><br>
			<label>Address: </label><textarea name="address"><?php echo $row['address'];?></textarea><br><br>
			<label>Username: </label><input type="text" id="username" name="username" value="<?php echo $row['username'];?>">
			<h4 id="error">Enter Other USERNAME</h4>
			<input type="hidden" id="check" name="check" value="<?php echo $row['username'];?>">
			<input type="hidden" name="u_name" value="<?php echo $row['username'];?>"><br><br>
			<label>New Password: </label><input type="password" id="password" name="password" placeholder="New Password"><br><br>
			<h4 style="color:red;" id="pass_message"></h4>
			
			<button id="submit" type='submit'>Update</button>
			</div>
		</form>
	</body>
</html>
<script>
	$(document).ready(function(){
		
		$('#error').hide();
		$('#password').change(function(){
			var pass = $(this).val();
			var minNumberofChars = 6;
			var maxNumberofChars = 16;
			var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
			console.log(pass);
			if(pass==''){
				$('#pass_message').hide();
				$('#submit').show();
			}
			else if(pass.length < minNumberofChars || pass.length > maxNumberofChars){
				$('#pass_message').show();
				$('#pass_message').html('password length must be in between 6 to 16');
				$('#submit').hide();
			}
			else if(!regularExpression.test(pass)) {
				$('#pass_message').show();
				$('#pass_message').html("password should contain atleast one number and one special character");
				$('#submit').hide();
			}
			else{
				$('#pass_message').hide();
				$('#submit').show();
			}
		});
		$('#submit').click(function(){
			if(($('#check').val()!=$('#username').val())||($('#password').val()!='')){
				$('#check').val(1);
			}
		});
		$('#username').bind('keyup change',function(){
			$('#submit').hide();
			var username = $(this).val();
			var dataString = 'new_name='+username;
			$.ajax
			({
				type: "POST",
				url: "get/check_username.php",
				data: dataString,
				cache: false,
				success: function(data)
				{	
					//alert(data);
					$('#error').show();
					if(data!=1){
						$('#error').hide();
						$('#submit').show();
					}
				}
			});	
		});
	});
</script>