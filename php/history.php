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
        echo "data.addColumn('number', '" . $row[0] . "');\n";
        array_push($locations, $row[0]);
    }
    date_default_timezone_set('GMT');
    $dataPoints = array();
    foreach ($locations as &$value) {
        $query = "select timestamp,temp,label from temperature where location = '" . $value . "'";
        foreach ($dbh->query($query) as $row) {
            $epoch = $row[0];
            $dt = new DateTime("@$epoch");
            if ($row[2] == null) {
                $dataPoints[ $dt->format('Y-m-d H:i') ][$value] = $row[1];
            } else {
                $dataPoints[ $dt->format('Y-m-d H:i') ][$row[2]] = $row[1];
                $dataPoints[ $dt->format('Y-m-d H:i') ][$value] = $row[1];
            }
        }
    }
    ksort($dataPoints);

    #print_r($dataPoints);

    #data.addRow(["J", null,  3.5, 0.5, 1]);
    #data.addRow(["K", 'Pellets av',  4, 1, 0.5]);
    # ,['2016-11-09 04:00:05',-0.02, null, null, null]

#    [2018-02-21 10:59] => Array
#         (
#             [Pellets av] => 0.74
#             [Malmö, Sweden] => 0.74
#         )
#
#     [2018-02-21 11:00] => Array
#         (
#             [Malmö, Sweden] => 0.74
#             [Kitchen] => 23.125
#         )
#print_r($locations);
    # k är datum, v är en ARRAY name -> temp, där name kan vara en annotation
    foreach ($dataPoints as $k => $datapoint) {
        echo 'data.addRow(["' . $k . '"';
        $orderOfTemps = array();
        array_push($orderOfTemps, null);
        for ($x = 0; $x < sizeof($locations); $x++) {
          array_push($orderOfTemps, null);
        }
        foreach ($datapoint as $locationOrLabel => $temp) {
          #echo ( $locationOrLabel);
            if (in_array($locationOrLabel, $locations)) {
              $indexInArray = array_search("$locationOrLabel",$locations);
          #    echo "searching for " . $locationOrLabel . " in locations. Result " . $indexInArray;
              $orderOfTemps[$indexInArray+1] = $temp;
            } else {
              $orderOfTemps[0] = $locationOrLabel;
            }
        }
        #echo "orderoftemps:";
        #print_r($orderOfTemps);

        $label = $orderOfTemps[0];
        if ($label == null) {
          echo ',null';
        } else {
          echo ',"' . $label . '"';
        }

        for ($x = 1; $x < sizeof($orderOfTemps); $x++) {
          if ($orderOfTemps[$x] == null) {
            echo ',null';
          } else {
            echo ',' . $orderOfTemps[$x];
          }
        }

        echo "]";
        echo ");\n";
    }

    ?>

    var options = {
    title: 'Temperature',
    curveType: 'function',
    legend: { position: 'bottom' },
    annotations: {
            style: 'line'
        }
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
