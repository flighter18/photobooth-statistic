<?php

/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/


# ADDs ALL DATA TO DB

# IF REQUEST COMES FROM DEV IT SAVES THE DATA IN THE DEV DB
#############################################################
include "../dbconnect.php";



if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

# GET LAST EVENTS
################
$sqlLastEvent = "SELECT * , DATE_FORMAT(eventDate,'%d.%m.%Y') as eventDateFormat FROM event ORDER BY eventID DESC limit 1";
$result = mysqli_query($conn,$sqlLastEvent)or die("mysqli_error($conn))");
$row = mysqli_fetch_row($result);
$lastEventId = $row[0];
$currentDate = date('%d.%m.%Y');

#// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
#// If you change this value, the ESP32 sketch needs to match
$api_key_value = "wJwJzori3WarmJReVc";

$api_key= $type = $sensor = $temp = $humidity = $pressure = $lat = $lon ="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    $sensor = test_input($_POST["sensor"]);
  
	 
    if($api_key == $api_key_value) {
    	
	# SENSOR TEMP
	######################
	if($sensor == "temp") {
		$temp = test_input($_POST["temp"]);
		#$humidity = test_input($_POST["humidity"]);
		#$pressure = test_input($_POST["pressure"]);
		
		$sqlTempInsert = "INSERT INTO temp(eventID, tempTemp)
		VALUES ('" . $lastEventId . "','" . $temp . "')";

		#echo $sqlTempInsert;		

		if ($conn->query($sqlTempInsert) === TRUE) {
		    echo "New record created successfully";
		} 
		else {
		    echo "Error: " . $sqlTempInsert . "<br>" . $conn->error;
		}
	    
		$conn->close();
	
	
	} elseif($sensor == "gps") {   
	# SENSOR GPS
	############
		$lat = test_input($_POST["lat"]);
		$lon = test_input($_POST["lon"]);

		# CHECK IF GPS DATA ALREADY EXISTS
		##################################
	
		$sqlCheckGPS = "SELECT eventLat FROM event WHERE eventID = $lastEventId";
	
	
		$result = mysqli_query($conn,$sqlCheckGPS)or die("mysqli_error($conn)) " . mysqli_error($sqlCheckGPS));
		$row = mysqli_fetch_row($result);
		$GPSData = $row[0];

		if(empty($GPSData)) {
			
			$sqlGPSInsert = "UPDATE event SET eventLat = '$lat', eventLon = '$lon' WHERE eventID = $lastEventId";
			

			if ($conn->query($sqlGPSInsert) === TRUE) {
			    echo "New record created successfully";
			}
			else {
			    echo "Error: " . $sqlGPSInsert. "<br>" . $conn->error;
			}

			$conn->close();	
		} else {
			echo "already SET";
		}
	
	} elseif ($sensor == "print") { 
	# SENSOR PRINT
	##############
 		#echo "print";	
		$printName = test_input($_POST["printName"]);
		
		$sqlPrintInsert = "INSERT INTO print(eventID, printName)
		VALUES ('" . $lastEventId . "','" . $printName . "')";

		#echo $sqlPrintInsert;		

		if ($conn->query($sqlPrintInsert) === TRUE) {
		    echo "New record created successfully";
		} 
		else {
		    echo "Error: " . $sqlPrintInsert . "<br>" . $conn->error;
		}
	    
		$conn->close();
	
	} elseif ($sensor == "photo") {   
	# SENSOR PIC
	############
 		#echo "pic";	
		$photoName = test_input($_POST["photoName"]);
		#$photoTime = test_input($_POST["photoTime"]);
		
		#$sqlPhotoInsert = "INSERT INTO photo(eventID, photoName, photoTime)
		
		$sqlPhotoInsert = "INSERT INTO photo(eventID, photoName)
		VALUES ('" . $lastEventId . "','" . $photoName . "')";
		#VALUES ('" . $lastEventId . "','" . $photoName . "','" . $photoTime . "')";


		if ($conn->query($sqlPhotoInsert) === TRUE) {
		    echo "New record created successfully";
		} 
		else {
		    echo "Error: " . $sqlPhotoInsert . "<br>" . $conn->error;
		}
	    
		$conn->close();
	
	
	}else{
		echo "sensor not configured";
	}   
 
   
	}else {
        	echo "Wrong API Key provided blub.";
    	}

}else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
