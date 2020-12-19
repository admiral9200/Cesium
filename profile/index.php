<?php
session_start();
if (!isset($_SESSION['email'])) header('location: ../');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Chip Coffee | Online Coffee Delivery</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/home.css">
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
    <link rel="icon" type="image/png" href="/images/chip_coffee.png">
    <link rel="stylesheet" href="/bootstrap-4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;523;600;700;800&display=swap" rel="stylesheet">
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script async src="/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
    <script async src="index.js"></script>
    <script async type="module">
        import { getProfile } from '../js/modules.js';
        (() => getProfile())();
    </script>
</head>
<body>
    <div id="blurred" class="blurred"></div>
    <div id="loader" class="loader lds-dual-ring"></div>
    <div class="background">
        <nav class="navbar navbar-light container">
            <a class="navbar-brand" href="/home/">
                <img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
            </a>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/">Ο λογαριασμός μου</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/php/logout.php">Αποσύνδεση</a>
                </div>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1>Ο λογαριασμός μου</h1>
            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="row my-2">
            <div class="col-xl-3 col-12 text-center space">
                <div class="sticky-top pt-4 pb-4">
                    <img src="/images/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar"/>
                    <h4 id="fullName" class="my-4"></h4>
                </div>
            </div>
            <div class="col-xl-9 col-12 personal-info">
                <h4 class="mb-4">Τα στοιχεία μου</h4>
                <div id="res"></div>
                <div class="form-group row mb-0">
                    <div class="col-xl-5 col-12">
                        <label class="col-xl-5 col-form-label form-control-label pl-0">Όνομα</label>
                        <input class="form-control" type="text" id="firstName"/>
                        <div class="text-danger">Πρέπει να συμπληρώσεις ένα όνομα</div>
                    </div>
                    <div class="col-xl-5 col-12">
                        <label class="col-xl-5 col-form-label form-control-label pl-0">Επώνυμο</label>
                        <input class="form-control" type="text" id="lastName"/>
                        <div class="text-danger">Πρέπει να συμπληρώσεις ένα επίθετο</div>
                    </div>
                </div>
                <div class="form-group row mt-4 mb-0">
                    <label class="col-xl-5 col-form-label form-control-label pl-3">Email</label>
                </div>
                <div class="form-group row">
                    <div class="col-xl-5 mb-0">
                        <input class="form-control" type="text" id="email" value="" disabled/>
                    </div>
                </div>
                <!-- <div class="form-group row mt-4 mb-0">
				    <label class="col-5 col-form-label form-control-label pl-3">Κινητό</label>
                </div>
                <div class="form-group row">
                    <div class="col-5 mb-0">
                        <input class="form-control" type="text" value="phone"/>
                    </div>
                </div> -->
                <div class="form-group row">
                    <div class="col-12 mt-4 text-left">
                        <button type="button" id="changeCreds" class="btn mainbtn text-white btn-lg btn-block" value="save">Αποθήκευση Αλλαγών</button>
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <h4 class="mb-4">Αλλαγή κωδικού</h4>
                <div id="resPass"></div>
                <div class="form-group row mt-4 mb-0">
                    <label class="col-xl-5 col-12 col-form-label form-control-label pl-3">Τρέχων κωδικός</label>
                </div>
                <div class="form-group row">
                    <div class="col-xl-5 col-12">
                        <input class="form-control" type="password" id="oldpass" />
                        <div class="text-danger">Πρέπει να συμπληρώσεις τον παλιό κωδικό</div>
                    </div>
                </div>
                <div class="form-group row mt-4 mb-0">
                    <label class="col-xl-5 col-12 col-form-label form-control-label">Νέος κωδικός</label>
                </div>
                <div class="form-group row">
                    <div class="col-xl-5 col-12">
                        <input class="form-control" type="password" id="newpass" />
                        <div class="text-danger">Πρέπει να συμπληρώσεις έναν καινούριο κωδικό</div>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-xl-12 col-12">
                        <button type="submit" id="changepass" class="btn mainbtn text-white btn-lg btn-block" value="pass">Αποθήκευση Αλλαγών</button>
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <h4 class="mb-4">Διαγραφή Λογαριασμού</h4>
                <div class="form-group row mt-4">
                    <div class="col-xl-12 col-12">
                        <button type="submit" class="btn text-white btn-lg btn-block btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Οριστική Διαγραφή Λογαριασμού</button>
                    </div>
                </div>
                <!-- form delete -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Οριστική Διαγραφή Λογαριασμού</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Η διαγραφή του λογαριασμού σου είναι οριστική και θα διαγραφούν όλα τα δεδομένα σου στο Chip Coffee. Είσαι σίγουρος ότι θες να συνεχίσεις;
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
                                <button type="button" class="btn btn-danger" id="account_delete">Συνέχεια</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter -->
    <?php echo file_get_contents("../views/newsletter.html"); ?>
    <!-- Site footer -->
    <?php echo file_get_contents("../views/footer.html"); ?>
</body>
</html>