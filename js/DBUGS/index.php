<?php include_once("dtbs.php"); ?>

<html>
    <head>   
        <meta charset="UTF-8">
        <title>index</title>
        <link rel="stylesheet" href="css/bootstrap.css">
</head>
<style>

    h1{
        color: solid black;
        font-size:50px;
        text-align: center;
    }
    body{
        background-image:url("face.jpg");
        background-attachment: fixed;
        
        font-family: Georgia;
    }

    </style>
    <h1>Log-in</h1><br><br><br><br>
<body>
<div class="container">
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
    <form action="login.php" method="POST">
                <div class="mb-3">
                    
<div class="mb-3">
                    <label for="" class="form-label"> Username 
                        <input type="text" class="form-control" name="uname" >
                        
</label>
</div>
<div class="mb-3">
                    <label for="" class="form-label"> Password
                        <input type="Password" class="form-control" name="pword">
</label>
</div>
</label>
</div>
<input type="submit" class="btn btn-primary">
<a href="registration.html" class="btn btn-primary">Create Account</a>
  </form>
</div>
<div class="col-4"></div>
</div>
</body>
<script src="js/bootstrap.js"></script>
</html>