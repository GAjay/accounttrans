<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Create Member</title>

		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
	</head>

	<body class="align">
		<!--h1 style="color:white;">New India Transport Company</h1-->
		<h3 style="color:white;">Create Member</h3><br>
		<div class="grid">

			<form action="signup_value.php" method="POST" class="form login">
				<div class="form__field">
					<label>Party Name:</label>
					<input type="text" name="name" class="form__input" placeholder="Name" required>
				</div>
				<div class="form__field">
					<label>Username</label>
					<input type="text" name="username" class="form__input" placeholder="Username" required>
				</div>
				<div class="form__field">
					<label>Password</label>
					<input id="password" type="password" name="password" class="form__input" placeholder="Password" required>
				</div>
				<div>
					<h4 id="pass_message" style="color:red;"></h4>
				</div>
				<div class="form__field">
					<label>Confirm Password</label>
					<input id="confirm__password" type="password" name="confirm_password" class="form__input" placeholder="Confirm Password" required>
				</div>
				<div>
					<h4 id="con_pass_message" style="color:red;"></h4>
				</div>
				<div class="form__field">
					<label>Permissions</label>
					<label><input type="checkbox" id="1" name="permission[]" value="1" checked> Add</label>
					<label><input type="checkbox" id="2" name="permission[]" value="2"> Paid</label>
					<label><input type="checkbox" id="3" name="permission[]" value="3"> All</label>
				</div>
				<div class="form__field">
					<label>Address</label>
					<textArea name="address" class="form__input" required>Enter Address</textArea>
				</div>
				<div class="form__field">
					<input type="submit" id="submit">
				</div>
			</form>
		</div>
	</body>

</html>


<script>
$(document).ready(function(){
	$('#password').change(function(){
		var pass = $(this).val();
		var minNumberofChars = 6;
		var maxNumberofChars = 16;
		var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
		if(pass.length < minNumberofChars || pass.length > maxNumberofChars){
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
	$('#confirm__password').change(function(){
		var value = $(this).val();
		if(value != $('#password').val()){
			$('#con_pass_message').show();
			$('#submit').hide();
			$('#con_pass_message').html("password didn't matched");
		}
		else{
			$('#con_pass_message').hide();
			$('#submit').show();
		}
	});
	$("#3").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
	});
});
</script>


