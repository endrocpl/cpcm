<?php

include 'src/Config.php';
class DBConnect
{
    private  $connect;

    function __construct()
    {
        $this->connect = pg_connect("host=" . DB_HOST . " port=" . DB_PORT . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD);
    }
    public function getDB()
    {
        return $this->connect;
    }
}
