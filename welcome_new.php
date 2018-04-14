<?php
$search_text="";
session_start();
//echo $_SERVER['HTTP_REFERER'];
//echo "<img src=images/Dr2.jpg>";
 if(!isset($_SERVER['HTTP_REFERER']))
{
    // not logged in
    header('Location: login.html');
   // echo "set";
    exit();
}
// else
// {
//   header('Location:login.html');
//   echo "not set";
// }
$email =  $_SESSION['sess_email'];
$search_clicked=0;
$filter_clicked=0;
//echo $email;
$con = new mysqli("localhost", "root", "root", "Doctorapp",3307) ;


//echo $_SESSION['sess_email'];
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
$pid=$array[3];
//echo $fname;

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
    background: #AFEEEE;


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
</head>
  <body class="w3-theme-l5" onload = "ShowAllDoctors()" style="background-image:url(images/Dr3.jpg); background-repeat:no-repeat; background-size:cover">

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
		<!--<a href="#">Account</a>-->
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
			<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Name: <strong><?php echo $fname." ".$lname ?></strong></p>
			<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> Address: <strong><?php echo $address?></strong></p>
			<!--Debug
			<h4 id="mydate">Date</h4>
			<h4 id="mytime">Time</h4>
			<h4 id="myemail">Email</h4>
			<h4 id="avl">days</h4>-->
			

        </div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card-2 w3-round">
        <div class="w3-accordion w3-white"> 
		 
     
		  <div class="w3-btn-block w3-theme-l1 w3-left-align"><h5 text-align:'center'><i>Your health is our priority</i></h5>
        <form method='GET'>
        <input type='submit' name='list' id='list' class="w3-btn-block w3-theme-12 w3-left" value='List all doctors'</input>
      </form>
			
		</div>
		<div class="w3-btn-block w3-theme-l1 w3-left-align">
			
		</div>
		      </div>
</div>	
		<div>
        </div>
    
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
              <form method="GET" autocomplete="off">
                <div class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i>Specialization :
      <select class="w3-right" id="dropDownSpec" name="specialization">
      <option value="<?php if(isset($_GET['specialization'])) { echo $_GET['specialization']; } ?>"><?php if(isset($_GET['specialization'])) { echo $_GET['specialization']; } ?></option>
      <option value=""></option>
      <option value="General">General</option>
      <option value="ENT">ENT</option>
      <option value="Paedtric">Paedtric</option>
      <option value="Orthopaedic">Orthopaedic</option>
      <option value="Oncologist">Oncologist</option>
      <option value="Heart">Heart</option>
      <option value="NeuroSurgeon">NeuroSurgeon</option>
      <option value="Dentist">Dentist</option>
      </select>
     
    </div>
    <div class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i>Day : 
      <select class="w3-right" id="dropDownDay" name="day">
      <option value="<?php if(isset($_GET['day'])) { echo $_GET['day']; } ?>"><?php if(isset($_GET['day'])) { echo $_GET['day']; } ?></option>
      <option value=""></option>
      <option value="Monday">Monday</option>
      <option value="Tuesday">Tuesday</option>
      <option value="Wednesday">Wednesday</option>
      <option value="Thursday">Thursday</option>
      <option value="Friday">Friday</option>
      <option value="Saturday">Saturday</option>
      <option value="Sunday">Sunday</option>
      </select>
    </div>
         <br/>
         <div>
          <div>
			<input type="text" name="search_text" value="<?php if(isset($_GET['search_text'])) { echo $_GET['search_text']; } ?>" class="w3-border w3-padding" style="width: 100%; border-radius: 4px">
			   </div> </div> 
            <br/>
			<!-- <input type="submit" class="w3-btn w3-theme w3-right"  id="Search" value="Search" name="Search"></input> -->
        <input type="submit" class="w3-btn w3-theme w3-right" id="filter" name="filter" value="Show doctors"></input>
     
      </div>
    </form>
          
      <br/>
                   </div>
          </div>

      <?php
       //session_set_cookie_params(3600,"/");       //echo "php";
      if(!isset($_SESSION['sess_email']))
{
    // not logged in
    header('Location: login.html');
    exit();
}
      //$check=1;
