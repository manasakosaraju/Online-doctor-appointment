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
$result=mysqli_query($con,"select id,fname,lname, address from patients where email='$email' ");
$array=mysqli_fetch_array($result);
$pid=$array[0];
$fname=$array[1];
$lname=$array[2];
$address=$array[3];
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
table,td{
  border:1px solid black;
  border-collapse:collapse;
}
td,th{
padding:10px;
}

</style>

<!--************** Date ****************** -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
	
	
	<!-- End of AJAX Call -->
</head>	
	


<body class="w3-theme-l5" onload = "ShowAppointments()" style="background-image:url(images/Dr3.jpg); background-repeat:no-repeat; background-size:cover">

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
		
		<a href="login.html">Sign out</a>
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
			<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Name: <strong><?php echo $fname. " " . $lname; ?></strong></p>
			<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> City: <strong><?php echo $address ?></strong></p>
			<!--Debug
			<h4 id="mydate">Date</h4>
			<h4 id="mytime">Time</h4>
			<h4 id="myemail">Email</h4>
			<h4 id="myid">ID</h4>-->
			

        </div>
      </div>
      <br>
      
     
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m7">
    
     <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white">
            <div class="w3-container w3-padding">
              <h3> Appointments</h3>
             
              <!--<button type="button" class="w3-btn w3-theme"></i>Search</button> -->
              <?php
$appointments=mysqli_query($con,"select appointments.doctor_id,dfname,dlname,Date,time_slot,appointment_id from doctors,appointments where doctors.id=appointments.doctor_id and appointments.is_deleted=0 and patient_id=$pid order by Date desc");
//echo "entered";
$rows=mysqli_num_rows($appointments);
if($rows>0)
{
echo "<table><td></td>
<td>id</td>
<td>Name</td>
<td>Date</td>
<td>Appointment time</td></tr>";
echo "<form method='get'>";
while($result=mysqli_fetch_array($appointments))
{
  if($result[3]>=Date('Y-m-d'))
  echo "<tr><td><input type='radio' name='doctor' value=$result[0]></option>
  <input type='hidden' name='date' value='$result[3]'/>
  <input type='hidden' name='timeslot' value='$result[4]'/>
  <td>$result[appointment_id]
  <td>$result[1] $result[2]</td>
  <td>$result[3]</td>
  <td>$result[4]</td></tr>";
}
echo "</table>";
echo "<br/>";
echo "<input type='submit' class='w3-btn w3-theme w3-left-align' name='Cancel' id='Cancel' value='Cancel Appointment'/> ";
echo "</form>";
}

else{
  echo "No appointments scheduled at this time";
}
if(isset($_GET['Cancel'])) 
{
  $doctor_id=$_GET['doctor'];
  $dates=$_GET['date'];
  $time_slot=$_GET['timeslot'];
  $soft_delete=mysqli_query($con,"update appointments set is_deleted=1 where doctor_id='$doctor_id' and patient_id='$pid' and Date='$dates' and time_slot='$time_slot'  ");
  if($soft_delete)
  {
    //echo "<br/>";
    //echo "Appointment cancelled successfully";

    header('Location:appointments.php');
  }
} 
echo "<br/>";
echo "<br/>";
echo "<br/>";

    $appointments=mysqli_query($con,"select appointments.doctor_id,dfname,dlname,Date,time_slot,appointment_id from doctors,appointments where doctors.id=appointments.doctor_id and patient_id=$pid and appointments.is_deleted=0 order by Date desc");
//echo "entered";
$rows=mysqli_num_rows($appointments);
//echo $rows;
if($rows>0)
{
  echo "<h4>Previous appointments:<h4>";
echo "<table><td>id</td>
<td>Name</td>
<td>Date</td>
<td>Appointment time</td></tr>";
while($result=mysqli_fetch_array($appointments))
{
  if($result[3]<Date('Y-m-d'))
  echo "<td>$result[appointment_id]</td>
<td>$result[1] $result[2]</td>
  <td>$result[3]</td>
  <td>$result[4]</td></tr>";
} 
echo "</table>";    
}
else
{
  echo "No previous appointments";
}
?>
            </div>
          </div>
        </div>
      </div>
      
	  
	  <div id = "result">
  </div>

    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">
      <!--<div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p><strong>Upcoming Appointment:</strong></p>
          <p>Doctor Name</p>
          <p>Friday 15:00</p>
          <p><button class="w3-btn w3-btn-block w3-theme-l4">Info</button></p>
        </div>-->
      </div>
      <br>
      
     
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->


 
		
}

	

</body>
</html> 
