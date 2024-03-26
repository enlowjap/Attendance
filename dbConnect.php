<?php

   $db_name = 'siklistadb';
   $user_name = 'root';
   $user_password = '';

   $conn = new mysqli('localhost', $user_name, $user_password, $db_name);
   if ($conn->connect_error) {
       die('Connection failed: ' . $conn->connect_error);
   }
   ?>