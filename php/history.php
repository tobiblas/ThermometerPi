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
        if ($locationFound == FALSE) {
          echo ',"' . 'PELLETS ARE POU' . '"';
        } else {
          echo ',null';
        }
        echo "]";
        echo ");\n";
    }

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'x');
    data.addColumn('number', 'Malmö, Sweden');
data.addColumn('number', 'Kitchen');
data.addColumn('number', 'UpperHallway');
data.addColumn('number', 'Livingroom');
    data.addColumn({type: 'string', role: 'annotation'});
    data.addRow(["2016-11-09 04:00:05",-0.02,null,null,null]);
data.addRow(["2016-11-09 04:00:06",null,19.812,null,null]);
data.addRow(["2016-11-09 04:00:07",null,null,17.562,null]);
data.addRow(["2016-11-09 15:00:06",1.49,null,null,null]);
data.addRow(["2016-11-09 15:00:07",null,21.187,null,null]);
data.addRow(["2016-11-09 15:00:09",null,null,20.25,null]);
data.addRow(["2016-11-10 04:00:06",-0.99,null,null,null]);
data.addRow(["2016-11-10 04:00:07",null,21.375,null,null]);
data.addRow(["2016-11-10 04:00:08",null,null,20.312,null]);
data.addRow(["2016-11-10 15:00:04",0.74,null,null,null]);
data.addRow(["2016-11-10 15:00:05",null,21.375,null,null]);
data.addRow(["2016-11-10 15:00:06",null,null,19.375,null]);
data.addRow(["2016-11-11 04:00:10",-1.03,null,null,null]);
data.addRow(["2016-11-11 04:00:11",null,21.937,null,null]);
data.addRow(["2016-11-11 04:00:15",null,null,19.625,null]);
data.addRow(["2016-11-11 15:00:05",2.5,null,null,null]);
data.addRow(["2016-11-11 15:00:06",null,23.187,null,null]);
data.addRow(["2016-11-11 15:00:07",null,null,20.625,null]);
data.addRow(["2016-11-12 04:00:08",-5.83,null,null,null]);
data.addRow(["2016-11-12 04:00:09",null,21.625,null,null]);
data.addRow(["2016-11-12 04:00:10",null,null,21.187,null]);
data.addRow(["2016-11-12 14:12:57",3.99,null,null,null]);
data.addRow(["2016-11-12 14:12:59",null,20.75,null,null]);
data.addRow(["2016-11-12 14:13:30",null,null,17.0,null]);
data.addRow(["2016-11-13 03:00:03",-4.02,null,null,null]);
data.addRow(["2016-11-13 03:00:05",null,21.187,null,null]);
data.addRow(["2016-11-13 03:00:06",null,null,20.937,null]);
data.addRow(["2016-11-13 14:00:03",2.97,null,null,null]);
data.addRow(["2016-11-13 14:00:05",null,21.562,null,null]);
data.addRow(["2016-11-13 14:00:06",null,null,20.812,null]);
data.addRow(["2016-11-14 03:00:05",-0.28,null,null,null]);
data.addRow(["2016-11-14 03:00:06",null,21.625,null,null]);
data.addRow(["2016-11-14 03:00:08",null,null,21.375,null]);
data.addRow(["2016-11-14 14:00:03",3.48,null,null,null]);
data.addRow(["2016-11-14 14:00:04",null,22.937,null,null]);
data.addRow(["2016-11-14 14:00:05",null,null,22.187,null]);
data.addRow(["2016-11-15 03:00:13",3.99,null,null,null]);
data.addRow(["2016-11-15 03:00:14",null,22.25,null,null]);
data.addRow(["2016-11-15 03:00:15",null,null,22.625,null]);
data.addRow(["2016-11-15 14:00:04",6.5,null,null,null]);
data.addRow(["2016-11-15 14:00:06",null,22.437,null,null]);
data.addRow(["2016-11-15 14:00:07",null,null,23.0,null]);
data.addRow(["2016-11-16 03:00:07",4.48,null,null,null]);
data.addRow(["2016-11-16 03:00:08",null,23.375,null,null]);
data.addRow(["2016-11-16 03:00:09",null,null,19.375,null]);
data.addRow(["2016-11-17 03:00:05",5.0,null,null,null]);
data.addRow(["2016-11-17 03:00:07",null,22.875,null,null]);
data.addRow(["2016-11-17 03:00:08",null,null,19.875,null]);
data.addRow(["2016-11-17 14:00:04",7.0,null,null,null]);
data.addRow(["2016-11-17 14:00:05",null,23.125,null,null]);
data.addRow(["2016-11-17 14:00:07",null,null,19.437,null]);
data.addRow(["2016-11-18 03:00:18",8.24,null,null,null]);
data.addRow(["2016-11-18 03:00:19",null,22.812,null,null]);
data.addRow(["2016-11-18 03:00:21",null,null,19.875,null]);
data.addRow(["2016-11-19 03:00:09",3.99,null,null,null]);
data.addRow(["2016-11-19 03:00:11",null,22.5,null,null]);
data.addRow(["2016-11-19 03:00:12",null,null,19.75,null]);
data.addRow(["2018-02-19 13:17:21",null,23.125,null,null]);
data.addRow(["2018-02-19 13:17:22",2.76,null,null,null]);
data.addRow(["2018-02-19 16:00:04",null,22.875,null,null]);
data.addRow(["2018-02-19 16:00:05",2.01,null,null,null]);
data.addRow(["2018-02-19 17:00:04",null,23.125,null,null]);
data.addRow(["2018-02-19 17:00:05",1.76,null,null,null]);
data.addRow(["2018-02-19 18:00:04",null,23.312,null,null]);
data.addRow(["2018-02-19 18:00:05",1.76,null,null,null]);
data.addRow(["2018-02-19 19:00:04",null,23.625,null,null]);
data.addRow(["2018-02-19 19:00:05",1.5,null,null,null]);
data.addRow(["2018-02-19 20:00:04",null,23.625,null,null]);
data.addRow(["2018-02-19 20:00:15",1.24,null,null,null]);
data.addRow(["2018-02-19 21:00:04",null,23.5,null,null]);
data.addRow(["2018-02-19 21:00:06",0.74,null,null,null]);
data.addRow(["2018-02-19 22:00:04",null,23.312,null,null]);
data.addRow(["2018-02-19 22:00:10",0.49,null,null,null]);
data.addRow(["2018-02-19 23:00:04",null,23.0,null,null]);
data.addRow(["2018-02-19 23:00:06",0.24,null,null,null]);
data.addRow(["2018-02-20 00:00:04",null,22.875,null,null]);
data.addRow(["2018-02-20 00:00:06",-0.01,null,null,null]);
data.addRow(["2018-02-20 01:00:04",null,22.875,null,null]);
data.addRow(["2018-02-20 01:00:06",-0.03,null,null,null]);
data.addRow(["2018-02-20 02:00:04",null,23.125,null,null]);
data.addRow(["2018-02-20 02:00:06",0.23,null,null,null]);
data.addRow(["2018-02-20 03:00:04",null,23.187,null,null]);
data.addRow(["2018-02-20 03:00:06",-0.03,null,null,null]);
data.addRow(["2018-02-20 04:00:04",null,23.062,null,null]);
data.addRow(["2018-02-20 04:00:06",-0.03,null,null,null]);
data.addRow(["2018-02-20 05:00:05",null,22.875,null,null]);
data.addRow(["2018-02-20 05:00:16",0.24,null,null,null]);
data.addRow(["2018-02-20 06:00:04",null,22.75,null,null]);
data.addRow(["2018-02-20 06:00:06",0.49,null,null,null]);
data.addRow(["2018-02-20 07:00:03",null,22.687,null,null]);
data.addRow(["2018-02-20 07:00:17",0.73,null,null,null]);
data.addRow(["2018-02-20 08:00:04",null,22.687,null,null]);
data.addRow(["2018-02-20 08:00:16",0.73,null,null,null]);
data.addRow(["2018-02-20 09:52:09",null,22.875,null,null]);
data.addRow(["2018-02-20 09:52:11",0.73,null,null,null]);
data.addRow(["2018-02-20 10:00:04",null,22.812,null,null]);
data.addRow(["2018-02-20 10:00:06",0.73,null,null,null]);
data.addRow(["2018-02-20 10:44:46",null,23.125,null,null]);
data.addRow(["2018-02-20 10:44:47",0.99,null,null,null]);
data.addRow(["2018-02-20 11:00:04",null,23.187,null,null]);
data.addRow(["2018-02-20 11:00:17",0.99,null,null,null]);
data.addRow(["2018-02-20 12:00:05",null,23.187,null,null]);
data.addRow(["2018-02-20 12:00:07",1.49,null,null,null]);
data.addRow(["2018-02-20 13:00:04",null,null,null,23.25]);
data.addRow(["2018-02-20 13:00:07",1.74,null,null,null]);
data.addRow(["2018-02-20 14:00:04",null,23.25,null,null]);
data.addRow(["2018-02-20 14:00:10",1.74,null,null,null]);
data.addRow(["2018-02-20 15:00:05",null,23.437,null,null]);
data.addRow(["2018-02-20 15:00:17",2.24,null,null,null]);
data.addRow(["2018-02-20 16:00:04",null,23.125,null,null]);
data.addRow(["2018-02-20 16:00:05",2.24,null,null,null]);
data.addRow(["2018-02-20 17:00:04",null,23.062,null,null]);
data.addRow(["2018-02-20 17:00:07",2.24,null,null,null]);
data.addRow(["2018-02-20 18:00:04",null,22.937,null,null]);
data.addRow(["2018-02-20 18:00:05",-1.22,null,null,null]);
data.addRow(["2018-02-20 19:00:04",null,22.937,null,null]);
data.addRow(["2018-02-20 19:00:17",1.23,null,null,null]);
data.addRow(["2018-02-20 20:00:05",null,23.187,null,null]);
data.addRow(["2018-02-20 20:00:16",1.0,null,null,null]);
data.addRow(["2018-02-20 21:00:04",null,23.312,null,null]);
data.addRow(["2018-02-20 21:00:05",0.76,null,null,null]);
data.addRow(["2018-02-20 22:00:04",null,23.25,null,null]);
data.addRow(["2018-02-20 22:00:06",0.48,null,null,null]);
data.addRow(["2018-02-20 23:00:05",null,23.062,null,null]);
data.addRow(["2018-02-20 23:00:06",0.5,null,null,null]);
data.addRow(["2018-02-21 00:00:04",null,22.937,null,null]);
data.addRow(["2018-02-21 00:00:16",0.5,null,null,null]);
data.addRow(["2018-02-21 01:00:05",null,22.75,null,null]);
data.addRow(["2018-02-21 01:00:06",0.2,null,null,null]);
data.addRow(["2018-02-21 02:00:04",null,22.812,null,null]);
data.addRow(["2018-02-21 02:00:05",0.24,null,null,null]);
data.addRow(["2018-02-21 03:00:04",null,23.062,null,null]);
data.addRow(["2018-02-21 03:00:06",-3.47,null,null,null]);
data.addRow(["2018-02-21 04:00:04",null,23.062,null,null]);
data.addRow(["2018-02-21 04:00:05",-0.27,null,null,null]);
data.addRow(["2018-02-21 05:00:04",null,23.0,null,null]);
data.addRow(["2018-02-21 05:00:05",-0.5,null,null,null]);
data.addRow(["2018-02-21 06:00:05",null,22.875,null,null]);
data.addRow(["2018-02-21 06:00:06",-0.52,null,null,null]);
data.addRow(["2018-02-21 07:00:04",null,22.687,null,null]);
data.addRow(["2018-02-21 07:00:15",-0.53,null,null,null]);
data.addRow(["2018-02-21 08:00:04",null,22.687,null,null]);
data.addRow(["2018-02-21 08:00:06",-0.77,null,null,null]);
data.addRow(["2018-02-21 09:00:05",null,22.625,null,null]);
data.addRow(["2018-02-21 09:00:06",-0.54,null,null,null]);
data.addRow(["2018-02-21 10:00:04",null,22.875,null,null]);
data.addRow(["2018-02-21 10:00:05",-0.01,null,null,null]);
data.addRow(["2018-02-21 10:54:22",null,23.125,null,null]);
data.addRow(["2018-02-21 10:54:23",0.74,null,null,null]);
data.addRow(["2018-02-21 10:55:34",null,23.062,null,null]);
data.addRow(["2018-02-21 10:55:35",0.74,null,null,null]);
data.addRow(["2018-02-21 10:59:57",null,null,null,null,"PELLETS ARE POU"]);
data.addRow(["2018-02-21 11:00:04",null,23.125,null,null]);
data.addRow(["2018-02-21 11:00:06",0.74,null,null,null]);

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
