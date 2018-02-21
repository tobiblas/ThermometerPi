<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'x');
    <?php
    include("db.php");

    $location = "";
    $locations = array();
    $query =  "select distinct location from temperature";

    foreach ($dbh->query($query) as $row) {
        echo "data.addColumn('number', '" . $row[0] . "');\n";
        array_push($locations, $row[0]);
    }?>
    data.addColumn({type: 'string', role: 'annotation'});
    <?php
    date_default_timezone_set('GMT');
    $dataPoints = array();
    foreach ($locations as &$value) {
        $query = "select timestamp,temp,label from temperature where location = '" . $value . "'";
        foreach ($dbh->query($query) as $row) {
            $epoch = $row[0];
            $dt = new DateTime("@$epoch");
            if ($row[2] == null) {
                $dataPoints[ $dt->format('Y-m-d H:i:s') ][$value] = $row[1];
            } else {
                $dataPoints[ $dt->format('Y-m-d H:i:s') ][$row[2]] = $row[1];
            }
        }
    }
    ksort($dataPoints);

    #print_r($dataPoints);

    #data.addRow(["J", null,  3.5, 0.5, 1]);
    #data.addRow(["K", 'Pellets av',  4, 1, 0.5]);
    # ,['2016-11-09 04:00:05',-0.02, null, null, null]

    # k är datum, v är en ARRAY name -> temp, där name kan vara en annotation
    foreach ($dataPoints as $k => $v) {
        #echo ",['" . $k . "'";
        echo 'data.addRow(["' . $k . '"';

        $locationFound = FALSE;
        foreach ($locations as &$value) {
            $temp = $v[$value];
            if ($temp != null) {
                $locationFound = TRUE;
                echo "," . $temp;
            } else {
                echo ",null";
            }
        }
        if ($locationFound == TRUE) {
          echo ',"' . key($v) . '"';
        }
        echo "]";
    }
    echo ");\n";
    ?>

    new google.visualization.LineChart(document.getElementById('visualization')).
      draw(data, {
        title: 'Temperature',
        curveType: 'function',
        legend: { position: 'bottom' },
        annotations: {
                style: 'line'
            }
        });
      }


</script>


</head>
<body>
<div id="curve_chart" style="width: 100%; height: 100%;"></div>
</body>
</html>
