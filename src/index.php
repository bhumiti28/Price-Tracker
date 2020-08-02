<?php
    error_reporting(-1);
    ini_set('display_errors', true);

    session_start();
    
    $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(strpos($fullUrl, "logid=")){
        $arr = explode("logid=", $fullUrl);
        $_SESSION['u_id'] = $arr[1];
    }else{
        $_SESSION['u_id'] = NULL;
    }
    
    $uid = "qwerty_322";

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "price_tracking_final";
    
    $select_cat = "SELECT * FROM `category`";
    $select_deals = "SELECT deals_details, full_product_name, current_price from deals, product_details WHERE deals.product_id = product_details.product_id";

    $arr_category = array();
    $arr_cat_id = array();

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if(mysqli_connect_error()):
        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
    endif;
    
    $stmt = $conn->prepare($select_cat);
    if(!$stmt):
        echo "Prepare Failed.. $conn->error";
    else:
        $stmt->execute();
        $query_result = $stmt->get_result();
        $rnum = $query_result->num_rows;
        while($row = $query_result->fetch_assoc()):
            array_push($arr_cat_id, $row['category_id']);
            array_push($arr_category, $row['category_name']);
        endwhile;
        $stmt->close();
    endif;

    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Price Advisor</title>

    <meta charset = "UTF-8">
    <meta name = "description" content = "DBMS project">
    <meta name = "author" content = "Manav Vagrecha, Bhumiti Gohel, Mansi Dobariya">
    <meta name = "keywords" content = "Database Management, Group Project">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://www.google.com">

    <link href = "css/side_navigation_panel.css" rel="stylesheet">
    <link href="css/modal_style.css" rel="stylesheet">
    <link href="css/searchbar_style.css" rel="stylesheet">
    <link href="css/range_slider.css" rel="stylesheet">
    <link href="css/table_style.css" rel="stylesheet">

    <script src="js/side_panel_js.js"> </script>
    <!--<script src = "js/range_slider.js"></script> -->
    <script defer src="js/modal_script.js"></script>
</head>

