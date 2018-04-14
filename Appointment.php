<?php
session_start();
//$from_hours_new="";
$is_not_equal=0;
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
$patientid=$array[3];

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
              <h3>Make appointment</h3>
              <?php
$did=$_SESSION['did'];
$pid=$_SESSION['pid'];
//echo $did;
//echo $pid;
$result_app=mysqli_query($con,"select dfname,dlname,from_hours, to_hours from doctors where id=$did ");
$rows=mysqli_num_rows($result_app);
//echo $rows;
echo "<table>
<tr><td>Name</td>
<td>Office hours</td></tr>";
while($array=mysqli_fetch_array($result_app))
{
  //echo $array[0];

echo "<tr><td>$array[0] $array[1]</td>";
echo "<td>$array[2]-$array[3]</td></tr>";
  $from_hours=$array[2];
  $to_hours=$array[3];
//echo $array[0]." ".$array[1];
}
echo "</table>";
$from_hours_new=$from_hours;
$time_total= $to_hours-$from_hours;

//echo $to_hours;
$to_hours_new=str_split($to_hours,3);
$to_hours_new[0]=str_replace(":", ".", $to_hours_new[0]);
$to_hours_new=$to_hours_new[0].$to_hours_new[1];
//echo $to_hours_new;
// $to_hours_new=number_format($to_hours,2,":","");
// echo $to_hours_new;
echo "<br/>";
echo "<form method='get'>";
echo "Select date of appointment:";
echo "<br/>";
echo "<input type='date' id='date' name='date'></input>";
echo "<br/>"; 
echo "Select time for appointment:
<br/>
<select name='timeslot'>
<option value=''></option>";



while(floatval($from_hours)+0.2<=$to_hours_new)
{
  // echo "<br>";
  // echo "*********";
  // echo "<br>";
  // echo $from_hours;
  //  echo "<br>";
  // echo $to_hours;
  // echo '<br>';
  // echo $from_hours_new+0.20;
  //  echo '<br>';
  //  echo "*********";
  $from_hours_new=number_format($from_hours,2,":","")."\n";

  if(strpos($from_hours_new,":")==1)
  {
    
    $from_hours_new="0".$from_hours_new;
  }
  
  $from_hours_after=str_split($from_hours_new,3);

  if($from_hours_after[1]>59)
  {
   

    $from_hours_after[1]=$from_hours_after[1]-60;
    $from_hours_after[0]=$from_hours_after[0]+1;
  
    $from_hours_new=$from_hours_after[0].$from_hours_after[1];
  //$from_hours=$from_hours_after[0].$from_hours_after[1];  
  }

  else
  {
      
  //echo $rows_count;

    // if($from_hours_new!=$to_hours)
    // {
 //$number=$to_hours-floatval($from_hours);
    $number=floatval($from_hours);

    echo "<option value=$from_hours_new>$from_hours_new</option>";
  // }
 // echo gettype($from_hours_new);
 
}
$from_hours_new=floatval($from_hours_new);
//echo gettype($from_hours_new);
    $from_hours=$from_hours+0.20;
   
  
}
 echo "</select>";
 echo "<br/>";
echo "<br/>";
echo "<input type='submit' class='w3-btn w3-theme w3-left-align' name='Appointment' id='Appointment' value='Schedule Appointment'/>";
echo "</form>";

  if(isset($_GET['Appointment']))
{
  $appointment=$_GET['timeslot'];
  //echo $appointment;
  $dates=$_GET['date'];
  //echo $date;
  $today=date('Y-m-d');
  $day=strftime("%A",strtotime($dates));
  //echo $day;
  if($dates<$today)
  {
    echo "Please enter a valid date";
  }
  //echo $today;
  //echo $appointment;
  else
  {
 
    $days_check=mysqli_query($con,"select available_day from doctors_availability where doctor_id='$did' and available_day='$day' ");
    $rows=mysqli_num_rows($days_check);
    //echo $rows;
    if($rows<=0)
    {
      echo "Doctor is not available on this day";
    }
    else if($appointment=="")
    {
      echo "Please select a time-slot";
    }

    else
    {
$appointment_check=mysqli_query($con,"select doctor_id,time_slot from Appointments where doctor_id='$did' and Date='$dates' and time_slot='$appointment' ");
$rows_count=mysqli_num_rows($appointment_check);
//echo $rows_count;
  if($rows_count>0)
{
echo "This time slot has already been taken";
}
else
{
  $appointment_id=uniqid();
  $appointment_insert=mysqli_query($con,"insert into Appointments (appointment_id,patient_id,doctor_id,Date,time_slot) values ('$appointment_id','$pid','$did','$dates','$appointment') ");
  if($appointment_insert)
  {
    echo "Your appointment is scheduled successfully";
  }
 } 
 }
 
 }//echo $appointment;
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
