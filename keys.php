<?php
$SECRET =  hash('sha256', 'This is my most embarasing secret');
$IV = substr(hash('sha256',  "another secret"), 0, 16);