<body>
    <div id="heading" style ="margin-top: 10px;">
        <div style="float: left; width: 50%; height: auto;" id="project_name">
            <h1 style="float: left; color: rgb(4, 204, 4); margin-top: 0px;">PRICE</h2>
            <h1 style="float: left; color: rgb(170, 0, 0); margin-top: 0px;"> Tracker</h3>
        </div>

        <div id="tag_line" style="float: right; width: 50%; height: auto; text-align: right;">
            <h3 style="color: rgb(170, 0, 0); margin-top: 0px; margin-bottom: 1px;"><b>Learn Comparing</b></h3>
            <h5 style="font-family: 'Segoe UI', Arial, sans-serif; margin-top: 1px;"><i>Collaborative project by Manav, Bhumiti and Mansi</i></h5>
        </div>
    </div>
    <br>
    <br>

    <div id="display_space" style="background-color: rgb(0, 2, 2); height: 2px;  position: relative; margin-top: 5px; margin-bottom: 0px;">
    </div>
    <br />

    <div id="box">
        <div id="sidepanel_css" class="sidenav">
            <a href = "javascript:void(0)" class="closebtn" onclick="closePanel()">&times;</a>
            <br />
            <br />

            <a href = "products.php"><button class ="bx" name= "product_btn">Product</button></a>
            <br />
            <a href = "discount.php"><button class ="bx" name= "price_btn" >Discount</button></a>
            <br />
            
            <button class ="bx" data-modal-target ="#modal3" id name= "deals_btn">Deals</button>
            <?php

                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                if(mysqli_connect_error()):
                    die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                endif;

                $stmt = $conn->prepare($select_deals);
                if(!$stmt):
                    echo "Prepare Failed.. $conn->error";
                else:
                    $stmt->execute();
                    $query_result = $stmt->get_result();
                    $rnum = $query_result->num_rows;
                    $dummy = 0;
            ?>
            <div class="modal"  id="modal3">
                <div class="modal-header">
                    <div class="title">Following are the Deals on specified Product</div>
                    <button data-close-button class="close-button">&times;</button>
                </div>
                <div class="modal-body">    
                <?php
                    echo "<table id='t01'>";
                    echo "<tr> <th> No. </th> <th> Product Name </th> <th> Deal Details </th> <th> Current </th> </tr>";
                    $dummy = 0;
                    while($row = $query_result->fetch_assoc()){
                        $dummy++;
                        echo "<tr> <td>".$dummy."</td><td>".$row['full_product_name']."</td> <td>".$row['deals_details']."</td> <td>".$row['current_price']."</td> </tr>";
                    }
                    echo "</table>";
                    $stmt->close();
                    $conn->close();
                    endif;
                ?>
                </div>
            </div>
            <div id="overlay"></div>
            <br />
            
            <hr />
            <br />
            <button class = "bx" data-modal-target="#modal4" name="history_btn"> History</button>
            <div class="modal"  id="modal4">
                <div class="modal-header">
                    <?php
                        if($uid == NULL){
                            echo "Error";
                        }else{
                            echo "Your history is as Follows :";
                        }
                    ?>
                    <button data-close-button class="close-button">&times;</button>
                </div>
                <div class="modal-body">
                    <?php
                    if($uid == NULL):
                        echo "To track your history... please register..";
                    else:
                        $sql = "SELECT search_word, description, time_src FROM history where user_id='".$uid."' ";
                        $conn = mysqli_connect($host, $dbUsername, $dbPassword, "price_tracker");

                        if($conn->connect_error):
                            die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                        endif;
                        echo "<table id='t01'>";
                        echo "<tr> <th> Product Name </th> <th> Description </th> <th> Time </th> </tr>";
                        if($res = $conn->query($sql)){
                            while($row = $res->fetch_assoc()){
                                echo "<tr> <td>".$row['search_word']."</td> <td>".$row['description']."</td> <td>".$row['time_src']."</td> </tr>";
                            }
                        }echo "</table>";
                        $conn->close();
                    endif;
                    ?>
                </div>
            </div>
            <div id="overlay"></div>
            <br />         
        </div>
        
        <div id = "menubar" style="margin-top: 0px;">
            <span onclick="openPanel()" style="cursor:pointer; font-size : 30px">&#9776;</span>
            
            <?php 
            if(isset($_SESSION['user_id'])): 
                echo "<form method='POST' action='".userLogout()."'>";  ?>
                <button type="submit" name="userlogout" id="logout-button" class="button-logout">LOGOUT</button>

            <?php else: ?>
                <a href="login_reg_form.htm"><button type="button" id="login" style="float:right; margin-top: 0;">Login</button></a>
            </form>
            <?php endif;
            ?>
        </div>
        <div id="main">
            <form method="POST" style="margin : auto auto; width:600px; height: 250px">
                <div class = "text-center" style="margin = 0; position: relative; top: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
                    <label style="font-size: 32px; "> <b>Free Price Tracker for Amazon</b> </label>
                    <br><br>
                    <input type="text" name="keyword" id="inputBox" autofocus="autofocus" autocomplete="off"  placeholder = "Enter Product or Brand" style="color: rgb(0, 0, 0);float : left;">
                    <input type="submit" name="searchX" data-modal-target="#modalW" id="search_submit" style="float : right; background-color : green" value="Search"/>
                </div>
            </form>
            <?php
                if (isset($_POST['searchX'])){
                    $prod_name = $_POST['searchX'];
                }else{
                    $prod_name = NULL;
                }

                $sql="CALL search_prod('".$prod_name."')";

                $conn = mysqli_connect($host, $dbUsername, $dbPassword, "price_tracking_final");
                    if($conn->connect_error):
                        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                    endif;
                        ?>
                    <div class="modal"  id="modalW">
                        <div class="modal-header">
                            <div class="title">Products as per your Search</div>
                            <button data-close-button class="close-button">&times;</button>
                        </div>
                        <div class="modal-body">
                            <?php 
                            $dummy = 0;
                            echo "<table id='t01'>";
                            echo "<tr> <th> No. </th> <th> Product Name </th> <th> MRP </th> <th> Current Price </th> </tr>";
                            if($res = $conn->mysqli_query($sql)){
                                while($row = $res->fetch_assoc()){
                                    $dummy++;
                                    echo "<tr> <th>".$dummy."</th> <th>".$row['full_product_name']."</th> <th>".$row['mrp']."</th> <th>".$row['current_price']."</th></tr>";
                                }
                            }echo "</table>";
                            $conn->close();
                            ?>
                        </div>
                    </div>
                <br />
            <br />
            <div id ="disp-category" class="text-center" style="margin : auto auto; top:50%; position: relative; width : 600px; height :200px">
                <form method="POST" name="cat_form">
                    <label style="font-size: 24px; color : grey "> <i>Select from the following categories</i> </label>
                    <br />
                    <?php
                        $dummy = 0;
                        while($dummy < count($arr_category)):
                    ?>
                        <button type="submit" name = "cat_names" data-modal-target = "#modalX" id="<?php "cat_".$arr_cat_id[$dummy]?>"> <? echo $arr_category[$dummy];?></button>
                    <?php 
                        $dummy++;
                    endwhile;
                    if(isset($_POST['cat_names'])){
                        #echo "svbbzc";
                        $cat_num = $_POST['cat_names'];
                    }else{
                        $cat_num = NULL;
                        #echo "anfjkngkwrg";
                    }
                    echo $cat_num;
                    $d = array();
                    $d = explode("cat_", $cat_num);

                    $select_brand = "CALL SHOW_BRAND(".(int)$d[0].");";
                    
                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if(mysqli_connect_error()):
                        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                    endif;
                    
                    $stmt = $conn->prepare($select_cat);
                    
                    if(!$stmt):
                        echo "Prepare Failed.. $conn->error";
                    else:
                        $stmt->execute();
                        $query_result = $stmt->get_result();
                        $rnum = $query_result->num_rows;
                        $dummy = 0;?>
                        <div class="modal"  id="modalX">
                            <div class="modal-header">
                                <div class="title">SELECT Brand Name</div>
                                <button data-close-button class="close-button">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="GET">
                                <?php
                                while($row = $query_result->fetch_assoc()):
                                    $dummy++;
                                    ?>
                                    <button type="submit" name = "brand_names" id="<?php "brand_".$row['brand_id']?>"> <? echo $row['brand_name'];?></button>
                                <?php        
                                endwhile;
                                $stmt->close();
                                $conn->close();?>
                                </form>
                            </div>
                        </div>
                        <div id="overlay"></div>
                        <br />
                    
                    <?php   
                    endif;
                    


                    $select_prod = "SELECT `product_id`, `product_name`, ";

                    
                    ?>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>