<?php
session_start();
$email =  $_SESSION['sess_email'];
$fname="";
$lname="";
$address="";
//echo $email;
 $con = new mysqli("localhost", "root", "root", "Doctorapp",3307) ;
 if(mysqli_connect_error())
 {
 	echo "Could not connect";
 }
 else
 {
$result=mysqli_query($con,"select fname,lname, address,id from patients where email='$email' ");
$array=mysqli_fetch_array($result);
$fname=$array[0];
$lname=$array[1];
$address=$array[2];
$patient_id=$array[3];


 }

 ?>	

<html>
<head>
<title>Online doctor appointment</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif}
 table,td
  {
    border: 1px solid black;
    border-collapse: collapse;
    
    

  }
  td,th
{
padding:10px;
}
</style>


<!--************** Date ****************** -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<!--***********End Date************-->


	<!-- End of AJAX Call -->
</head>	
	


<body class="w3-theme-l5" onload = "ShowAllAppointments()" style="background-image:url(images/Dr3.jpg); background-repeat:no-repeat; background-size:cover">

<!-- Navbar -->
<div class="w3-top">
 <ul class="w3-navbar w3-theme-d2 w3-left-align w3-large">
  <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
    <a class="w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  </li>
  <li><a href="welcome_new.php" class="w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Online doctor appointment</a></li>
  <li class="w3-hide-small"><a href="appointments.php" class="w3-padding-large w3-hover-white" title="Appointments">Appointments</a></li>
  <li class="w3-hide-small"><a href="favorites.php" class="w3-padding-large w3-hover-white" title="Favourites">Favorites</a></li>
  <li class="w3-hide-small w3-dropdown-hover w3-right">
    <a href="#" class="w3-padding-large w3-hover-white" title="My Account"><img src="images/avatar3.png" class="w3-circle" style="height:25px;width:25px" alt="Avatar"></a>    
    <div class="w3-dropdown-content w3-white w3-card-4" style="right:0">
		
		<a href="login.html" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-log-out"></span> SignOut</a>
    </div>
  </li>
 </ul>
</div>



<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card-2 w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center">My Profile</h4>
     

         <hr>
			<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Name: <strong><?php echo $fname . " " . $lname; ?></strong></p>
			<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> City: <strong><?php echo $address?></strong></p>
        </div>
      </div>
      <br>
      
      
      <br>
      
      <br>
      
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m7">
    
     <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white">
            <div class="w3-container w3-padding">
              <h3> Favorite Doctors</h3>
              <?php
$result_fav=mysqli_query($con,"select favorites.pid,favorites.did,dfname,dlname,spec from doctors,favorites where doctors.id in (select did from favorites where pid in (select id from patients where pid=patients.id)) and doctors.id=did and favorites.is_deleted=0  and pid=$patient_id");
 $rows_fav=mysqli_num_rows($result_fav);

 //echo "<form method='get'>";
 if($rows_fav>0)
              {

                //echo $rows_fav;
                echo "<table>
              <tr><td></td>
              <td>Name</td>
              <td>Specialization</td>
             
              </tr>";
              echo "<form method='get'>";
  while($results=mysqli_fetch_array($result_fav))
              {
                $pid=$results[0];
                // echo $pid;
                //echo "while entered";
                echo "<tr>
                <td>  <input type='radio' name='doctor' value=$results[1]></td>
            
                <td>$results[2] $results[3]</td>
                <td>$results[4]</td>";

              }
              // echo $pid;
              echo "</table>";
            }
            else
            {
              //echo "<h6>No records found</h6>";
            }

            echo "<br/>";
            echo "<input type='hidden' name='patient' value=$pid></input>";
            echo "<input type='submit' class='w3-btn w3-theme w3-center' id='appointment' name='appointment' value='Get appointment'></input>";
           echo "  ";
           echo "<input type='submit' class='w3-btn w3-theme w3-center' id='remove' name='remove' value='Remove from favorites'></input> ";
            echo "</form>";
            if(isset($_GET['appointment']))
            {
              //echo $_GET['doctor'];
              $_SESSION['did']=$_GET['doctor'];
              $_SESSION['pid']=$_GET['patient'];
             //echo $_GET['patient'];

              //echo "Appointment clicked";
             header('Location:Appointment.php');

            }  
            if(isset($_GET['remove']))
            {
              $doctor_id=$_GET['doctor'];
              $patient_id=$_GET['patient'];
              $remove=mysqli_query($con,"update favorites set is_deleted=1 where pid='$patient_id' and did='$doctor_id' ");
              if($remove)
              {
                header('Location:favorites.php');
              }
            }
              ?>
              <!--<button type="button" class="w3-btn w3-theme"></i>Search</button> -->
            </div>
          </div>
        </div>
      </div>
      
	  
	  <div id = "result">
  </div>
	
    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">
	<!--
      <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p><strong>Upcoming Appointment:</strong></p>
          <p>Doctor Name</p>
          <p>Friday 15:00</p>
          <p><button class="w3-btn w3-btn-block w3-theme-l4">Info</button></p>
        </div>
      </div>-->
      <br>
      
    
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->




</body>
</html> 
