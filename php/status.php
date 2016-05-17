
<script>

function load(idOfOutdoorElement, apiKey, location, unit) {
    var request = new XMLHttpRequest();
    request.open('GET', 'http://api.openweathermap.org/data/2.5/weather?q=' + location + '&appid=' + apiKey, true);
    
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
    if ($config['openweatherApiKey'] != null) {
        
    }
?>
<div class="row"><div class="col-6"><div class="temperaturelocation">
<?php echo $config['outdoorLocation'] ?>
</div>
</div>
<div class="col-6"><div class="temperature" id="outdoortemp">
</div>

</div>

</div>

