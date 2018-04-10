<?php if ('session_id' == "") session_start(); ?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <?php
  	include_once('functions.php');
  ?>
  <meta charset="UTF-8">
  <title>WhatsUp? Login</title>
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/main.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
           <li><a class="navbar-brand">Whatsup?</a></li>
        </div>
    </div>
  </nav>
  
  <div id="blanket-full"></div>
  <div id='add-room-modal' class='modal-window'>
  	<h2>Add a room</h2><br>
	<form class='add-room-form' method='post' action='controller.php'>
		<input type='hidden' name='page' value='MainPage'></input>
		<input type='hidden' name='command' value='add-room'></input>
		<p class="error"><?php if (isset($_SESSION['add-error'])) echo $_SESSION['add-error']; ?></p>
		<label class='modal-label'>Room title:&nbsp;</label>
		<input type="text" placeholder="&nbsp;Enter room title" name='title' required="required"></input><br>
		<input type="submit" class="btn btn-primary" value="Submit"></button>
		<input type="cancel" id="cancel-add-room" class="btn btn-primary" value="Cancel"></button>
		<input type="reset" class="btn btn-prmiary" value="Reset"></button>
	</form>
  </div>
  <div id='get-radius-modal' class='modal-window'>
  	<h2>Set your search radius</h2><br>
	<form class='set-radius-form' method='post' action='controller.php'>
		<input type='hidden' name='page'value='MainPage'></input>
		<input type='hidden' name='command' value='set-radius'></input>
		<p class="error"><?php if(isset($_SESSION['update-error'])) echo $_SESSION['update-error']; ?></p>
		<p>The default search radius is 50km. You can change it now or later.</p>
		<label class='modal-label' id="search-label">Search radius:&nbsp;</label>
		<input type="range" min="1" max="200" value=<?php echo get_radius($_SESSION['username']);?> class="slider" id="range" name="radius"></input><br>
		<label class='modal-label'>Value:&nbsp;</label>
		<p id="slider-output"></p>
		<input type="submit" class="btn btn-primary" value="Submit" id="radius-submit-btn"></input>
	</form>
  </div>

  <div class="container-fluid" id="blanket">

  <div class="container-fluid">
          <div class="main-page">

		<!-- account settings drop down -->
		<div class="container-fluid" id="account-container">
			<div class="btn-group dropdown">
				<button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" id="drop-btn">Options
				<span class="caret"</span></button>
			<ul class="dropdown-menu">
				<li><a href="logout.php">Logout</a></li>
				<li><a href="controller.php?id=<?php echo $_SESSION['userid']; ?>"> Delete account</a></li>
				<li><a id="radius-btn">Set radius<a></li>
			</ul>
			</div>
		</div>
		<!-- end of account settings drop down -->
		<div class="container-fluid"><h1>Nearby Chat Rooms</h1></div>
		<div class="container-fluid" id="tools-container">
                    <table class="table">
			<thead><tr>
			  <th style='text-align:left;border:none;'><label>Sort by:</label>&nbsp;<select class="selectpicker show-tick"><option>Closest distance</option></select></th>			       <th style='text-align:center;border:none;'><input type="text" placeholder="&nbsp;Search here" id="search-bar"></input></th>
			  <th style='text-align:right;border:none;'><button class="glyphicon glyphicon-plus" title="Add chat room" id="add-room"></button></th>
			</tr></thead>
		    </table>
		</div>
		<div id="rooms-list"></div>
          </div>
      </div>
  </div>

