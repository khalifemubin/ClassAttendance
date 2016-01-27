<?php
	session_start();

	if(isset($_SESSION["admin_id"]))
	{
		header("Location: dashboard.php"); /* Redirect browser */
		exit();
	}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Attendance :: Administration</title>
  <link rel="stylesheet" href="css/login.css">
  
  <script src="js/jquery-1.10.2.js"></script>
  <script>  
  String.prototype.fulltrim=function(){return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ');}
  $(document).ready(function() {
            //option A
            $("#frmLogin").submit(function(e){
                e.preventDefault();
				
				//Begin validation
				if($("#txtLoginUser").val().fulltrim() == ""){
					$("#divErrMsg").html("Please enter username").show();
				}
				else if($("#txtLoginPass").val().fulltrim() == ""){
					$("#divErrMsg").html("Please enter password").show();
				}else{
					$("#divErrMsg").hide();
					$.ajax({
						url: 'ajax_service.php',
						data: "action_param=login_check&username="+$("#txtLoginUser").val()+"&userpass="+$("#txtLoginPass").val(),
						success: loginValidateCallBack
					});

				}
				
				
            });
    });
	
	
	function loginValidateCallBack(ajaxResponse){	
		if(ajaxResponse["login_check"]!=undefined)
		{
			var result = ajaxResponse["login_check"];

			
			if(result.toLowerCase().fulltrim() == "success"){
				window.location.replace("dashboard.php");//replace() does not put the originating page in the session history
			}else{
				$("#divErrMsg").html("Invalid login").show();
			}
		}
		else{
			$("#divErrMsg").html("Error Occured"+ajaxResponse).show();
		}

	}
	
  </script>
  
</head>
<body>
	<div class="divError" id="divErrMsg"></div>
	<div id="login_box">
        <!--<span id="login_box_title">Login</span>
		<hr/>-->
		<div class="divClr">&nbsp;</div>
			<form id="frmLogin">
				<div class="Table">
					<div class="Title">
						<p>Login</p>
					</div>
					<!--<div class="Heading">
						<div class="Cell">
							<p>Heading 1</p>
						</div>
						<div class="Cell">
							<p>Heading 2</p>
						</div>
						<div class="Cell">
							<p>Heading 3</p>
						</div>
					</div>-->
					<div class="Row">
						<div class="Cell">
							<p>Username</p>
						</div>
						<div class="Cell">
							<input type="text" placeholder="Username" tabindex="1" id="txtLoginUser" />
						</div>
						<!--<div class="Cell">
							<p>Row 1 Column 3</p>
						</div>-->
					</div>
					<div class="Row">
						<div class="Cell">
							<p>Password</p>
						</div>
						<div class="Cell">
							<input type="password" placeholder="Password" tabindex="2" id="txtLoginPass" />
						</div>
						<!--<div class="Cell">
							<p>Row 2 Column 3</p>-->
						</div>
					</div>
					<div class="divClr">&nbsp;</div>
					<div class="Row">
							<button id="btnLogin" type="submit">Sign In</button>
					</div>					
				</div>
			</form
    </div>
</body>
</html>