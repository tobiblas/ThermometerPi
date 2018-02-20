<?php
    include("config.php");

    $key_sent = $_GET['key'];
    $value_sent = $_GET['value'];

    // string to put username and passwords
    $new_file_data = '';
    $key_found = False;

    foreach ($config as $key => $value) {
        if ($key == trim($key_sent)) {
            $new_file_data = $new_file_data . $key_sent . ':' . $value_sent . "\n";
            $key_found = True;
        } else {
            $new_file_data = $new_file_data . $key . ':' . $value . "\n";
        }
    }

    if (!$key_found) {
        $new_file_data = $new_file_data . $key_sent . ':' . $value_sent . "\n";
    }

    file_put_contents('admin.properties', $new_file_data);

    if ($key_sent == 'pellet') {
      $label = "";
      if ($value_sent == 'ON') {
        $label = "Pellets på";
      } else if ($value_sent == 'OFF') {
        $label = "Pellets av";
      }
      include("db.php");
      $sql = "create table if not exists event(timestamp INTEGER PRIMARY KEY, label TEXT)";
      $dbh->query($sql);
      $sql = "create index if not exists EVENT_IDX on event(timestamp);";
      $dbh->query($sql);
      $time = time();
      $query = 'insert into event values(' . $time . ',"' . $label . '");';
      $dbh->query($query);
    }
?>
