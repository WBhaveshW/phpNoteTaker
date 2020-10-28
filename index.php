<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notetaker";

    $con = mysqli_connect($servername, $username, $password, $database);
    $conErr = false;
    $insertRecord = false;
    if(mysqli_connect_error()){
        $conErr = false;
    }else{
        $conErr = true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $sql = "INSERT INTO `notelist` (`title`, `description`, `currentdate`) VALUES ('$title', '$description', current_timestamp());";
        $result = mysqli_query($con, $sql);
        if ($result) {
           $insertRecord = true;
        }
    }
       
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">

    <!--Css for Data tables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    
    <title>NoteTaker</title>
    <style>
   body{font-family: 'Arvo', serif;}
    </style>
  </head>
  <body>
    <!-- Nab Bar Starts Here -->
    <nav class="navbar navbar-light bg-light navbar-expand-lg navbar-expand-md">
        <a class="navbar-brand" href="index.php">
            <img src="static/logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            NoteTaker
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                <a class="nav-link" href="#">About</a>
            </div>
        </div>
    </nav>
    <!-- Nab Bar Ends Here -->

    <?php
        if($conErr){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success&nbsp;:&nbsp; </strong> Welcome to NoteTaker
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        }else{
            die('<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error&nbsp;:&nbsp;</strong> We are facing some technical issue. Do visit Later
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        }
    ?>

    <?php
        if($insertRecord){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success&nbsp;:&nbsp; </strong> Your note has been added..
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        }
    ?>

    <!-- Insert Notes Start Here -->
    <div class="container mt-3">
            <div class="card">
            <h5 class="card-header">Make notes here</h5>
            <div class="card-body">
                <form action="index.php" method="post">
                    <h5 class="card-title">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="This field is about title..." required>
                        </div>
                    </h5>
                    <p class="card-textarea">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="This is field is about description..." rows="3" required></textarea>
                    </div>
                    </p>
                    <button type="submit" class="btn btn-info">Add Note</button>
                </form>
            </div>
            </div>
    </div>
    <!-- Insert Notes End Here -->

    <!-- Data Tables Container Start Here -->
    <div class="container mt-4 mb-5">
        <table class="table table-sm" id="noteLists">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `notelist`";
            $result = mysqli_query($con, $sql);
            //It Finds the number of records returned
            $num = mysqli_num_rows($result);
            $srNo = 0;
            if($num> 0){
                while($rows = mysqli_fetch_assoc($result)){
                    $srNo = $srNo + 1;
                    echo '  <tr>
                            <th scope="row">'.$srNo.'</th>
                            <td>'.$rows['title'].'</td>
                            <td>'.$rows['description'].'</td>
                            <td>'.$rows['currentdate'].'</td>
                            <td><button type="submit" class="btn btn-danger">Delete</button>
                            <button type="submit" class="btn btn-success">Edit</button></td>
                            </tr>';
                }
            }
            ?>
        </tbody>
        </table>
    </div>
    <!-- Data Tables Container End Here -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- JQuery for data tables -->
    <script>
        $(document).ready( function () {
            $('#noteLists').DataTable();
        } );
    </script>
    </body>
</html>


<!-- Always use "tbody tag" outside while fetching data from DB -->