<script>
$(document).ready(function() {

if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(addPosition);
}
else {
	window.alert("Geolocation not supported by your browser");
}

function addPosition(position) {
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;
	var url = "functions.php";
	var query = {latitude: latitude, longitude: longitude};
	$.post(url, query, function(data) {
	});
	
	//$.post("https://cs.tru.ca/~framunnow8/Project/final-proj/functions.php", {latitude:latitude, longitude:longitude});
}
});
</script>
<script>
$(document).ready(function() {
<?php
	if (isset($_SESSION['display_type'])) {
		if ($_SESSION['display_type'] == 'set-radius') {
			echo "$('#get-radius-modal').show();";
			echo "$('#add-room-modal').hide();";
			echo "$('#blanket-full').show();";
		}
		else if ($_SESSION['display_type'] !== 'add-room' && $_SESSION['display_type'] !== 'set-radius') {
				echo "$('#get-radius-modal').hide();";
				echo "$('#add-room-modal').hide();";
				echo "$('#blanket-full').hide();";
			
		}
		else if ($_SESSION['display_type'] == 'add-room') {
				echo "$('#blanket-full').show();";
				echo "$('#add-room-modal').show();";
				echo "$('#get-radius-modal').hide();";
			
		}
	}
	else {
		
			echo "$('#add-room-modal').hide();";
			echo "$('#blanket-full').hide();";
			echo "$('#set-radius-modal').hide();";
			
	}
?>
});

$('#add-room').click(function() {
	$('#add-room-modal').show();
	$('#blanket-full').show();	
});
$('#blanket-full').click(function() {
	$('.modal-window').hide();
	$('#blanket-full').hide();
});
$('#cancel-add-room').click(function() {
	$('#add-room-modal').hide();
	$('#blanket-full').hide();
});
$('#radius-btn').click(function() {
	$('#get-radius-modal').show();
	$('#blanket-full').show();
});

// for the slider on log in/sign up to show slider value
var slider = document.getElementById("range");
var output = document.getElementById("slider-output");
output.innerHTML = slider.value + " km";

slider.oninput = function() {
	output.innerHTML = this.value + " km";
}

// calculates distance between two points
function get_distance(latitude1, longitude1, latitude2, longitude2) {
	var ans = Math.sqrt((Math.pow((latitude2 - latitude1), 2) + Math.pow((longitude2 - longitude1), 2)));
	return ans.toFixed(2);
} 
</script>
<script>
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	if (this.readyState == 4 & this.status == 200) {
		var data = JSON.parse(this.responseText);
		var str = "";
		var title = "";
		var r_date = "";
		var user_id;
		var room_id;
		var r_lat;
		var r_long;
		var u_lat = <?php echo $_SESSION['latitude'];?>;
		var u_long = <?php echo $_SESSION['longitude']; ?>;
		var rad = <?php echo get_radius($_SESSION['username']);?>;
		if (data.length > 0) {
			str = '<table class="table" id="rooms-table">';
                            for (var i = 0; i < data.length; i++) {
                                str += '<tr>';
                                for (var p in data[i]) {
                                   if (p == "date_created") r_date = data[i][p];
				   if (p == "title") title = data[i][p];
				   if (p == "user_id") user_id = data[i][p];
				   if (p == "room_id") room_id = data[i][p];
				   if (p == "latitude") r_lat = data[i][p];
				   if (p == "longitude") r_long = data[i][p];
				}
				if (get_distance(r_lat, r_long, u_lat, u_long) <= rad) { 
					str += '<td><div id="room-head">' + title + '</div><br><p id="p-date">' + r_date + '</p></td>';
					str += '<td><p id="distance-p"><i>' + get_distance(r_lat, r_long, u_lat, u_long) + ' km away</i></p></td>';
					str += '<td><button class="btn btn-primary">Join</button></td>';
					if (user_id == <?php echo $_SESSION['userid'] ?>) {
						str += '<td><a class="btn btn-danger" href="functions.php?room_id='+room_id+'&uid=<?php echo $_SESSION['userid']?>&command=delete-room&page=MainPage">Delete</a></td>';
					}
					else str += '<td></td>';
                                str += '</tr>';
				}
                            }
                            str += '</table>';
		}
		$('#rooms-list').html(str);
	}
};
var url='//cs.tru.ca/~framunnow8/Project/final-proj/controller.php';
var query = "page=MainPage&command=list-rooms";
xhttp.open('POST', url);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send(query);
</script>
</body>

</html>
