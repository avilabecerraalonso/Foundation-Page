<?php
session_start();
require_once 'config.php';

if (!isset($_COOKIE['session_id'])) {
    header('Location: ./');
    exit;
}

$cookieuser = $_COOKIE['session_id'];
mysqli_set_charset($conn, "utf8");

$sql = "SELECT * FROM users WHERE cookie = '$cookieuser'";
$resultss = mysqli_query($conn, $sql);

if ($resultss && mysqli_num_rows($resultss) > 0) {
    $user_info = mysqli_fetch_assoc($resultss);
    $name = $user_info['name'];
    $level = $user_info['level'];
    if ($level!=='1') {
      header('Location: ./dashboard');
      exit;
    }
} else {
    echo "Error fetching user information: " . mysqli_error($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titlenewbadget'])) {

    $title = $_POST['titlenewbadget'];
    $content = $_POST['content'];
    $url = '';
    $target_dir = "assets/images/badgets/";
    $target_file = $target_dir . basename($_FILES["icobadget"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");
    $check = getimagesize($_FILES["icobadget"]["tmp_name"]);

    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {        
        header('Location: ./badgets?upload=ni');
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {        
        header('Location: ./badgets?upload=exist');
        $uploadOk = 0;
    }

    if ($_FILES["icobadget"]["size"] > 50000000) {        
        header('Location: ./badgets?upload=large');
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, $extensions_arr)) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {        
        header('Location: ./badgets?upload=n');
    } else {
        if (move_uploaded_file($_FILES["icobadget"]["tmp_name"], $target_file)) {
            $url = basename($_FILES["icobadget"]["name"]);

    $sql = "INSERT INTO badget (name, description, url) VALUES ('$title', '$content', '$url')";

    if (mysqli_query($conn, $sql)) {
        header('Location: ./badgets?created=y');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
        } else {
        header('Location: ./badgets?upload=e');
        }

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idbadgetedit'])) {

    if ($_FILES['icobadget']['size'] == 0) {
        
    $idedit = $_POST['idbadgetedit'];
    $idnews = $_POST['idbadgetedit'];
    $title = $_POST['titlebadgetedit'];
    $content = $_POST['content'];
        
    $sql = "UPDATE badget SET name='$title', description='$content' WHERE id=$idnews";
    if ($conn->query($sql) === TRUE) {
        header('Location: ./badgets?edited=y');
    }else{   
        header('Location: ./badgets?edited=n');
    }

      } else {
    $idedit = $_POST['idbadgetedit'];
    $idnews = $_POST['idbadgetedit'];
    $urlold = $_POST['urlbadgetedit'];
    $title = $_POST['titlebadgetedit'];
    $content = $_POST['content'];
    $url = '';
    $target_dir = "assets/images/badgets/";
    $target_file = $target_dir . basename($_FILES["icobadget"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");
    $check = getimagesize($_FILES["icobadget"]["tmp_name"]);

    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {        
        header('Location: ./badgets?upload=ni');
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {        
        header('Location: ./badgets?upload=exist');
        $uploadOk = 0;
    }

    if ($_FILES["icobadget"]["size"] > 50000000) {        
        header('Location: ./badgets?upload=large');
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, $extensions_arr)) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {        
        header('Location: ./badgets?upload=n');
    } else {
        if (move_uploaded_file($_FILES["icobadget"]["tmp_name"], $target_file)) {
            $url = basename($_FILES["icobadget"]["name"]);


            
            $sql = "UPDATE badget SET name='$title', description='$content', url='$url' WHERE id=$idnews";
            if ($conn->query($sql) === TRUE) {
                

                $filename = 'assets/images/badgets/' . $urlold;
            if (file_exists($filename)) {
                if (unlink($filename)) {
                    header('location: ./badgets?edit=yes');
                } else {
                    header('Location: ./badgets?editdeleted=nimage');
                }
            } else {
                header('Location: ./badgets?editdeleted=nfound');
            }

            
            } else {
            header('location: ./badgets?edit=bad');
            }

        } else {
        header('Location: ./badgets?upload=e');
        }

    }
}
}


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idbadgetdelete'])) {
    $url = $_POST['urlbadgetdelete'];
    $filename = 'assets/images/badgets/'.$url;
  if (file_exists($filename)) {
    if (unlink($filename)) {
      $ideletebad = $_POST['idbadgetdelete'];
    $sql = "DELETE FROM badget WHERE id = $ideletebad";
    if ($conn->query($sql) === TRUE) {
    header('Location: ./badgets?deleted=y');
  } else {
    header('Location: ./badgets?deleted=n');
    }
    } else {
      header('Location: ./badgets?deleted=nimage');
    }
  } else {
    header('Location: ./badgets?deleted=nfound');
  }

  }

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fundación Jóvenes Soñadores Por Talaigua - Descripción de la fundación">
    <meta name="keywords" content="Fundación, Jóvenes, Soñadores, Talaigua">
    <meta name="author" content="Martin Avila Becerra">
    <meta name="robots" content="index,follow">
    <meta name="language" content="Spanish">
    <meta name="revisit-after" content="30 days">
    <link rel="canonical" href="https://youngdreamersfortalaigua.org/badgets">
    <link rel="manifest" href="./manifest.json">
    <title>Insignias | Fundación Jóvenes Soñadores Por Talaigua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="./assets/css/main.css" rel="stylesheet">
    <script type="text/javascript">
        $(document).ready(function(){
            function loadData(page){
                var keyword = $('#keyword').val();
                $.ajax({
                    url: 'fetchbadget.php',
                    type: 'POST',
                    data: {page: page, keyword: keyword},
                    success: function(response){
                        $('#result').html(response);
                    }
                });
            }
            loadData(1);

            $(document).on('click', '.pagination li a', function(e){
                e.preventDefault();
                var page = $(this).data('page');
                loadData(page);
            });

            // Function to handle search input change event
            $('#keyword').on('input', function(){
                loadData(1);
            });
        });
    </script>
</head>
<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>
    <div class="conatiner-fluid p-4">
        <h2>Insignias</h2>
        <div class="row">
            <form class="form-group has-search col-10 pe-0">
                <input type="text" class="form-control backgroundalt searchhome" id="keyword" name="keyword"
                    placeholder="Buscar insignia...">
            </form>
            <div class="notifications col-2 text-center">
                <div class="icon" data-bs-toggle="modal" data-bs-target="#ModalNewBadget">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="auto" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalNewBadget" tabindex="-1" aria-labelledby="ModalNewBadgetLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Nueva Insignia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <form class="" method="post" action="" enctype="multipart/form-data">
                            <div class="form mb-3">
                                <label class="form-label">Titulo</label>
                                <input type="text" name="titlenewbadget" class="form-control rounded-3" id="floatingtitle" rows="2" required />
                            </div>
                            <div class="input-group mb-3">
                                <input type="file" name="icobadget" class="form-control" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03" aria-label="Upload" required>
                            </div>
                            <div class="form mb-3">
                                <label class="form-label">Contenido</label>
                                <textarea name="content" class="form-control rounded-3" id="floatingcontent" rows="8" required> </textarea>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 background30 fwhite end-0" name="edit" type="submit">Crear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        mysqli_set_charset($conn, "utf8");
        header('Content-Type: text/html; charset=utf-8');
        $sqlgrid = "SELECT * FROM badget";
        $resultgrid = mysqli_query($conn, $sqlgrid); ?>
        <div class="row mt-4" id="result">
            
        </div>
    </div>
    <nav class="nav nav-fill fixed-bottom backgroundalt pb-3">
        <a class="nav-link" href="./dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 16 16">
                <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982Z" />
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
            </svg>
            <div class="text-decoration-none text-center">Home</div>
        </a>
        <a class="nav-link" href="./aboutus"><svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
            </svg>
            <div class="text-decoration-none text-center">Nosotros</div>
        </a>
        <a class="nav-link" href="./donations"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
            </svg>
            <div class="text-decoration-none text-center">Donaciones</div>
        </a>
        <a class="nav-link active" aria-current="page" href="./account"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
            </svg>
            <div class="text-decoration-none text-center">Cuenta</div>
        </a>
    </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script>
    window.addEventListener("load", function () {
        const preloader = document.getElementById("preloader");
        preloader.classList.add("hide-preloader");
    });
</script>
<script src="./assets/js/app.js"></script>
</body>
</html>