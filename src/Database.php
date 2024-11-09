<?php

include 'src/DBConnect.php';
class Database
{
    function __construct() {}

    function cekLogin($u, $p)
    {
        $con = new DBConnect();
        $query = pg_query($con->getDB(),  "SELECT *  FROM t_users WHERE username='$u' AND password=md5('$p') AND active=true");
        $row    = pg_fetch_array($query);
        if ($row) {
            $no =  1;
        } else {
            $no = 0;
        }
        return $no;
    }
    function get_totalCustomer()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT count(*) total from t_customer");
        $row    = pg_fetch_array($query);
        return $row[0];
    }
    function get_allCustomer()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT * from t_customer");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }
    function get_allCustomerActive()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT * from t_customer WHERE active=true order by cust_id");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }
    function get_customerById($id)
    {
        $con = new DBConnect();
        $query = pg_query($con->getDB(),  "SELECT * FROM t_customer WHERE cust_id='$id'");
        $row = pg_fetch_assoc($query);
        return $row;
    }
    function del_customerById($id)
    {
        $con = new DBConnect();
        $sql = "DELETE FROM t_customer WHERE cust_id='$id'";
        $suc = pg_query($con->getDB(), $sql);
        if ($suc) {
            return 1;
        } else {
            return 0;
        }
    }

    function set_customerActiveById($v, $cid)
    {
        $con = new DBConnect();
        $sql = "UPDATE t_customer SET active='$v'  WHERE cust_id='$cid'";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }
    function add_customer($n, $a, $e, $p)
    {
        $con = new DBConnect();
        $sql = "insert into t_customer(cust_name, address, email, active,phone) values('$n','$a','$e',true,'$p')";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }
    function edit_customer($n, $a, $e, $p, $cid)
    {
        $con = new DBConnect();
        $sql = "UPDATE t_customer SET cust_name='$n',address='$a',email='$e',phone='$p' WHERE cust_id='$cid'";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }

    #-------------------------ORDER
    function get_totalOrder()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT count(*)total from (SELECT DISTINCT order_id from t_order WHERE active=true)t");
        $row    = pg_fetch_array($query);
        return $row[0];
    }
    function get_allOrder()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT a.*, b.cust_name from t_order a left join t_customer b on b.cust_id = a.cust_id WHERE a.active=true");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }

    function add_ordertoTmp($custid, $item, $name, $qty, $username, $seq)
    {
        $con = new DBConnect();
        $sql = "insert into t_order_tmp(item_id, item_name, qty, username,seq,cust_id) values('$item','$name','$qty','$username','$seq','$custid')";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }
    function get_allOrderByUsername($u)
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT * FROM t_order_tmp where username='$u' order by seq");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }

    function get_lastSeqByUsername($ux)
    {
        $con = new DBConnect();
        $query  = pg_query($con->getDB(), "SELECT seq from t_order_tmp where username='$ux' order by seq desc limit 1");
        $row    = pg_fetch_array($query);
        if ($row) {
            $no = $row[0] + 1;
        } else {
            $no = 1;
        }
        return $no;
    }
    function del_lastSeqByUsername($ux, $id)
    {
        $con = new DBConnect();
        $sql = "DELETE FROM t_order_tmp WHERE username='$ux' AND item_id='$id'";
        $suc = pg_query($con->getDB(), $sql);
        if ($suc) {
            return 'success';
        } else {
            return 'failed';
        }
    }
    function del_orderById($oid)
    {
        $con = new DBConnect();
        $sql = "UPDATE t_order SET active=false  WHERE order_id='$oid'";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }
    function save_order($custid, $ux)
    {
        $con = new DBConnect();


        $query =  pg_query($con->getDB(), "SELECT item_id,item_name,qty,seq FROM t_order_tmp  WHERE cust_id='$custid' AND username='$ux'");
        if (!$query) {
            echo "An error occurred.\n";
            exit;
        }
        $createOrderNo = $this->createOrderIdNo();
        $orderDate =  date('Y-m-d');
        while ($row = pg_fetch_assoc($query)) {
            $item = $row['item_id'];
            $itemName = $row['item_name'];
            $qty = $row['qty'];
            $seq = $row['seq'];
            pg_query($con->getDB(), "INSERT INTO t_order (order_id,cust_id,item_id,item_name,qty,active,order_date,seq) 
                                    VALUES ('$createOrderNo','$custid','$item','$itemName','$qty','true','$orderDate','$seq')");
        }
        pg_query($con->getDB(), "DELETE FROM t_order_tmp WHERE cust_id='$custid' AND username='$ux'");
    }

    function get_orderById($oid)
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT * from t_order WHERE order_id='$oid' order by cust_id");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }

    function createOrderIdNo()
    {
        $con = new DBConnect();
        $query =  pg_query($con->getDB(), "SELECT CAST (substring(order_id,3,3) as INT)no FROM t_order order by substring(order_id,3,3)  desc limit 1");
        $row    = pg_fetch_array($query);
        if ($row) {
            $no = $row[0] + 1;
        } else {
            $no = 1;
        }

        if (strlen(trim($no)) == 1)  $nox = "SP00" . $no;
        if (strlen(trim($no)) == 2)  $nox = "SP0" . $no;
        if (strlen(trim($no)) == 3)  $nox = "SP" . $no;

        return  $nox;
    }


    #------------------------

    function get_totalUser()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT count(*)total from t_users");
        $row    = pg_fetch_array($query);
        return $row[0];
    }
    function get_allUsers()
    {
        $cn     = new DBConnect();
        $query  = pg_query($cn->getDB(), "SELECT * from t_users");
        $dbdata = array();
        while ($row = pg_fetch_assoc($query)) {
            $dbdata[] = $row;
        }
        return $dbdata;
    }
    function add_user($u, $p)
    {
        $con = new DBConnect();
        $sql = "insert into t_users(username, password, active) values('$u',md5('$p'),true)";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }

    function set_usersActiveById($v, $u)
    {
        $con = new DBConnect();
        $sql = "UPDATE t_users SET active='$v'  WHERE username='$u'";
        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }

    function del_usersById($u)
    {
        $con = new DBConnect();
        $sql = "DELETE FROM t_users WHERE username='$u'";
        $suc = pg_query($con->getDB(), $sql);
        if ($suc) {
            return 1;
        } else {
            return 0;
        }
    }
    function edit_users($u, $p, $utmp)
    {
        $con = new DBConnect();
        if ($p == "") {
            $sql = "UPDATE t_users SET username='$u' WHERE username='$utmp'";
        } else {
            $sql = "UPDATE t_users SET username='$u',password=md5('$p') WHERE username='$utmp'";
        }

        $suc = pg_query($con->getDB(), $sql);
        if (! empty($suc)) {
            return 1;
        } else {
            return 0;
        }
    }
    function get_usersById($u)
    {
        $con = new DBConnect();
        $query = pg_query($con->getDB(),  "SELECT * FROM t_users WHERE username='$u'");
        $row = pg_fetch_assoc($query);
        return $row;
    }
}
