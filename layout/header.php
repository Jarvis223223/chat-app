<?php  
  session_start();
  require_once("config/db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/app.css">
  <!-- BootStrap Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Sweet Alert CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function sweetAlert(message, page) {
            Swal.fire({
                title: 'Congrats!',
                text: 'You have successfully ' + message,
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(function() {
                location.href = page 
            })   
        }
  </script>
</head>
<body style="background: #e8e8e8">