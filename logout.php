<?php

//logout.php

setcookie("token", "", time() - 3600,  "/", "", true, true);
session_unset();
session_destroy();
header('location:login');
