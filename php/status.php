
<script>

function load(idOfOutdoorElement, apiKey, location, unit) {
    if (apiKey == null || apiKey.trim() == "") {
        return;
    }
    var request = new XMLHttpRequest();
    var requestStr = 'http://api.openweathermap.org/data/2.5/weather?q=' + location + '&appid=' + apiKey;
    request.open('GET', requestStr, true);
    
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            var data = JSON.parse(request.responseText);
            var temp = data.main.temp;
            
            var theElement = document.getElementById(idOfOutdoorElement);
            
            tempStr = "";
            if (unit === "kelvin") {
                tempStr = (Math.round(temp * 10) / 10) + " °K"
            } else if (unit === "fahrenheit") {
                var num = (1.8 * (temp - 273.15) + 32);
                tempStr =  (Math.round(num * 10) / 10) + " °F";
            } else {
                var num = temp - 273.15;
                tempStr = "" + (Math.round(num * 10) / 10) + " °C";
            }
            
            theElement.innerHTML = tempStr;
        } else {
            // We reached our target server, but it returned an error
            alert ("error! " + request.responseText);
        }
    };
    
    request.onerror = function() {
        alert("There was a connection error of some sort");
    };
    
    request.send();
}

<?php
    include("config.php");

    echo 'load("outdoortemp", "' . $config['openweatherApiKey'] . '","'. $config['outdoorLocation'] . '","'. $config['unit'] . '")'
    
?>

</script>



<?php
    if ($config['openweatherApiKey'] != null && trim($config['openweatherApiKey']) != '') {
        echo '<div class="row">';
        echo '<div class="col-6">';
        echo '<div class="temperaturelocation">';
        echo $config['outdoorLocation'];
        echo '</div>';
        echo '</div>';
        echo '<div class="col-6">';
        echo '<div class="temperature" id="outdoortemp">';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }
    
    if ($config['deviceIPs'] != null && $config['devices'] != null && trim($config['devices']) != '' && trim($config['deviceIPs']) != '') {
        
        $IPs = explode(',', $config['deviceIPs']);
        $devices = explode(',', $config['devices']);
        foreach($IPs as $index => $IP) {
            $IP = trim($IP);
            echo '<div class="row">';
            echo '<div class="col-6">';
            echo '<div class="temperaturelocation">';
            echo $devices[$index];
            echo '</div>';
            echo '</div>';
            echo '<div class="col-6">';
            echo '<div class="temperature" id="fetchedOutdoortemp">';
            echo '<script>alert("Det här är ' . $IP . '");</script>';
            echo '3';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No configured devices";
    }
?>

