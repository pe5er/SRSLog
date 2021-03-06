<?php
//Include the standard db connect script
include 'database/connect.php';

//Fetch event details from database
if ($result=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM event WHERE 1"))){
  }else{ printf("Failed to get Event Name"); }
  $Event_name = $result['Name'];
  $Event_desc = $result['Description'];
  $Event_img  = $result['Image'];
  $Event_url  = $result['URL'];

//Setup Frontend event title, description and logo
echo '<html><head><title>' . $Event_name . ' Log</title><link rel="stylesheet" type="text/css" href="stylesheet.css?v=' . time() . '">';
echo '<script language="javascript" type="text/javascript" src="jquery.js"></script>';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"></head><body>';
echo '<div class="loginlink" id="loginlink"><a href="users/login.php">Login</a></div>';
echo '<h1>' . $Event_name . '</h1><h3>' . $Event_desc . '</h3>';
echo "<div class='logo'><center><a href='".$Event_url."' target='_blank'><img src='".$Event_img."' alt='YOTA Logo' height='10%' align='middle'></a></center></div>";
echo "<br><br>";
echo '<div class="qso_count" id="qso_count">Total Contacts<br>0</div><br><br>';
echo '<div class="lastrow" id="lastrow"></div>';

//Javascript that pings the database to get the number of contacts. TODO: merge these two scripts
echo "<script type = 'text/javascript'>
setInterval(function(){
function update() {
  $(function () {
    $.ajax({
      url: 'database/getrows.php',
      data: '',
      dataType: 'json',
      success: function(data){
        var qso_count = data;
    	document.getElementById('qso_count').innerHTML = 'Total Contacts' + '<br>' + qso_count;
      }
    });
  });
 }
update();
},1000);</script>"; //Updates every 1000ms

//Javascript that pulls the last contact out of the db
echo "<script type = 'text/javascript'>
setInterval(function(){
function update2() {
  $(function () {
    $.ajax({
      url: 'database/getlastrow.php',
      data: '',
      dataType: 'json',
      success: function(data){
        var row = data;
    	document.getElementById('lastrow').innerHTML = row[0] + ' on ' + row[2];
      }
    });
  });
 }
update2();
},1000);</script>"; //Updates every 1000ms

mysqli_close($con);

echo '</body></html>';
?>
