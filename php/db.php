
<?php
    #CREATE TABLE VOTES(NAME TEXT NOT NULL, CONTESTNUMBER INT, VOTE TEXT NOT NULL);
    #CREATE TABLE RESULT(CONTESTNUMBER INT, VOTE TEXT NOT NULL);
    $dir = 'sqlite:/Users/tobiblas/Sites/schlager2/schlagervoting/schlager2016.db';
    $dbh  = new PDO($dir) or die("cannot open the database");
?>