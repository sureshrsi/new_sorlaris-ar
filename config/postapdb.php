<?php
   $host        = "host = 192.168.1.19";
   $port        = "port = 5432";
   $dbname      = "dbname = ap_db";
   $credentials = "user = postgres password=Rsi@2024";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } 
?>
