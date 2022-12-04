<?php

$servername="localhost";
$username="root";
$password="";
$database="crud";


$con= mysqli_connect($servername,$username,$password,$database);

if(!$con){
    echo"connection is not successfull";
}

$inserted=false;
$updated=false;
$deleted=false;

if(isset($_GET['delete']))
{
  $s=$_GET['delete'];

  $sql="DELETE FROM `notes` where `no`=$s";
  $result=mysqli_query($con,$sql);
  if($result)
  {
    $deleted=true;
  }

}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  if(isset($_POST['snoedit']))
  {
    $sno=$_POST['snoedit'];
    $title=$_POST["titleedit"];
    $desc=$_POST["descedit"];
  
    $sql="UPDATE `notes` SET `title` = '$title',`description` = '$desc' WHERE `notes`.`no` = $sno ;";
    $result=mysqli_query($con,$sql);
    $updated=true;
  }
  else
  {
    $title=$_POST["title"];
    $desc=$_POST["desc"];
  
    $sql=" INSERT INTO `notes` (`title`, `description`, `date`) VALUES ('$title', '$desc', current_timestamp());";
    $result=mysqli_query($con,$sql);
  
    if($result)
    {
      $inserted=true;
    }

  }

}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
  

    

    <title>I-crud!</title>
    <style>
        .i{
            font-size: 25px;
        }
        .container{
          max-width:1000px;
        }
        *{
          font-family: 'Trebuchet MS';
        }
    </style>


  </head>
  <body>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          < class="modal-body">

            <form action="index.php" method="post">
              <input type="hidden" name="snoedit" id="snoedit">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Node title</label>
                <input type="text" class="form-control" name="titleedit" id="titleedit" aria-describedby="emailHelp">
              
              </div>
              
              <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                  <textarea class="form-control" name="descedit" id="descedit" rows="3"></textarea>
              </div>
              <div class="modal-footer d-block mr-auto">
                <button type="submit" class="btn btn-primary">update-Note</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand i" href="#">I-crud</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
            
              
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
        </div>
    </nav>
      
    



    <?php
    if($inserted)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Note has been added successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    if($updated)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Note has been updated successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    
    if($deleted)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Note has been deleted successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    
    ?>
    
    <div class="container my-4">
        <h2>Add a Note</h2>
        <hr/>
        <form action="index.php" method="post">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Node title</label>
              <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
             
            </div>
            
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add-Note</button>
            <button type="reset" class="btn btn-primary">Reset</button>
          </form>
    </div>

    
    <div class="container my-4">
    <hr/>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Date-time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $sql="SELECT * FROM `notes`";
      $result=mysqli_query($con,$sql);
      $sno=0;
      while($row=mysqli_fetch_assoc($result))
      {
        $sno+=1;
        echo '<tr>
        <th >'.$sno.'</th>
        <td>' .$row["title"].'</td>
        <td>'. $row["description"].'</td>
        <td>'. $row["date"].'</td>
        <td><button class="edit btn btn-sm btn-primary" id='.$row['no'].'>Edit</button> 
        <button class="delete btn btn-sm btn-primary" id='.$row['no'].'>Delete</button></td>
      </tr>';
      }
      ?>
      </tbody>
    </table>
    <hr/>
      
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>

    <script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          tr=e.target.parentNode.parentNode;
          title=tr.getElementsByTagName("td")[0].innerText;
          description =tr.getElementsByTagName("td")[1].innerText;
         
          snoedit.value=e.target.id;
          console.log(e.target.id);

          descedit.value=description;
          titleedit.value=title;
          $('#editModal').modal('toggle');
        })
      })

      deletes=document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          sno=e.target.id;
          
          if(confirm("Are you sure to delete !"))
          {
            console.log("yes");
            window.location=`index.php?delete=${sno}`;
          }
        })
      })
    </script>
  </body>
</html>