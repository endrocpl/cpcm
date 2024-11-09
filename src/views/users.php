<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

$key =  $_ENV['ACCESS_TOKEN_SECRET'];
if (isset($_COOKIE['token'])) {
    $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
} else {
    header('location:login');
}

?>
<?php

include 'src/database.php';
$db = new Database();

$totalUser = $db->get_totalUser();
if (isset($_POST['submit'])) {
    $uname = $_POST['addusername'];
    $pass = $_POST['addpassword'];
    $allUser = $db->add_user($uname, $pass);
}

if (isset($_POST['submit_update'])) {
    $usernametemp = $_POST['usernametemp'];
    $uname = $_POST['uusername'];
    $pass = $_POST['upassword'];
    $allCustomer = $db->edit_users($uname, $pass, $usernametemp);
}


$allUser = $db->get_allUsers();
?>


<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">

<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Users</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sticky-footer-navbar/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/_component-examples.scss" rel="stylesheet">
    <link href="/assets/css/badges.css" rel="stylesheet">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico5.3/assets/img/favicons/favicon.ico">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <!-- toastr-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <meta name="theme-color" content="#712cf9">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.3/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>


    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">CMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/customer">Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/order">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/users">Users</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">Users</h1>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-info elevation-1"> <i class="ion bi-calendar-event"></i> </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total User</span>
                            <span class="info-box-number">
                                <h4><?php echo $totalUser ?></h4>
                                <small></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-9">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Info:</h5>
                        Press to add user data <button class="btn btn-info btn-sm" onclick="modalAdd()">Add New</button>

                    </div>
                    <br>
                </div>


            </div>
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <!-- MAP & BOX PANE -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">

                        <div class="card-body">
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="dt-responsive table-responsive">

                                    <table id="example" class="display">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>USERNAME</th>
                                                <th>LAST LOGIN</th>
                                                <th align="center">ACTIVE</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($allUser  as $key => $v) { ?>

                                                <tr>
                                                    <td width="50"><?php echo $no++ ?></td>
                                                    <td><?php echo trim($v['username']) ?></td>
                                                    <td><?php echo trim($v['last_login']) ?></td>
                                                    <td align="center">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" <?php echo $v['active'] == "t" ? 'checked' : '' ?> onclick="myFuncSetActive('<?php echo trim($v['username']) ?>')" id="cc<?php echo trim($v['username']) ?>">
                                                        </div>
                                                    </td>

                                                    <td>


                                                        <button type="button" class="btn btn-warning btn-sm" onclick="showModal('<?php echo $v['username'] ?>')">Edit</button>
                                                        <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="btn-close" onclick="clickDelete('<?php echo $v['username'] ?>')" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- <div class="card-footer clearfix">
                            *) Untuk menampilkan detail event, harap klik 2x baris pada table
                        </div> -->
                        <!-- /.card -->
                    </div>

                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </div>
        <br>
    </main>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container">
            <span class="text-body-secondary">Hendro Cipta P Lubis</span>
        </div>
    </footer>
    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>




<!-- sample modal  add -->
<div class="modal fade" id="myModalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Data User</h5>
            </div>
            <div class="modal-body">
                <div class="card-box">
                    <div class="form-group row">
                        <form method="post" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="addusername" placeholder="Input username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="addpassword" placeholder="Input password" required>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-sm btn-round" type="submit" name="submit"><i class="bi bi-upload"></i> Save</button>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End  -->

<!-- sample modal edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="juduedit">Edit Data</h5>

            </div>
            <div class="modal-body">

                <div class="card-box">
                    <div class="form-group row">
                        <form method="post" data-parsley-validate class="form-horizontal form-label-left">
                            <input type="hidden" name="usernametemp" id="usernametemp">

                            <div class="row">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="uusername" name="uusername" placeholder="Input username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="upassword" name="upassword" placeholder="Input password">
                                </div>


                            </div>
                            <code>Password biarkan saja kosong bila tidak ingin di rubah</code>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-sm btn-round" type="submit" name="submit_update"><i class="bi bi-upload"></i> Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End edit-->




<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"></script>

<script>
    new DataTable('#example');

    function showModal(idx) {
        $("#usernametemp").val(idx);
        $('#myModalEdit').modal('show');
        $('#juduedit').text('Loading..');


        // var id ='C1';
        $.ajax({
            type: "POST",
            url: "http://localhost:8081/c_users_getbyusername.php",
            data: {
                "username": idx,
            },
            dataType: "json",
            success: function(data) {
                $('#juduedit').text('Edit Data');

                $("#uusername").val(data.username.trim())

            },
            error: function(jqXHR, exception) {

                $("#uname").val("");
                $("#uaddress").val("");
                $("#uemail").val("");
                $("#uphone").val("");


                Swal.fire({
                    icon: 'error',
                    title: "There is an error",
                    html: getBody(jqXHR.responseText),
                    showDenyButton: true,
                    denyButtonText: `Cancel`,
                })

            }
        });

    }

    function modalAdd() {
        $('#myModalAdd').modal('show');
    }

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }



    function clickDelete(idx) {


        Swal.fire({
            title: 'Are you sure?',
            text: "delete this customer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, delete  !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost:8081/c_users_del.php",
                    data: {
                        "username": idx,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data == 1) {
                            toastr.warning('Pilih file terlebih dahulu.')
                            window.location.reload(true);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "failed",
                                showDenyButton: true,
                                denyButtonText: `Cancel`,
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        Swal.fire({
                            icon: 'error',
                            title: "There is an error",
                            html: getBody(jqXHR.responseText),
                            showDenyButton: true,
                            denyButtonText: `Cancel`,
                        })

                    }
                });
            }
        })

    }

    function getBody(content) {
        var x = content.indexOf("<body");
        x = content.indexOf(">", x);
        var y = content.lastIndexOf("</body>");
        return content.slice(x + 1, y);
    }

    function myFuncSetActive(idx) {
        var nil = $('#cc' + idx).is(":checked");
        console.log(nil);
        $.ajax({
            url: "http://localhost:8081/c_users_active.php",
            method: "POST",
            data: {
                "username": idx,
                "valuex": nil
            },
            dataType: 'json',
            async: false,
            success: function(data) {
                toastr.success("Success");
            },
            error: function(jqXHR, exception) {
                toastr.error('failed, please try again!');
            }

        });
    }
</script>


<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && (e.which === 85 || e.which === 83)) {
            e.preventDefault();
        }
    });
</script>