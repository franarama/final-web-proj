<!DOCTYPE html>
<html lang="en" >

<head>
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
		<input type="range" min="1" max="200" value=<?php echo $_SESSION['radius'];?> class="slider" id="range" name="radius"></input><br>
		<label class='modal-label'>Value:&nbsp;</label>
		<p id="slider-output"></p>
		<input type="submit" class="btn btn-primary" value="Submit" id="radius-submit-btn"></input>
	</form>
  </div>

  <div class="container-fluid" id="blanket">

  <div class="container-fluid">
          <div class="main-page">

		<div class="container-fluid" id="cog-container">
			<a class="glyphicon glyphicon-cog" href="account.php" title="Account Settings" id="cog"></a>
		</div>
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
// for the slider on log in/sign up to show slider value
var slider = document.getElementById("range");
var output = document.getElementById("slider-output");
// fix this later - is null when logged in
//output.innerHTML = slider.value + " km";
/*
slider.oninput = function() {
	output.innerHTML = this.value + " km";
}
*/
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
		if (data.length > 0) {
			str = '<table class="table" id="rooms-table">';
                            for (var i = 0; i < data.length; i++) {
                                str += '<tr>';
                                for (var p in data[i]) {
                                   if (p == "date_created") r_date = data[i][p];
				   if (p == "title") title = data[i][p];
				   if (p == "user_id") user_id = data[i][p];
				}
				str += '<td><div id="room-head">' + title + '</div><br>' + r_date + '</td>';
				str += '<td><p id="distance-p">Distance: 1.4km</p></td>';
				str += '<td><button class="btn btn-primary">Join</button></td>';
				if (user_id == <?php echo $_SESSION['userid'] ?>) {
					str += '<td><button class="btn btn-danger">Delete</button></td>';
				}
				else str += '<td></td>';
                                str += '</tr>';
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
