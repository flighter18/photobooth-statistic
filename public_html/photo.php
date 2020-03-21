<?php
include "dbconnect.php";
# SESSION START
###############
if (session_status() == PHP_SESSION_NONE) { 
        session_start();
} 

if(empty($_SESSION['sessionEventName'])) {
	header("location:home.php");
	exit;
}

# GET EVENTS
##############

$sqlEvent = "SELECT eventName, eventID FROM event ORDER BY eventID DESC";
$resultEvent = mysqli_query($conn,$sqlEvent)or die("mysqli_error($conn))");

if (isset($_POST['choosenEvent'])) {
        $eventID =($_POST['choosenEvent']);
	$sqlEventName = "SELECT eventName FROM event WHERE eventID = $eventID";
	$result = mysqli_query($conn,$sqlEventName)or die("mysqli_error($conn))");
	$row = mysqli_fetch_row($result);
	$eventName = $row[0];
	$_SESSION['sessionEventName']=$eventName;	
	$_SESSION['sessionEventID']=$eventID;
}else{
	$eventID = $_SESSION['sessionEventID'];
	$eventName = $_SESSION['sessionEventName'];
}

# GET ALL PIC FROM EVENT
########################
$sqlPicTaken = "SELECT p.photoDate, p.photoTime, p.photoName, e.eventName, p.photoID FROM photo AS p INNER JOIN event AS e on p.eventID=e.eventID WHERE e.eventID = $eventID ORDER BY p.photoID DESC";
$result = mysqli_query($conn,$sqlPicTaken)or die("mysqli_error($conn)) sql");
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
      <a class="p-2" href="photo.php"><b><b>PHOTO</b></b></a>
      <a class="p-2" href="print.php">PRINT</a><a class="p-2" href="new.php">NEW</a>
      <a class="p-2" href="/mysqladmin">MYADMIN</a>
    </nav>
  </div>
  <div class="text-center">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-12">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h3 class="display-4 text-center bg-info"><b><?php echo $eventName ?></b></h3>
            </div>
            <div class="card-body">
              <div class="btn-group dropright">
		<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> SELECT EVENT </button>
                <div class="dropdown-menu">
                  <form method="post" class="">
                  <?php while($rowEvent = mysqli_fetch_array($resultEvent)) { ?>
                  <a><button type="submit" class="dropdown-item" name="choosenEvent" value="<?php echo $rowEvent['eventID'];?>"><?php echo $rowEvent['eventName'];?></button></a>
                  <div class="dropdown-divider"></div>
                  <?php } ?>
                  </form>
		</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
	<div class="col-md-12">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="table-light" style="">Date</th>
                  <th class="table-light" style="">Time</th>
                  <th style="" class="table-light">Name</th>
                </tr>
		</thead>
		<?php
		while($rowPhoto = mysqli_fetch_array($result)) { ?>
              <tbody>
                <tr>
                  <td><?php echo $rowPhoto['photoDate'];?></td>
                  <td><?php echo $rowPhoto['photoTime'];?></td>
                  <td><?php echo $rowPhoto['photoName'];?></td>
                </tr>
              </tbody>
		<?php } ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>
</body>

</html>
