<?php
include "dbconnect.php";

# SESSION START
###############
if (session_status() == PHP_SESSION_NONE) { 
        session_start();
} 

# GO HOME AFTER SESSION TIMEOUT
if(empty($_SESSION['sessionEventName'])) {
        header("location:home.php");
	exit;
}


if (isset($_POST['newEvent'])) {

	# GET VARIABLE FROM POST
	$newEventName = $_POST['newEventName'];
	$newEventDate = $_POST['newEventDate'];
	if (empty($_POST['newEventUrl'])){
	$newEventUrl = "-";
	}else{
	$newEventUrl = $_POST['newEventUrl'];
	}
	
	# INSERT INTO TABLE
	$sqlNewEvent = "INSERT INTO event(eventName,eventDate,eventUrl) VALUES ('$newEventName', '$newEventDate', '$newEventUrl')" or die(mysqli_error());
	if(mysqli_query($conn,$sqlNewEvent)) {
		$sqlLog="SUCCESS";
	}else{
		$sqlLog=(mysqli_error($conn));
	}
}


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- PAGE settings -->
  <link rel="icon" href="https://templates.pingendo.com/assets/Pingendo_favicon.ico">
  <title>Photobooth Web</title>
  <meta name="description" content="Wireframe design of a pricing table by Pingendo">
  <meta name="keywords" content="Pingendo bootstrap example template wireframe pricing table">
  <meta name="author" content="Pingendo">
  <!-- CSS dependencies -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/wireframe.css">
</head>

<body class="bg-light">
  <div class="d-flex flex-column flex-md-row align-items-center p-3 mb-3 box-shadow border-bottom">
   <a class="my-0 mr-md-auto font-weight-normal" href="home.php">Photobooth Stats</a> 
	<nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2" href="index.php" style=""><b><b><span style="font-weight: normal;">HOME</span></b></b></a>
      <a class="p-2" href="photo.php"><b><b><span style="font-weight: normal;">PHOTO</span></b></b></a>
      <a class="p-2" href="print.php"><b><b contenteditable="true"><span style="font-weight: normal;">PRINT</span></b></b></a><a class="p-2" href="new.php"><b><b contenteditable="true"><span style="">NEW</span></b></b></a>
      <a class="p-2" href="/mysqladmin">MYADMIN</a>
    </nav>
  </div>
  <div class="text-center">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-12">
          <form method="post" class="">
            <div class="form-group"> <label>Event Name</label> <input type="text" class="form-control" placeholder="Name" name="newEventName" required="required"> </div>
            <div class="form-group"> <label>Event Date</label> <input type="date" class="form-control" placeholder="Date" required="required" name="newEventDate"> </div>
            <div class="form-group"> <label>Event URL</label> <input type="text" class="form-control" placeholder="URL" name="newEventUrl"> </div> <button type="submit" name="newEvent" class="btn btn-primary">Submit</button>
          </form>

        	<?php if(isset($sqlLog)){
			echo $sqlLog;
		} ?> 
	  </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>
</body>

</html>
