<?php
$status="";
$msg="";
$city="";
$mainCondition = "";

if(isset($_POST['submit']))
{
    $city=$_POST['city'];
    $url="https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=b86478b498e1b8b19398c1e9324abf6e&units=metric";
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result=curl_exec($ch);
    curl_close($ch);
    $result=json_decode($result,true);
    if($result['cod']==200){
        $status="yes";
        // echo $status;
        $lon=$result['coord']['lon'];
        $lat=$result['coord']['lat'];
        $temp = $result['main']['temp'];
        $humidity = $result['main']['humidity'];
        $visibility = $result['visibility'];
        $country = $result['sys']['country'];
        $tempDesc = $result['weather'][0]['description'];
        $mainCondition = $result['weather'][0]['main'];
        $city = $result['name'];
        echo $tempDesc;

    }else{
        $msg=$result['message'];
        // echo $msg;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Dani's Weather App</title>
</head>

<body>
    <h2 class="heading medium">Enter your city below manually:</h2>
    <form id="input-form" class="container" method="post">
        <input class="form-item input_text" type="text" name="city" value="<?php echo $city?>" placeholder="Enter the city..." />
        <input class="form-item button" type="submit" value="Submit" name="submit" />
        <?php echo $msg?>
    </form>

    <?php if($status=="yes"){?>
    <div class="container" id="info-city">
        <h1 class="large city"><?php echo $city ?></h1>
        <p class="paragraph country"><?php echo $country ?></p>
    </div>

    <div class="large display">
        <h2 class= "degree"></h2> 
    </div>
    <div class="container" id="info-items">
        <div class="info-item" id="info-condition">
    <!-- < class="large display"></  echo '<script type="text/javascript">',
                'function func (){',
                '   setIcon("weather_icon","' .$mainCondition .'");',
                '}',
                '</script>';
            ?> -->
            <canvas id="weather_icon" width="150" height="150"></canvas>
            <p class="paragraph description"><?php echo $tempDesc ?></p>
        </div>
        <div class="info-item" id="info-humidity">
          <svg xmlns="http://www.w3.org/2000/svg" height="6rem" width="6rem"  fill="currentColor" class="bi bi-droplet-fill" viewBox="0 0 16 16">
            <path d="M8 16a6 6 0 0 0 6-6c0-1.655-1.122-2.904-2.432-4.362C10.254 4.176 8.75 2.503 8 0c0 0-6 5.686-6 10a6 6 0 0 0 6 
            6ZM6.646 4.646l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448c.82-1.641 1.717-2.753 2.093-3.13Z"/>
          </svg>
            <p class="paragraph humidity"><?php echo $humidity ?>%</p>
        </div>
        <div class="info-item" id="info-visibility">
            <svg xmlns="http://www.w3.org/2000/svg" height="6rem" width="6rem" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
            </svg>
            <p class="paragraph visibility"><?php echo $visibility ?>m</p>
        </div>
    </div>
    <script       
    src="https://code.jquery.com/jquery-3.1.1.js"
    integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
    crossorigin="anonymous"></script>
    <script src="skycons.js"></script>
    <script src="app.js"></script>
    <?php } ?>
</body>

</html>