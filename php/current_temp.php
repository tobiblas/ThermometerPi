
<?php
    $command = '/Users/tobiblas/Sites/ThermometerPi/ThermometerPi/thermometer/sense_temp.py nosave';
    echo exec($command . ' 2>&1');
?>