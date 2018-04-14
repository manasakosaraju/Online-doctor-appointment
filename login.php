<?php	


	
try {
    //$conn = new PDO("mysql:host=$servername;dbname=appointmentmaster", $userr, $password);
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$con = new mysqli("localhost", "root", "root", "Doctorapp",3307) or die(mysqli_error());

      if(empty($_POST['email']) || empty($_POST['password']))
		{
			echo "All fields are mandatory!";
			 header('Location: login.html');
		}     
         
		$email = $_POST['email'];
		$password = $_POST['password'];
	$hash_password=hash('sha512',$password);
		// echo $email;
		// echo $password;
		
		setcookie("email",$email); 
		//setcookie("Name",$Name); 
     
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
				//$email = test_input($_POST['email']);
				//$pass = test_input($_POST['password']);
			session_start();
				$_SESSION['sess_email'] = $email;
			

				$_SESSION['sess_password'] = $password;
				
				if (!filter_var($email, FILTER_VALIDATE_EMAIL) or strlen($password) < 6)
				{ 
					 header('Location: login.html');
				}
				
				else
				{
					if($email == 'admin@gmail.com')
					{
						if($password == 'admin@123')
						{
							header('Location: admin/admin.php');
						}
						else
						{
							header('Location: login.html');
						}
					}
					else
					{
						
							$result=mysqli_query($con,"select email,password from patients where email='$email'  and password='$hash_password '");
					 $count=mysqli_num_rows($result);
					 if($count==0)

					 {
					 	
					 	echo "<script> 
					 		alert('The Email or Password you have entered is incorrect ');
					 		window.location='./login.html';
					 		</script>";
					 }
					 else

					 {

					 	//$_SESSION['userId'] = $email;
					 	header('Location: welcome_new.php');
					 }
					
					}
					
				}
				session_write_close();
		}
		function test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
					mysqli_close($conn);

		}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	

?>