<?php

include 'src/Config.php';
class DBConnect
{
    private  $connect;

    function __construct()
    {
        // $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        // if (mysqli_connect_errno($this->connect)) {
        //     echo 'failed to connect database' . mysqli_connect_error();
        // }
        //  $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $this->connect = pg_connect("host=" . DB_HOST . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD);
    }
    public function getDB()
    {
        return $this->connect;
    }
}
