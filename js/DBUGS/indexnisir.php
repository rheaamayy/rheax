<?php include_once("../db.php"); 
//-------------------------------
//**Functions applicable only in this page.
function status_badge($status){
    $val = "";
    $color="";
    $ret = "";
    switch($status){
        case "P": $val="Pending"; $color="warning" ;break;
        case "D": $val="On the Way"; $color="primary" ;break;
        case "X": $val="Cancelled"; $color="danger" ;break;
        case "C": $val="Delivered"; $color="success" ;break;
    }
    
    $ret = "<span class='badge rounded-pill bg-".$color." float-end'>".$val."</span>";
    return $ret;
}
//-------------------------------
?>
<html>
<head>
    <meta charset="UTF-16">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../my.css">
    <style>
    #offcanvasNavbar{
            background-image:url("../img/pizza1.jpeg");
        }  


    </style>
</head>
<body id="home-page">

<div class="container-fluid">

     <div class="row">
            <?php require("nav.php");?>
     </div>

    <div class="row">
        <?php
        if(isset($_GET['user_id'])){
            $uid=$_GET['user_id']; //user who logged in
            
            //Get all orders that are not yet completed.
            $sql_not_completed_orders =  "SELECT `order_id`,`quantity`,`date_ordered`,`order_status` from orders where `user_id` = '$uid' and order_status not in ('C') order by order_id asc"; //SQL to get data from orders table
            $sql_result_1 = mysqli_query($conn, $sql_not_completed_orders); //execute SQL 
        
            //Get all orders that are completed.
            $sql_completed_orders =  "SELECT `order_id`,`quantity`,`date_ordered`,`order_status` from orders where `user_id` = '$uid' and order_status in ('C') order by order_id asc"; //SQL to get data from orders table
            $sql_result_2 = mysqli_query($conn, $sql_completed_orders); //execute SQL  ?>
        
               <div class="col-lg-12 col-sm-6 mt-3">
         <?php if(mysqli_num_rows($sql_result_1) > 0){ ?>

    <!--                          button that will toggle for pending orders, this will only show if there is a pending order-->
                               <button class="btn btn-secondary position-relative" data-bs-toggle="collapse" data-bs-target="#pendingOrders" aria-expanded="false" aria-controls="pendingOrders">
                                  Pending Orders
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo mysqli_num_rows($sql_result_1) ;?></span> 
                                </button>
    <!--                           end of button-->
             
            <?php }
            if(mysqli_num_rows($sql_result_2) > 0){  ?>
    <!--                          button that will toggle for pending orders, this will only show if there is a pending order-->
                               <button class="btn btn-secondary position-relative" data-bs-toggle="collapse" data-bs-target="#completedOrders" aria-expanded="false" aria-controls="completedOrders">
                                  Past Orders
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo mysqli_num_rows($sql_result_2) ;?></span> 
                                </button>
    <!--                           end of button-->
            
            <?php 
            } ?>
            
             </div>
            <?php if(mysqli_num_rows($sql_result_1) > 0){ //CHK_ORDER_COUNT: check if there is a record ?> 
            
                <div class="col-12 mt-1">
                    <div class="container-fluid">
    <!--                   This is the part where the list of pending orders are being shown. -->
                        <div class="row collapse"  id="pendingOrders"> 
                             <?php while($row = mysqli_fetch_array($sql_result_1)){ ?>

                            <div class="col-3">
                                <div class="card mb-3">
                                        <div class="card-header">
                                           <h6 class="card-title">Order #<?php  $or_id = $row['order_id']; echo $or_id; ?></h6>
                                           <span class="card-subtitle">
                                               <span class="badge rounded-pill bg-danger float-start"><?php echo $row['date_ordered'];?></span>
                                               <?php echo status_badge($row['order_status']);?>
                                           </span>
                                           
                                        </div>
                                        
                                    <div class="card-body">
                                        <?php
                                         //SQL to get the ingredient data and price and order quantity
                                         $sql_get_breakdown =  "SELECT i.ingredient_name ingredient_name
                                                                     , i.price_amt price_amt
                                                                     , o.quantity
                                                                  FROM `orders` o
                                                                  JOIN `ingredients` i
                                                                    ON (o.step1 = i.ingredient_id)
                                                                    OR (o.step2 = i.ingredient_id)
                                                                    OR (o.step3 = i.ingredient_id)
                                                                    OR (o.step4 = i.ingredient_id)
                                                                  WHERE `user_id` = '$uid' 
                                                                    AND `order_id` = '$or_id'";  
                                        //execute SQL
                                         $sql_brk_result = mysqli_query($conn,$sql_get_breakdown);
                                        //check if there is a record.
                                         if(mysqli_num_rows($sql_brk_result) > 0){
                                             echo "<ul class='list-group'>";
                                             //initialize total amount to 0.00
                                             $total_amt = 0.00;
                                             while($brk = mysqli_fetch_array($sql_brk_result)){
                                                 echo "<li class='list-group-item'>". $brk['ingredient_name'] . "(".number_format($brk['price_amt'],2).")" ."</li>";
                                                 $total_amt += $brk['price_amt'];
                                             }
                                             echo "<li class='list-group-item'> Quantity: ".$row['quantity']." pc/s</li>";
                                             echo "<li class='list-group-item'>Php ".number_format($total_amt * $row['quantity'],2)."</li>";
                                             echo "</ul>";
                                         }

                                        ?>

                                    </div>
                                </div>

                            </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>


            <?php } //end of CHK_ORDER_COUNT 

           
            if(mysqli_num_rows($sql_result_2) > 0){ //CHK_ORDER_COUNT: check if there is a record ?> 
              
                <div class="col-12 mt-1">
                    <div class="container-fluid">
    <!--                   This is the part where the list of pending orders are being shown. -->
                        <div class="row collapse"  id="completedOrders"> 
                             <?php while($row = mysqli_fetch_array($sql_result_2)){ ?>

                            <div class="col-3">
                                <div class="card mb-3">
                                        <div class="card-header">
                                           <h6 class="card-title">Order #<?php  $or_id = $row['order_id']; echo $or_id; ?></h6>
                                           <span class="card-subtitle">
                                               <span class="badge rounded-pill bg-danger float-start"><?php echo $row['date_ordered'];?></span>
                                               <?php echo status_badge($row['order_status']);?>
                                           </span>
                                           
                                        </div>
                                        
                                    <div class="card-body">
                                        <?php
                                         //SQL to get the ingredient data and price and order quantity
                                         $sql_get_breakdown =  "SELECT i.ingredient_name ingredient_name
                                                                     , i.price_amt price_amt
                                                                     , o.quantity
                                                                  FROM `orders` o
                                                                  JOIN `ingredients` i
                                                                    ON (o.step1 = i.ingredient_id)
                                                                    OR (o.step2 = i.ingredient_id)
                                                                    OR (o.step3 = i.ingredient_id)
                                                                    OR (o.step4 = i.ingredient_id)
                                                                  WHERE `user_id` = '$uid' 
                                                                    AND `order_id` = '$or_id'";  
                                        //execute SQL
                                         $sql_brk_result = mysqli_query($conn,$sql_get_breakdown);
                                        //check if there is a record.
                                         if(mysqli_num_rows($sql_brk_result) > 0){
                                             echo "<ul class='list-group'>";
                                             //initialize total amount to 0.00
                                             $total_amt = 0.00;
                                             while($brk = mysqli_fetch_array($sql_brk_result)){
                                                 echo "<li class='list-group-item'>". $brk['ingredient_name'] . "(".number_format($brk['price_amt'],2).")" ."</li>";
                                                 $total_amt += $brk['price_amt'];
                                             }
                                             echo "<li class='list-group-item'> Quantity: ".$row['quantity']." pc/s</li>";
                                             echo "<li class='list-group-item'>Php ".number_format($total_amt * $row['quantity'],2)."</li>";
                                             echo "</ul>";
                                         }

                                        ?>

                                    </div>
                                </div>

                            </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>


            <?php } //end of CHK_ORDER_COUNT 
        }
        ?>
    </div>
<?php
    //**Once the order form gets submitted it gets process in this part.**//
    if(isset($_GET['process_order'])){
        if(isset($_GET['user_id'])){
            $step_1 = $_GET['step1'];
            $step_2 = $_GET['step2'];
            $step_3 = $_GET['step3'];
            $step_4 = $_GET['step4'];
            $user_id = $_GET['user_id'];
            $qty = $_GET['order_qty'];

            $sql_get_breakdown = "SELECT `ingredient_name`, `price_amt` FROM `ingredients` 
                               WHERE `ingredient_id` in ('$step_1','$step_2','$step_3','$step_4')";
            $sql_result = mysqli_query($conn, $sql_get_breakdown);

            $total = 0.00; 
    ?>
  <div class="row justify-content-center">
                   <div class="col-4 border border-1">
                   <strong>Order Summary</strong> <hr>
            <?php if(mysqli_num_rows($sql_result) > 0){ 
                while($r = mysqli_fetch_assoc($sql_result)){
                    echo $r['ingredient_name'] . " = " . $r['price_amt'] . "<br>";
                    $total = $total + $r['price_amt'];
                }
                echo "Quantity: " . $qty . " pcs<br>";
                echo "<hr>";
                echo "Total Amount to pay: Php " .  number_format($total * $qty,2); ?>
                  <br>
            <a href="index.php?process_order&check_out=1&step1=<?php echo $step_1;?>&step2=<?php echo $step_2;?>&step3=<?php echo $step_3;?>&step4=<?php echo $step_4;?>&u_id=<?php echo $user_id;?>&qty=<?php echo $qty;?>" class="btn btn-success">Check Out</a>
              
            <?php 
            }

            ?>
            </div>
                </div>
            <?php
        }

        if(isset($_GET['check_out'])){
                $step1 = $_GET['step1'];
                $step2 = $_GET['step2'];
                $step3 = $_GET['step3'];
                $step4 = $_GET['step4'];
                $user_id = $_GET['u_id'];
                $qty = $_GET['qty'];

             $sql_insert_order = "INSERT INTO `orders` (`step1`,`step2`,`step3`,`step4`,`user_id`,`quantity`)
                             VALUES ('$step1','$step2','$step3','$step4','$user_id','$qty')";
             mysqli_query($conn, $sql_insert_order);

            header("location:index.php?user_id=$user_id&order=successful");
        }
    }
    //**End-of-Order_processing.**//


if(!isset($_GET['process_order'])){ 
    //This condition will check if an order is not being processed there for the form will show below.
?>
<form action="index.php" method="get">
<!--     Order Form-->
     <div class="row">
         <div class="col-10"></div>
         <div class="col-2">
             <input type="submit" name="process_order" class="btn btn-lg btn-warning mb-3" value="Order Now >>">
         </div>
     </div>
      <div class="row justify-content-center">
          <div class="col-3">
        
              <input type="text" class="form-control-lg border border-2 border-danger form-control" name="order_qty" placeholder="How Many of this?" required>
            <?php
              if(isset($_GET['user_id'])){ ?>
              <input type="hidden" class="form-control" name="user_id" value="<?php echo $_GET['user_id']?>">
              <?php } ?>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-6 col-sm-12">
              <h4 class="display-6">Step 1. Pick your Crust</h4>
                  <div class="container-fluid">
                      <div class="row">
                          <?php
                          $sql_get_ingredient = "SELECT * FROM `ingredients` where `step_id` = '1'";
                          $get_result = mysqli_query($conn,$sql_get_ingredient);
                          
                          if(mysqli_num_rows($get_result) > 0 ){
                              while($step1 = mysqli_fetch_assoc($get_result)){
                                 ?>
                                 <div class="col-6">
                                  <input required type="radio" class="btn-check" name="step1" value="<?php echo $step1['ingredient_id'];?>" id="<?php echo $step1['ingredient_id'];?>" autocomplete="off">
                                        <label class="btn col-12 btn-outline-danger mb-1" for="<?php echo $step1['ingredient_id'];?>">
                                           <?php echo $step1['ingredient_name'] . "<br>";?>
                                           <?php echo "Php " . number_format($step1['price_amt'],2);?>
                                           <img src="../img/<?php echo $step1['']; ?>" alt="" class="img-fluid">
                                        </label>
                                  </div>
                                  <?php
                              }
                          }
                          ?>
                      </div>
                  </div>
          </div>
          <div class="col-lg-6 col-sm-12">
              <h4 class="display-6">Step 2. Pick your Sauce</h4>
                <div class="container-fluid">
                          <div class="row">
                               <?php
                          $sql_get_ingredient = "SELECT * FROM `ingredients` where `step_id` = '2'";
                          $get_result = mysqli_query($conn,$sql_get_ingredient);
                          
                          if(mysqli_num_rows($get_result) > 0 ){
                              while($step2 = mysqli_fetch_assoc($get_result)){
                                 ?>
                                  <div class="col-6">
                                      <input required type="radio" class="btn-check" name="step2" value="<?php echo $step2['ingredient_id'];?>" id="<?php echo $step2['ingredient_id'];?>" autocomplete="off">
                                        <label class="btn col-12  btn-outline-success mb-1" for="<?php echo $step2['ingredient_id'];?>">
                                           <?php echo $step2['ingredient_name'] . "<br>";?>
                                           <?php echo "Php " . number_format($step2['price_amt'],2);?>
                                        </label>
                                  </div>
                                  <?php
                              }
                          }
                          ?>
                              
                          </div>
                      </div>
          </div>
          <div class="col-lg-6 col-sm-12">
              <h4 class="display-6">Step 3. Pick your Toppings</h4>
               <div class="container-fluid">
                          <div class="row">
                               <?php
                          $sql_get_ingredient = "SELECT * FROM `ingredients` where `step_id` = '3'";
                          $get_result = mysqli_query($conn,$sql_get_ingredient);
                          
                          if(mysqli_num_rows($get_result) > 0 ){
                              while($step3 = mysqli_fetch_assoc($get_result)){
                                 ?>
                                  
                                  <div class="col-6">
                                      <input type="radio" required class="btn-check" value="<?php echo $step3['ingredient_id'];?>" name="step3" id="<?php echo $step3['ingredient_id'];?>" autocomplete="off">
                                        <label class="btn col-12  btn-outline-warning mb-1" for="<?php echo $step3['ingredient_id'];?>">
                                           <?php echo $step3['ingredient_name'] . "<br>";?>
                                           <?php echo "Php " . number_format($step3['price_amt'],2);?>
                                        </label>
                                  </div>      
                                  <?php
                              }
                          }
                          ?>
                              
                          </div>
                      </div>
          </div>
          <div class="col-lg-6 col-sm-12">
              <h4 class="display-6">Step 4. Add Ons</h4>
               <div class="container-fluid">
                          <div class="row">
                               <?php
                          $sql_get_ingredient = "SELECT * FROM `ingredients` where `step_id` = '4'";
                          $get_result = mysqli_query($conn,$sql_get_ingredient);
                          
                          if(mysqli_num_rows($get_result) > 0 ){
                              while($step4 = mysqli_fetch_assoc($get_result)){
                                 ?>
                                      
                                  <div class="col-6">
                                <input type="radio" class="btn-check" value="<?php echo $step4['ingredient_id'];?>" name="step4" id="<?php echo $step4['ingredient_id'];?>" autocomplete="off">
                                  
                                        <label class="btn col-12  btn-outline-primary mb-1" for="<?php echo $step4['ingredient_id'];?>">
                                           <?php echo $step4['ingredient_name'] . "<br>";?>
                                           <?php echo "Php " . number_format($step4['price_amt'],2);?>
                                        </label>
                                  </div><?php
                              }
                          }
                          ?>
                              
                          </div>
                      </div>
          </div>
      </div>
<!--     Order Form-->
</form>
<?php } ?>
</div>

</body>
    <script src="../js/bootstrap.js"></script>
   </html>