
<?php

$label = $_GET['label'];

$command = '/home/pi/thermometer/sense_remote_temp.py /var/www/html/thermometer/ $label';
echo exec($command . ' 2>&1');

?>
