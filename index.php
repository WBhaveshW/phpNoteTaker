<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notetaker";

    $con = mysqli_connect($servername, $username, $password, $database);
    $conErr = false;
    $insertRecord = false;
    $deleteRecord = false;
    if(mysqli_connect_error()){
        $conErr = false;
    }else{
        $conErr = true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ( isset($_POST['idEdit']) ) {

            $id = $_POST['idEdit'];
            $updatedTitle = $_POST['titleEdit'];
            $updatedDescription = $_POST['descriptionEdit'];

            // Usage of WHERE Clause to Update Data
            $sql = "UPDATE `notelist` SET `title` = '$updatedTitle', `description` = '$updatedDescription' WHERE `id` = '$id'";
            $result = mysqli_query($con, $sql);
            $aff = mysqli_affected_rows($con);
            if($result){
                if($aff >0){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success&nbsp;:&nbsp; </strong> Your note has been Updated..
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
            else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning &nbsp;:&nbsp; </strong> Unable to update..
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'.mysqli_error($con);
            }
        }
        else{
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $sql = "INSERT INTO `notelist` (`title`, `description`, `currentdate`) VALUES ('$title', '$description', current_timestamp());";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $insertRecord = true;
            }
        }
    }

    // Delete Script Starts Here
    if (isset($_GET['delete'])) {
        $deleteId = $_GET['delete'];
        $sql = "DELETE FROM `notelist` where id =$deleteId";
        $result = mysqli_query($con, $sql);
        $aff = mysqli_affected_rows($con);
        if($result){
            if($aff>0){
                $deleteRecord = true;
            }
        }
        else{
            $deleteRecord = false;
        }
    }
    // Delete Script Ends Hhere


       
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

    <!-- Connection Alert Starts Here -->
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
    <!-- Connection Alert Ends Here -->

    <!-- Insert Alert Starts Here -->
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
    <!-- Insert Alert Ends Here -->


    <!-- Delete Alert Starts Here -->
    <?php
        if($deleteRecord){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success&nbsp;:&nbsp; </strong> Your note has been Deleted..
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    ?>
    <!-- Delete Alert Ends Here -->

    <!-- Insert Notes Starts Here -->
    <div class="container mt-3">
            <div class="card">
            <h5 class="card-header">Make notes here</h5>
            <div class="card-body">
                <form action="index.php" method="post">
                    <!-- <input type="text"> -->
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
                            <td><button type="submit" class="btn btn-danger delete" id=d"'.$rows['id'].'" >Delete</button>
                            <button type="submit" class="btn btn-success edit" id="'.$rows['id'].'" data-toggle="modal" data-target="#editModal">Edit</button></td>
                            </tr>';
                }
            }
            ?>
        </tbody>
        </table>
    </div>
    <!-- Data Tables Container End Here -->

    <!-- Edit Modal Starts Here -->
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="index.php" method="post">
            <input type="hidden" name="idEdit" id="idEdit">
                <h5 class="card-title">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="titleEdit" id="titleEdit" placeholder="This field is about title..." required>
                    </div>
                </h5>
                <p class="card-textarea">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" placeholder="This is field is about description..." rows="3" required></textarea>
                </div>
                </p>
                <button type="submit" class="btn btn-info">Update Note</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    <!-- Edit Modal Ends Here -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- JQuery for data tables -->
    <script>
        $(document).ready( function () {
            $('#noteLists').DataTable();
        } );
    </script>

    <script>
    edits = document.getElementsByClassName('edit');
    //above code return array 
    // console.log(edits);

    // //Both work as the same
    // const arr = Array.from(edits);
    // console.log([...edits]);

    // //It also works here
    // titleEdit.value = "dvdvdvdvdvd";
    // console.log(titleEdit.value); 

    Array.from(edits).forEach((element, index)=>{
        // console.log(element,index);
        element.addEventListener("click", (e)=>{
            // console.log("edit",index, e.target.parentNode.parentNode);
            let tableRow =  e.target.parentNode.parentNode;
            let title = tableRow.getElementsByTagName("td")[0].innerText;
            let description = tableRow.getElementsByTagName("td")[1].innerText;
            // console.log(title, description);
            // javascript or jquery: show multiple variables in one alert
            // alert(title+description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            idEdit.value = e.target.id;
            console.log(e.target.id); 
        });
    });

    // Delete code
    delets = document.getElementsByClassName('delete');

    Array.from(delets).forEach((element, index)=>{
        element.addEventListener("click", (e)=>{
        let id = e.target.id.substr(1,);
        console.log(id);
        if (confirm("Do you really want to delete it?")) {
            window.location = `index.php?delete=${id}`;
            // console.log("yes");
        }else{
            console.log("no");

        }
        });
    });
    // TODO: Create a form and use post request to submit a form
   </script>
    </body>
</html>


<!-- Always use "tbody tag" outside while fetching data from DB -->