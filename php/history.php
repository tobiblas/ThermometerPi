
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
            if (in_array($locationOrLabel, $locations)) {
              $indexInArray = array_search("$locationOrLabel",$locations);
              $orderOfTemps[$indexInArray+1] = $temp;
            } else {
              $orderOfTemps[0] = $locationOrLabel;
            }
        }

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
    curveType: 'function',
    /*chartArea:{left:100,top:50,width:"70%",height:"70%"},*/
    legend: { position: 'bottom' },
    annotations: {
            style: 'line'
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
}

</script>


<div class="tabcontent">
    <div class="filters">
        <div class="periodfilter">
            <select>
              <option value="American">1w</option>
              <option value="Andean">2w</option>
              <option value="Chilean">1m</option>
              <option value="Greater">2m</option>
              <option value="James's">3m</option>
              <option value="Lesser">6m</option>
              <option value="Lesser">1y</option>
              <option value="Lesser">All</option>
            </select>
        </div>
        <div class="fromDate">
          <label>From:</label>
          <input id="date" type="date">
        </div>
        <div class="toDate">
          To:
          <input id="date" type="date">
        </div>
    </div>
    <div id="curve_chart"></div>


</div>
