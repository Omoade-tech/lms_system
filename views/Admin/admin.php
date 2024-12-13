<?php 
include_once("/xampp/htdocs/lms_system/config/database.php"); 

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    
    <title>ADMIN</title>

    <style>
    
  .card1 {
    background-color: crimson;
    color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-right: 10px;
  }
  .card2 {
    background-color: #ddd;
    color: blue;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-right: 10px;
  }
  .card3 {
    background-color: blueviolet;
    color: black;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-right: 10px;
  }
  .card4 {
    background-color: purple;
    color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-right: 10px;
  }
  .card1:hover,.card2:hover,.card3:hover,.card4:hover {
    transform: translateY(-15px); 
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); 
  }
  .admin{
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    font-weight: 900;
    justify-content: box-shadow;
    color: crimson;
  }
  span{

    color: blueviolet;
  }
  .line{
    border: 2px solid black;
    margin-top: 100px;
  }
  a{
    text-decoration: none;
    color: #fff;
  }
  .mgbooks{
    text-decoration: none;
    color: blue;
  }
  .addbooks{
    text-decoration: none;
    color: black;
  }


    </style>
  
</head>
<body>
<?php
include("/xampp/htdocs/lms_system/templates/Admin.php");
?>
<h1 class="text-center mt-4 admin" >
    ADMIN <span>DASHBOARD</span> 
</h1>
<div class="row ms-2 mt-4 g-3">
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card text-center card1" style="height: 12rem;">
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <i class="bi bi-people fs-1 mb-2"></i> 
        <h4><a href="/lms_system/views/Admin/stdlist.php">Manage Student</a></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card text-center card2" style="height: 12rem;">
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <i class="bi bi-book fs-1 mb-2"></i> 
        <h4> <a class="mgbooks" href="/lms_system/views/Admin/books.php">Manage Books</a></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card text-center card3" style="height: 12rem;">
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <i class="bi bi-plus-square fs-1 mb-2"></i> 
        <h4> <a class="addbooks" href="/lms_system/views/Admin/addbook.php">Add Books</a></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card text-center card4" style="height: 12rem;">
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <i class="bi bi-clock-history fs-1 mb-2"></i>
        <h4> <a href="/lms_system/views/Admin/transaction.php">Transaction History</a></h4>
      </div>
    </div>
  </div>
</div>


<div class="line" ></div>









<?php
include("/xampp/htdocs/lms_system/templates/footer.php");
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>