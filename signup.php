
<?PHP

session_start();

$username = $password = $name = "";


if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//echo "entered";
	$fname = $_POST["FirstName"];
	$lname = $_POST["LastName"];
	$dob = $_POST["DoB"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$phone = $_POST["PhoneNumber"];
	$address = $_POST["Address"];
	//echo $fname;

	
		$_SESSION['sess_email'] = $email;
		$_SESSION['sess_firstname'] = $firstname;
		$_SESSION['sess_lastname'] = $lastname;
		session_write_close();
		//$count = 0;
		// if($fname=="" )
		// {
		// 	header("Location:login.html");
		// }
		if($fname!="" && $lname!="" && $dob!="" && $email!="" && $password!="" && $phone!="" && $address!="")
		{
		$con = new mysqli("localhost", "root", "root", "Doctorapp",3307) or die(mysqli_error());
		
			//echo "if loop";
			//$hashPassword = password_hash("password", PASSWORD_BCRYPT);
		$hashPassword=hash('sha512',$password);
			//echo $hashPassword;
		// $insertData = "INSERT INTO patients VALUES ('$firstname','$lastname', '$dob', '$email', '$hashPassword',   '$phone_number','$address' )";
					  
		// $qur = $con->query($insertData);
		 $result=mysqli_query($con,"insert into patients (fname,lname,dob,email,password,phone,address) values ('$fname','$lname','$dob','$email','$hashPassword','$phone','$address')");
		echo "login.html";
		}
		else{
			echo "signup.html";
		}	//header("Location: login.html");
	// 			if($con->error )
	// 	{
	// 		//echo 'hello';
	// 		die('Could not enter data: ' . mysqli_error());
	// 		header("Location: signup.html");
	// 	}
	// 	else
	// 	{
		
		
	// 	mysqli_close($con);
	// 	header("Location: login.html");
	// 	//header("Location: signedin.html");
	// 	}
	// }
}
		
		



?>

	
	