//echo $_SERVER['REQUEST_URI'];
if(isset($_GET['list']))
{
  $con=new mysqli('localhost','root','root','Doctorapp',3307);  
  $result_total_new=mysqli_query($con,"select count(*) from doctors where is_deleted=0 ");
  $array=mysqli_fetch_array($result_total_new);
    $count_rows_new=$array[0];
 //echo $count_rows_new;
             
             // $result_total=mysqli_query($con,"select count(*) from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and spec='$spec' or available_day='$day'");
              //echo $result;
              $requestPageNum = $_GET['pageNum'];
              if (!$requestPageNum) {
                $requestPageNum = 1;
                
              }
              //echo "jfgdfagdkahfgkgdfkafgdkaf     $requestPageNum";
             //echo $requestPageNum;
              $pages=$count_rows_new/5;
              //echo $pages;
              $start_from=($requestPageNum-1)*5;
             // echo $start_from;
              $offset=$requestPageNum-1;

              $result=mysqli_query($con,"select dfname,dlname,spec,email,address,picture from doctors where is_deleted=0 limit 5 offset $start_from");
             // $result=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,available_day from doctors,doctors_availability where doctors.id=5  limit 1 offset 1 ");
             
              $rows=mysqli_num_rows($result);
             // echo $rows;
              if($rows>0)
              {
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";
                echo "<h4>Listing doctors:</h4>";
                echo "<table>
              
              <tr>
              <td>Image</td><td>Name</td>
              <td>Specialization</td>
              <td>Email</td>
           <td>Address</td>
              </tr>";
              while($results=mysqli_fetch_array($result))
              {
                echo "<tr>
                <td><img src=images/$results[picture] height=90 width=90></td>
                <td>$results[0] $results[1]</td>
                <td>$results[2]</td>
                <td>$results[3]</td>
                <td>$results[4]</td>";
             

              }
              echo "</table>";
            }
            else
            {
              echo "<h6>No records found</h6>";
            }
              //echo $page;

              for ($i=0; $i<$pages; $i++) {
                $pageNum = $i + 1;
                $linkAddress = "welcome_new.php?list=List+all+doctors&pageNum=$pageNum";
                //echo $count_rows;
                echo "<a href=$linkAddress style='color:white'>$pageNum</a>";
                echo " ";
               // echo $pageNum;
              }

}

              if(isset($_GET['filter']))
              {
           
              //echo $_GET['search_text'];
              $spec=$_GET['specialization'];
              $day=$_GET['day'];
              $search=$_GET['search_text'];
              //echo $spec; $search
              // echo $day;
              $con=new mysqli('localhost','root','root','Doctorapp',3307);  
 if($spec!="" and $day!="")
              {
              $result_total=mysqli_query($con,"select count(*) from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and spec='$spec' and available_day='$day'and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 ");
             // $result=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,available_day from doctors,doctors_availability where doctors.id=5  limit 1 offset 1 ");
              }
              else if($spec!="")
              {
                $result_total=mysqli_query($con,"select count(*) from doctors where spec='$spec' and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0");
              }
              else if($day!="")
              {
                 $result_total=mysqli_query($con,"select count(*) from doctors,doctors_availability where (doctors.id=doctors_availability.doctor_id) and available_day='$day' and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0");
              }
               else
              {
                 $result_total=mysqli_query($con,"select count(*) from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 group by email");
              }
             // $result_total=mysqli_query($con,"select count(*) from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and spec='$spec' or available_day='$day'");
              //echo $result;
              $requestPageNum = $_GET['pageNum'];
              if (!$requestPageNum) {
                $requestPageNum = 1;
                
              }
              //echo "jfgdfagdkahfgkgdfkafgdkaf     $requestPageNum";
              $array=mysqli_fetch_array($result_total);
              $count_rows=$array[0];
              $pages=$count_rows/5;
              $offset=($requestPageNum-1)*5;

              if($spec!="" and $day!="")
              {
              $result_new=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,available_day,doctors.id,picture from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and spec='$spec' and available_day='$day' and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 limit 5 offset $offset");
             // $result=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,available_day from doctors,doctors_availability where doctors.id=5  limit 1 offset 1 ");
              }
              else if($spec!="")
              {
                $result_new=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,group_concat(available_day),doctors.id,picture from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and spec='$spec' and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 group by email limit 5 offset $offset  ");
              }
              else if($day!="")
              {
                 $result_new=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,available_day,doctors.id,picture from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and available_day='$day' and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 limit 5 offset $offset");
              }
              else
              {
                 $result_new=mysqli_query($con,"select dfname,dlname,spec,email,address,from_hours,to_hours,group_concat(available_day),doctors.id,picture from doctors,doctors_availability where doctors.id=doctors_availability.doctor_id and (dfname like '%$search%' or dlname like '%$search%') and is_deleted=0 group by email limit 5 offset $offset");
              }
             // echo $result->fetch_array;
               $rows=mysqli_num_rows($result_new);
               //echo "result";
    
             //echo $rows;
              if($rows>0)
              {
                echo "<table>
              <tr><td></td>
               <td>Image</td>
              <td>Name</td>
              <td>Specialization</td>
              <td>Email</td>
              <td>Address</td>
              <td>Office hours</td>
              <td>Available days</td>
             
              </tr>";
              while($results=mysqli_fetch_array($result_new))
              {
                echo "<tr>
                <td> <form method='get'> <input type='radio' name='doctor' value=$results[8]></td>
                     <td><img src=images/$results[picture] height90 width=90></td>
                <td>$results[0] $results[1]</td>
                <td>$results[2]</td>
                <td>$results[3]</td>
                <td>$results[4]</td>
                <td>$results[5]-$results[6]</td>
                <td>$results[7]</td>";
              

              }
              echo "</table>";
            }
            else
            {
              echo "<h6>No records found</h6>";
            }
              

              for ($i=0; $i<$pages; $i++) {
                $pageNum = $i + 1;
                $linkAddress = "welcome_new.php?specialization=$spec&day=$day&search_text=$search&filter=Filter+doctors&pageNum=$pageNum";
                echo "<a href=$linkAddress style='color:white'>$pageNum</a>";
                echo " ";
               // echo $pageNum;
              }
              $url=$_SERVER[REQUEST_URI];
              echo "<br/>";
        if($rows>0)
        {
       echo "<input type='hidden' name='url' value=$url ></input>
      <input type='submit' class='w3-btn w3-theme w3-right' id='appointment' name='appointment' value='Get appointment'></input>
       <input type='submit' class='w3-btn w3-theme w3-right' id='favorites' name='favorites' value='Add to favorites'></input>
      </form>";
    }

}
 
                if(isset($_GET['favorites']))
      {
        //echo $pid;
        $did= $_GET['doctor'];
        $url=$_GET['url'];
      //echo $_GET['url'];
        $result_fav=mysqli_query($con,"select pid,did from favorites where pid=$pid and did=$did and is_deleted=0");
        $rows_fav=mysqli_num_rows($result_fav);
   if($did!="")
   {
        if($rows_fav>0)
        {
        
          $message="Already in favorites";
          //echo $message;
        }
        else
        {

  $insert_fav=mysqli_query($con,"insert into favorites(pid,did) values($pid,$did)");
  $message="Added to favorites";
}
echo "<meta http-equiv='refresh' content='0; url=$url'>";

echo "<script>
alert('$message');
</script>";

      
}

else
{
  echo "<meta http-equiv='refresh' content='0;url=$url'>";
  echo "<script>
  alert('Select an option');
  </script>";

}

}
if(isset($_GET['appointment']))
{
  $did= $_GET['doctor'];
   $url=$_GET['url'];
   $_SESSION['did']=$did;
   $_SESSION['pid']=$pid;
  if($did!="")
  {
 header('Location: Appointment.php');
}
else
{
 echo "<meta http-equiv='refresh' content='0;url=$url'>";
  echo "<script>
  alert('Select an option');
  </script>";

}
}
              ?>
      
     


        </div>
      </div>
      
	  
	  <div id = "result">
  </div>
	    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">

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