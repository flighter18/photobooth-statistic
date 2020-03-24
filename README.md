# photobooth-statistic

A Web based statistic Tool for Photobooth by andreknieriem <br>
https://github.com/andreknieriem/photobooth



* In public_html is all the Web Code. <br>
* In the folder mysql is MYSQL dump. This dump is an example.


_**ATTENTION**_

The following photobooth configuration must be adjusted:

### <web_home>/api/print.php

Frist add function:
 
```php
function writeToDB($filename)
{
   # POST TO DB
   $postRequest = array(
       'api_key' => '<password>',
       'sensor' => 'print',
       'printName' => $filename
   );
   $cURLConnection = curl_init('<url>');
   curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
   curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
   $apiResponse = curl_exec($cURLConnection);
   curl_close($cURLConnection);
} 
```
Call the function
```php
writeToDB($filename);
```
**befor**
```php
die(json_encode([
   'status' => 'ok',
   'msg' => $printimage || ,
]));
```

### <web_home>/api/takePic.php

Frist add function:

```php
function writeToDB($file)
{
   # POST TO DB
   $postRequest = array(
       'api_key' => '<password>',
       'sensor' => 'photo',
       'photoName' => $file
   );
   $cURLConnection = curl_init('<url>');
   curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
   curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
   $apiResponse = curl_exec($cURLConnection);
   curl_close($cURLConnection);
}
```

Call the function:
```php
 if ($number == 3) {
       writeToDB($file);
 }
```
**after**
```php
takePicture($filename);
```

Call the function:
```php
writeToDB($file);
```
**befor**
```php
// send imagename to frontend
echo json_encode([
   'success' => 'image',
   'file' => $file,
]);
```

