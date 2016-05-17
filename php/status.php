
<script>

function load() {
    var request = new XMLHttpRequest();
    request.open('GET', 'http://api.openweathermap.org/data/2.5/weather?q=malmo,sweden&appid=7caed7a426f57f9e269ad270296e97dc', true);
    
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            var data = JSON.parse(request.responseText);
            alert (data);
            var temp = data.main.temp;
            
            alert ("" + (temp - 273.15));
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

function setProperty(property, value)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("Failed to set setting");
            }
            //alert (xmlHttp.responseText);
            window.location.href = window.location.href;
        }
    }
    xmlHttp.open("GET", "change_setting.php?key=" + property + "&value=" + encodeURIComponent(value), true); // true for asynchronous
    xmlHttp.send(null);
}

</script>

<?php
include("config.php");
?>


<div class="row">
<div class="col-12">

<div id="settings">
hej hopp

<button onclick="load()">CLICK ME</button>
</div>

</div>

</div>

