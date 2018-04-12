<?php if (session_id() == '') session_start();
include_once('functions.php');
$_SESSION['room_id'] = $_GET['room_id'];
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>WhatsUp</title>
  <link rel="stylesheet" href="css/chat.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/custom.css">

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

<div class="container-fluid" id="blanket">

<div class="container-fluid">
	<div class="main-page">
		<div class="container-fluid"><h1><?php echo get_room_title($_GET['room_id']);?></h1></div>
            	<div class="chat">
                	<div id="chatOutput"></div>
                	<textarea id="chatInput" type="text" placeholder="Type message here" maxlength="128"></textarea>
                	<button id="chatSend" class="btn btn-primary">Send</button>
            	</div>
          </div>
</div>

</div>

<script>
$(document).ready(function () {
    var chatInterval = 250; //refresh interval in ms
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");

    function sendMessage() {
        var username = "<?php echo $_SESSION['username']; ?>";
        var chatInputString = $chatInput.val();

        $.get("write.php", {
            username: username,
            text: chatInputString
        });

        retrieveMessages();
    }

    function retrieveMessages() {
        $.get("read.php", function (data) {
            $chatOutput.html(data); //Paste content into chat output
        });
    }

    $chatSend.click(function () {
        sendMessage();
    });

    setInterval(function () {
        retrieveMessages();
    }, chatInterval);
});

</script>
</body>

</html>
