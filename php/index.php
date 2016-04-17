<html>
<head>
<meta charset="UTF-8">
<title>Home admin</title>
<link rel="stylesheet" href="styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script>
function fetch_temp()
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("FAILED TO GET TEMP!");
            }
            alert (xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", "get_temps.php", true); // true for asynchronous
    xmlHttp.send(null);
}

function menuselected(itemselected) {
    var url = window.location.href;
    if (url.indexOf('?') > -1){
        url = url.substr(0, url.indexOf('?'));
    }
    url += '?menuitem=' + itemselected;
    
    window.location.href = url;
}

</script>


</head>
<body>


<div class="header">
<h1>Temperature Staffanstorpsvägen 29</h1>
</div>

<div class="row">

<?php
    $menuselected = 0;
    $menuitem = $_GET['menuitem'];
    if ($menuitem == 1) {
        $menuselected = 1;
    }
?>

<div class="col-6 menu">
    <input type="checkbox" <?php echo ($menuselected == 0 ? "checked " : "");?> onclick="menuselected(0)" class="menucheckbox" id="menucheckbox1">
<label class="menulabel" for="menucheckbox1" <?php echo ($menuselected == 0 ? "style='background-color :#477186;'" : "") ?> >Status</label>
</div>
<div class="col-6 menu">
    <input type="checkbox" <?php echo ($menuselected == 1 ? "checked " : "");?> onclick="menuselected(1)" class="menucheckbox" id="menucheckbox2">
    <label class="menulabel" for="menucheckbox2" <?php echo ($menuselected == 1 ? "style='background-color :#477186;'" : "") ?> >History</label>
</div>

</div>


<?php
    if ($menuselected == 0) {
        include("current_temp.php");
    } else if ($menuselected == 1) {
        include("history.php");
    }
?>

</body>
</html>