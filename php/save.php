<?php
    include("db.php");
    
    $query =  "select enabled from State";
    $enabled = "";
    foreach ($dbh->query($query) as $row)
    {
        $enabled = $row[0];
    }
    $voteOn = true;
    if ($enabled == 'false') {
        $voteOn = false;
    }
    
    if ($voteOn) {
        $name = $_GET['name'];
        $vote = $_GET['vote'];
        $contestnumber = $_GET['contestnumber'];
        
        $query = "delete from votes where contestnumber=" . $contestnumber . " and name='".$name."';";
        $dbh->query($query);
        
        $query =  "insert into votes values ('" . $name . "'," .$contestnumber . ",'" . $vote . "');";
        $dbh->query($query);
    } else {
        #bad reuest.
        echo "CLOSED";
    }
    
    
?>