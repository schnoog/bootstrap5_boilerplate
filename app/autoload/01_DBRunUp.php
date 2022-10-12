<?php 

DB::$user       = $App['database']['username'];
DB::$password   = $App['database']['password'];
DB::$dbName     = $App['database']['name'];
DB::$host       = $App['database']['host']; //defaults to localhost if omitted
DB::$port       = $App['database']['port']; // defaults to 3306 if omitted
DB::$encoding   = $App['database']['encoding']; // defaults to latin1 if omitted