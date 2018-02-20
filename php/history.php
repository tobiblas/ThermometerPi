<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'x');
    data.addColumn({type: 'string', role: 'annotation'});

    <?php
    include("db.php");

    $location = "";
    $locations = array();
    $query =  "select distinct location from temperature";

    foreach ($dbh->query($query) as $row) {
        echo "data.addColumn('number', '" . $row[0] . "');";
        array_push($locations, $row[0]);
    }

    date_default_timezone_set('GMT');
    $dataPoints = array();
    foreach ($locations as &$value) {
        $query = "select timestamp,temp,label from temperature where location = '" . $value . "'";
        foreach ($dbh->query($query) as $row) {
            $epoch = $row[0];
            $dt = new DateTime("@$epoch");
            $dataPoints[ $dt->format('Y-m-d H') ][$value] = $row[1];
        }
    }
    ksort($dataPoints);

    #print_r($dataPoints);

    foreach ($dataPoints as $k => $v) {
        echo ",['" . $k . "'";
        foreach ($locations as &$value) {
            $temp = $v[$value];
            if ($temp == null) {
                echo ", null" ;
            } else {
                echo "," . $temp;
            }

        }
        echo "]\n";
    }
    echo "];";
    ?>

    var data = google.visualization.arrayToDataTable(dataArray);

    var options = {
    title: 'Temperature',
    curveType: 'function',
    legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
}


</script>


</head>
<body>
<div id="curve_chart" style="width: 100%; height: 100%;"></div>
</body>
</html>
