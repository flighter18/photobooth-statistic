<?php
include "dbconnect.php";

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

# SESSION START
###############
if (session_status() == PHP_SESSION_NONE) {     
        session_start();
}   

# GET LAST EVENT ID
###################
$sqlLastEventID = "SELECT eventID FROM event ORDER BY eventID DESC limit 1";
$result = mysqli_query($conn,$sqlLastEventID)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);


# GET EVENTS
##############
$sqlEvent = "SELECT eventName, eventID FROM event ORDER BY eventID DESC";
$resultEvent = mysqli_query($conn,$sqlEvent)or die("mysqli_error($conn))");

if (isset($_POST['choosenEvent'])) {
	$lastEventId =($_POST['choosenEvent']);
	$sqlLastEvent = "SELECT * , DATE_FORMAT(eventDate,'%d.%m.%Y') as eventDateFormat FROM event WHERE eventID = $lastEventId";
}else{
	
	if (isset($_SESSION['sessionEventID'])) {
		$lastSessionID = $_SESSION['sessionEventID'];
		$sqlLastEvent = "SELECT * , DATE_FORMAT(eventDate,'%d.%m.%Y') as eventDateFormat FROM event WHERE eventID = $lastSessionID";
	}else{
		$sqlLastEvent = "SELECT * , DATE_FORMAT(eventDate,'%d.%m.%Y') as eventDateFormat FROM event ORDER BY eventID DESC limit 1";
	}	
}

# GET LAST EVENT
################
#$sqlLastEvent = "SELECT * , DATE_FORMAT(eventDate,'%d.%m.%Y') as eventDateFormat FROM event ORDER BY eventID DESC limit 1";
$result = mysqli_query($conn,$sqlLastEvent)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);
$lastEventId = $row[0];
$lastEventName = $row[2];
$lastEventLat = $row[3];
$lastEventLon = $row[4];
$lastEventUrl = $row[5];
$lastEventDate = $row[6];
mysqli_free_result($result);

# SESSION VARIABLE
##################
$_SESSION['sessionEventName']=$lastEventName;
$_SESSION['sessionEventID']=$lastEventId;

# GET NUMBER OF PIC TAKEN
###############
$sqlPicTaken = "SELECT COUNT(*) FROM photo WHERE eventID = $lastEventId";
$result = mysqli_query($conn,$sqlPicTaken)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);
$picTaken = $row[0];

# GET NUMBER OF PRINTED PIC
##############
$sqlPrinted = "SELECT COUNT(*) FROM print WHERE eventID = $lastEventId";
$result = mysqli_query($conn,$sqlPrinted)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);
$printed = $row[0];

# GET TEMP
##############
$sqlTemp = "SELECT tempTemp FROM temp WHERE eventID = $lastEventId ORDER BY tempID DESC LIMIT 1 ";
$result = mysqli_query($conn,$sqlTemp)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);
$temp = $row[0];

# GET TEMP CHART
##############
$sqlTempChart = "SELECT t.tempTemp, t.tempHumidity, t.tempPressure, UNIX_TIMESTAMP(CONCAT_WS(\" \",t.tempDate, t.tempTime)) AS datetime FROM temp AS t INNER JOIN event AS e ON t.eventID=e.eventID WHERE t.eventID = $lastEventId ORDER BY datetime DESC";
$result = mysqli_query($conn,$sqlTempChart)or die("mysqli_error($conn))");
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time',
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperature (°C)',
  'type' => 'number'
 ),
 array(
  'label' => 'Humiditiy',
  'type' => 'number'
 )
);
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["datetime"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["tempTemp"]
     );
 $sub_array[] =  array(
      "v" => $row["tempHumidity"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);


# GET Shortener CLICKS (polr)
################

$url = parse_url($lastEventUrl);
$content = $url["path"];
$urlEnding = trim(str_replace('/', '',$content)); 
$api="<API KEY>";
$data = "key=$api&url_ending=$urlEnding&response_type=json";

// Verbindungsaufbau mit cURL
$ch = curl_init('<Shortener URL>');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$json = curl_exec($ch);
curl_close($ch);
$result = json_decode($json, true);
$clicks =  $result["result"]["clicks"];

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

  <!-- TEMP Chart -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
           google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
     title:'Temp Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'},
        hAxis: {
        format: 'dd.MM.yyyy HH:mm'
    }
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script> 

</head>

<body class="bg-light">
  <div class="d-flex flex-column flex-md-row align-items-center p-3 mb-3 box-shadow border-bottom">
    <a class="my-0 mr-md-auto font-weight-normal" href="home.php">Photobooth Stats</a>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2" href="index.php" style=""><b><b>HOME</b></b></a>
      <a class="p-2" href="photo.php">PHOTO</a>
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
              <h3 class="display-4 text-center bg-info"><b><?php echo $lastEventName ?></b></h3>
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
      <div class="row pt-4">
        <div class="col-md-6">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Event Date</h4>
            </div>
            <div class="card-body">
              <h1><?php echo $lastEventDate ?></h1>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Event Url</h4>
            </div>
            <div class="card-body">
              <h1><?php if (empty($lastEventUrl)){ echo "-";}else{ ?> <a href="<?php echo $lastEventUrl ?>"><?php echo $lastEventUrl ?></a> <?php } ?></h1>
		<?php if (!empty($clicks)) { ?> <h2>  <?php echo $clicks . " Clicks" ?></h2> <?php } ?>
	      </div>
          </div>
        </div>
      </div>
      <div class="row pt-4">
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Pic Taken</h4>
            </div>
            <div class="card-body">
              <h1><?php if (empty($picTaken)){ echo 0;}else{echo $picTaken;} ?></h1>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Printed</h4>
            </div>
            <div class="card-body">
              <h1><?php if (empty($printed)){ echo 0;}else{echo $printed;} ?></h1>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Current Temp</h4>
            </div>
            <div class="card-body">
              <h1><?php if (empty($temp)){ echo 0;}else{echo $temp;} ?> °C</h1>
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
          <h3 class="text-center p-1 bg-info">Location</h3>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
	<?php if (empty($lastEventLat)) { ?>
	<div class="col-md-12"><iframe width="100%" height="400" src="https://maps.google.com/maps?q=30.43752,-30.81074&hl=en&z=14&amp;output=embed" scrolling="no" frameborder="0"></iframe></div>
      	<?php }else{ ?>
	<div class="col-md-12"><iframe width="100%" height="400" src="https://maps.google.com/maps?q=<?php echo $lastEventLat; ?>,<?php echo $lastEventLon; ?>&hl=en&z=14&amp;output=embed" scrolling="no" frameborder="0"></iframe></div>
	<?php } ?>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="text-center p-1 bg-info">Temp</h3>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
      <div id="line_chart" style="width: 100%; height: 300px;"></div>
	</div>
	</div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>
</body>
</html>
