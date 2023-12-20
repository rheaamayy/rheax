<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
    <div class="row">... </div>
    <div class="row">... </div>

    <div class="row"> 
        <div class="col-2"></div>
        <div class="col-8"></div>
        <h3 class = "display - 4">Item List </h3>
        <?php
        $sql_list_items = "SELECT *FROM 'items' ";

        $items_result = mysqli_query ($conn, $sql_list_items);

        if (mysqli_num_rows($items_result)  > 0 ){
            while($row = mysqli_fetch_assoc($items_result)) {?>
            <div class ="card">
                <img src = "..." class = "card-img-top" alt="...">
                <div class ="card-body">
                    <h5 class = "card-title"><?php echo $row ['item_name']
                    <p class = "card-text" > Some quick example text to 
                    <a href ="#" class = "btn btn-outline"

            }
        }
    </div>