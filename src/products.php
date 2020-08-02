<?php
    $host = "localhost";
    $dbuname = "root";
    $dbpsd = "";
    $dbname = "price_tracker";
    
    error_reporting(-1);
    ini_set('display_errors', true);

    $select_prodX = "SELECT full_name FROM dummy;";
?>
<html>
<head>
    <meta charset = "UTF-8">
    <meta name = "description" content = "DBMS project">
    <meta name = "author" content = "Manav Vagrecha, Bhumiti Gohel, Mansi Dobariya">
    <meta name = "keywords" content = "Database Management, Group Project">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://www.google.com"> -->

    <link href = "css/side_navigation_panel.css" rel="stylesheet">
    <link href="css/modal_style.css" rel="stylesheet">
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
            <h3 style="color: rgb(170, 0, 0); margin-top: 0px; margin-bottom: 1px;"> <b>Learn Comparing</b></h3>
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
            <a href = "products.htm"><button class ="bx" name= "product_btn">Product</button></a>
            <br/>
            <button class ="bx" data-modal-target = "modalQAZ" name= "discount_btn">Prices and Discount</button>
            <br/>
            <a href="#"><button class ="bx" data-modal-target = ""name= "deals_btn">Deals</button></a>
            <br />
            <a href="#"><button class = "bx"  name="demand_btn"> Demand </button></a>
            <div class="modal"  id="modalQAZ">
                <div class="modal-header">
                    <div class="title">Please select the following</div>
                    <button data-close-button class="close-button">&times;</button>
                </div>
                <div class="modal-body">
                <form method="POST">
                    <input list="Search_prod_2" autofocus="autofocus" id="Searchprod_2" name="Searchprod_2" placeholder = "Search Product" style="color: rgb(0, 0, 0); float : left; Font-size : 22px;">
                    <?php
                        $conn = mysqli_connect($host, $dbuname, $dbpsd, $dbname);

                        $arr_prod_1 = array();
                        if($conn->connect_error){
                            die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                        }
                    
                        if($result = mysqli_query($conn, $select_prodX)){
                            while($row = $result->fetch_assoc()){
                                array_push($arr_prod_1, $row['full_name']);
                            }
                        }
                        $conn->close();
                        $dummy = 0;
                    ?>  <datalist id="Search_prod_2">
                    <?php
                        while($dummy < count($arr_prod_1)):?>
                            <option value="<?php echo $arr_prod_1[$dummy]; ?>">
                            <?php
                            echo $arr_prod_1[$dummy];
                            $dummy++;
                        endwhile;
                    ?>
                    </datalist>
                    <input type="submit" name="Psearch" id="Psearch" value = "Search" style="background-color : green; color:white; font-size:26px"/>
                </form>
                <?php
                    if(isset($_POST['Psearch'])):
                        $pname = $_POST['Searchprod_2'];
                        $conn = new mysqli($host, $dbUsername, $dbPassword, "price_tracking_final");
                        if(mysqli_connect_error()):
                            die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                        endif;
                        $select_disc = "SELECT Price, date_of_price_changing, discount, description from price_details, product_details where price_details.product_id = product_details.product_id AND product_details.full_product_name ='".$name."';";
                        $stmt = $conn->prepare($select_disc);
                        if(!$stmt):
                            echo "Prepare Failed.. $conn->error";
                        else:
                            $stmt->execute();
                            $query_result = $stmt->get_result();
                            $rnum = $query_result->num_rows;
                            $dummy = 0;

                        echo "<table id='t01'>";
                        $dummy = 0;
                        while($row = $query_result->fetch_assoc()):
                            $dummy++;?>
                            <br><tr> <th> No. </th><td><?php $dummy ?></td></tr><tr> <th>Price  </th><td><?php $row['price']?></td></tr><tr><th> Date of price change </th> <td><?php $row['date_of_price_changing']?></td></tr><tr><th> Discount </th><td><?php $row['discount']?></td></tr><tr><th> Description</th><td><?php $dummy['description'] ?> </td></tr>";
                        <?php endwhile;
                        echo "</table>";
                        $stmt->close();
                        $conn->close();
                        endif;
                    endif;
                ?>
                </div>
            </div>
            <div id="overlay"></div>
            <br />

            <hr />
            <br />
            <a href = "history_buttton()"><button class = "bx" name="history_btn"> History</button></a>
            <br>
                  
        </div>
        
        <div id = "main">
            <div id = "login_bar" style="width : 100%">
                <div style="width : 15%; display: inline-block; *display: inline;">
                    <span onclick="openPanel()" style="cursor:pointer; font-size : 26px">&#9776;</span>
                </div>
                <div style="margin-top : 0px; position : relative; width : 40%; display: inline-block; *display: inline; text-align : center;">
                    <form method="POST" action="showproduct.php">
                        <input list="Search_prod" autofocus="autofocus" id="Searchprod" name="Searchprod" placeholder = "Search Product" style="color: rgb(0, 0, 0); float : left; Font-size : 22px;">
                        <?php
                            $conn = mysqli_connect($host, $dbuname, $dbpsd, $dbname);

                            $arr_prod = array();
                            if($conn->connect_error){
                                die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                            }
                        
                            if($result = mysqli_query($conn, $select_prodX)){
                                while($row = $result->fetch_assoc()){
                                    array_push($arr_prod, $row['full_name']);
                                }
                            }
                            $conn->close();
                            $dummy = 0;
                        ?>  <datalist id="Search_prod">
                        <?php
                            while($dummy < count($arr_prod)):?>
                                <option value="<?php echo $arr_prod[$dummy]; ?>">
                                <?php
                                echo $arr_prod[$dummy];
                                $dummy++;
                            endwhile;
                        ?>
                        </datalist>
                        <input type="submit" name="searchM" id="searchM" value = "Search" style="background-color : green; color:white; font-size:26px"/>
                    </form>
                </div>
                <div style="margin-top : 0px; position : relative; width : 20%; display: inline-block; *display: inline; text-align : center;">
                    <a href="add_prod.php"> <button  style = "Font-size : 22px;">Add product</button> </a>
                </div>
                <div style="margin-top : 0px; position : relative; width : 20%; display: inline-block; *display: inline; text-align : right;">
                    <button name= "sort"  data-modal-target="#modal1" style = "Font-size : 22px;"> Sorting </button>
                    <div class="modal"  id="modal1">
                        <div class="modal-header">
                            <div class="title">Select one of the Sort method</div>
                            <button data-close-button class="close-button">&times;</button>
                        </div>

                        <div class="modal-body"> 
                            <form method="POST" style = "text-align : center">
                                <input type="radio" default id="asc" name="gender" value="0">
                                <label for="asc">Asc</label>
                                <input type="radio" id="desc" name="gender  " value="1">
                                <label for="desc">Descending</label><br>
                                <input type = "submit" data-close-button name="sort" value = "Sort by Prices" />
                                <br>
                                <br>
                                
                                <input data-close-button type = "submit"  name="sort" value ="Sort by Name" />
                                <br>
                                <br>
                                
                                <input type = "submit" data-close-button name="sort" value = "Sort by Discount" />
                                <br>
                                <br>
                                <input type = "submit" data-close-button name="sort" value = "Sort by Rating" />
                                <br>
                                <br>
                                <input type = "submit" data-close-button name="sort" value = "Sort by Sell" />
                            </form>
                        </div>
                    </div>
                    <div id="overlay"></div>
                
                    <button name= "filter" data-modal-target="#modal2" style="Font-size : 22px;"> Filtering </button>
                    <div class="modal" id="modal2">
                        <div class="modal-header">
                            <div class="title">Select one of the Filter method</div>
                            <button data-close-button class="close-button">&times;</button>
                        </div>


                        <div class="modal-body" >
                            <form method="POST" style="text-align : center">
                                <input type="submit" data-close-button name="filt" value ="Select Brand"/>
                                <br>
                                <br>
                                <input type="submit" data-modal-target="#modal3" name="filt" value ="Select Price Range" />
                                <div class="modal" id="modal3">
                                    <div class="modal-header">
                                        <div class="title">Select the Min. - Max. price you wish</div>
                                        <button data-close-button class="close-button">&times;</button>
                                    </div>
                                    <div class="modal-body"> 
                                        <div class="slidecontainer" id="Min-Price">
                                            <input type="range" min="1" max="500000" value="250000" class="slider" id="Min">
                                            <p>Value : <span id="demo1"> </span></p>

                                            <? ?>
                                        </div>

                                        <div class="slidecontainer" id="Max-Price">
                                            <input type="range" min="1" max="500000" value="250000" class="slider" id="Max">
                                            <p>Value : <span id="demo2"> </span></p>

                                            <? ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <input type="submit" data-close-button name="filt" value="Select Products with Deals" />
                                <br>
                                <br>
                                <input type="submit" data-close-button name="filt" value ="Select Sale" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="workspace" style="margin-top : 10px;">
                <?php
                    $conn = mysqli_connect($host, $dbuname, $dbpsd, "price_tracking_final");
                    
                    if(isset($_POST['sort']) AND isset($_POST['gender'])){
                        if($_POST['sort'] == "Sort by Prices"){
                            if($_POST['gender'] == 0)
                                $sql = "CALL sorting_method(1, 2);";
                            else
                                $sql = "CALL sorting_method(1, 1);";
                        }else if($_POST['sort'] == "Sort by Rating"){
                            if($_POST['gender'] == 0)
                                $sql = "CALL sorting_method(4, 2);";
                            else
                                $sql = "CALL sorting_method(4, 1);";
                        }else if($_POST['sort'] == "Sort by Discount"){
                            if($_POST['sort']==0)
                                $sql = "CALL sorting_method(3, 2);";
                            else
                                $sql = "CALL sorting_method(3, 1);";
                        }else if($_POST['sort'] == "Sort by Sell"){
                            if($_POST['sort']==0)
                                $sql = "CALL sorting_method(5, 2);";
                            else
                                $sql = "CALL sorting_method(5, 1);";
                        }else if($_POST['sort'] == "Sort by Name"){
                            if($_POST['gender']==0)
                                $sql = "CALL sorting_method(2, 2);";
                            else
                                $sql = "CALL sorting_method(2, 1);";
                        }else{
                            $sql = "SELECT product_id, full_product_name, mrp, current_price from product_details";
                        }
                    }else{
                        $sql = "SELECT product_id, full_product_name, mrp, current_price from product_details";
                    }
                    
                    if($conn->connect_error):
                        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                    endif;
                    ?>
                    <table id="t01">
                        <tr> 
                            <th> No. </th>
                            <th> Product Name </th>
                            <th> M. R. P. </th>
                            <th> Current Price </th>
                        <tr>
                    <?php
                    $dum = 0;
                    if($result = mysqli_query($conn, $sql)):?>
                        <form method='POST' name = 'disp_prod' action="showproduct.php">
                        <?php
                        while($row = $result->fetch_assoc()):
                            $dum++;?>
                            <tr>
                                <td><input type="submit" id = "<?php 'prod_'.$row['product_id'] ?>" name ="product_no" value = "<?php echo $dum; ?>" /></td>
                                <td><?php echo $row['full_product_name']; ?></td>
                                <td><?php echo $row['mrp']; ?></td>
                                <td><?php echo $row['current_price']; ?></td>
                            </tr>
                        <?php
                        endwhile;
                        echo "</form>";
                    endif;
                    $conn->close();
                ?> 
                </table>
            </div>
        </div>
        
    </div>
    <script>
        var slider1 = document.getElementById("Min");
        var slider2 = document.getElementById("Max");
        
        var output1 = document.getElementById("demo1");
        var output2 = document.getElementById("demo2");
        output1.innerHTML = slider1.value;
        output2.innerHTML = slider2.value;
        
        slider1.oninput = function() {
            output1.innerHTML = slider1.value;
        }

        slider2.oninput = function() {
            output2.innerHTML = slider2.value;
        }
        
    </script>
</body>
</html>