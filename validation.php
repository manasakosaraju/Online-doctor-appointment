
<?php

$count=0;
$email=$_POST['email'];
//echo $email;
//echo $email;
$con = new mysqli("localhost", "root", "root", "Doctorapp",3307) or die(mysqli_error());
		$result = mysqli_query($con,"select email from patients where email='$email' ");
		
		if($result)
		{

		while($array=mysqli_fetch_array($result))
		{	
			$count=1;
		
		
		//$array=mysqli_fetch_array($result);
		}
	}
		// if($count==0)
		// {
		// 	echo "<h6 style:'color:red;'>Email id doesnot exists";
		// }
		// else
		// 	{
		// 		echo "<h6 style='color:red;'>Email id already exists";
		// 	}
	
if($count==1)
{
	echo 1;
}
else
{
	echo 0;
}
		?>