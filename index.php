<?php
    if(array_key_exists('submit', $_GET)){

        if ($_GET['city']) {
            $apiData = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".
            $_GET['city']."&appid=7cb1990af10b895c9a918e010a818534");
              $weatherArray = json_decode($apiData, true);
              if($weatherArray['cod'] == 200){
                #Lectura De Datos
                $cityName = $weatherArray['sys']['country'];
                $tempCelsius = $weatherArray['main']['temp'] - 273;
                $presAtmos = $weatherArray['main']['pressure'];
                $windSpeed = $weatherArray['wind']['speed'];
                $cloudAll = $weatherArray['clouds']['all'];
                $sunrise = $weatherArray['sys']['sunrise'];
                #$dateSunrise = date("g:i a", $sunrise);
                #$currentTime = date("F j, Y, g:i a");
                
                #Traduccion
                $weather_desc = $weatherArray['weather']['0']['description'];
                if ($weather_desc == "overcast clouds") $weather_desc = "Nublado";
                if ($weather_desc == "clear sky") $weather_desc = "Despejado";
                if ($weather_desc == "scattered clouds") $weather_desc = "Cielo Disperso";
                if ($weather_desc == "light rain") $weather_desc = "Lluvia Ligera";
                if ($weather_desc == "few clouds") $weather_desc = "Pocas Nubes";
                if ($weather_desc == "broken clouds") $weather_desc = "nubes fragmentarias";

                #Impresion De Datos
                $weather ="<b>".$weatherArray['name'].", " .$cityName.": ".intval($tempCelsius)."&deg;C</b> <br>";
                $weather .="<b>Condicion del clima :  ".$weather_desc. "</b><br>";
                $weather .="<b>Presion Atmosferica: </b>" .$presAtmos ." hPa<br> ";
                $weather .="<b>Velocidad del viento: </b>" .$windSpeed." M/S<br> ";
                $weather .="<b>Nubosidad: </b>" .$cloudAll." % <br>";
                #date_default_timezone_set('America/Tijuana'); 
                #$weather .= "<b>Amanecer: </b>" .$dateSunrise."<br>";
                #$weather .= "<b>Tiempo actual: </b>" .$currentTime;
              } else{
                $error = "No se pudo procesar, el nombre de tu ciudad no es válido.";
              }
        }
        elseif (!$_GET['city']) {
          $error = "Su campo de entrada está vacío";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima</title>
    <link rel="stylesheet" href="style.css">
<body>
    <div class="container">
        <h1>Buscador Global del Clima</h1>
        <form method="GET">
            <p><label for="city">Ingrese el nombre de la ciudad</label></p>
            <p><input type="text" name="city" id="city" placeholder="Nombre de Ciudad"></p>
            <button type="submit" name="submit" class="btn btn-success">Buscar</button>
            <div class="weather">
            <?php 
            
            if ($weather){
              echo '<div class="impresion" ">
              '. $weather.' </div>';
            }
            elseif ($error) {
              echo '<div class="alert alert-danger" role="alert">
              '. $error.' </div>';
            }

          ?>

            </div>
        </form>
    </div>
</body>
</html>
