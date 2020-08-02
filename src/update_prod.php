<?php
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "price_tracker";

    $sql = "SELECT * FROM `category`";
    
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if(mysqli_connect_error()){
        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
    }
    
    $arr_id = array();
    $arr_name = array();
    $stmt = $conn->prepare($sql);
    if(!$stmt)
        echo "Prepare Failed.. $conn->error";
    else{
        $stmt->execute();
        $query_result = $stmt->get_result();
        $rnum = $query_result->num_rows;
        
        while($row = $query_result->fetch_assoc()){
            array_push($arr_name, $row['category_name']);
            array_push($arr_id, $row['category_id']);
        }
    }
    $stmt->close();
    $conn->close();
?>
<html>
    <head>
        <title>Update Product </title>
        <link href="css/searchbar_style.css" rel="stylesheet">
        <style type="text/css">
        #add_prod_form {
            left: 50%;
            top: 50%;
            position : absolute;
            -webkit-transform: translate3d(-50%, -50%, 0);
            -moz-transform: translate3d(-50%, -50%, 0);
            transform: translate3d(-50%, -50%, 0);
        }
        </style>
        <script type = "text/javascript">
            function ChangeText(chkb) {
                var b_1 = document.getElementById('');
                var b_2 = document.getElementById('');
                var b_3 = document.getElementByID('');
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div id = "parent">
        <h1>Update Product</h1>
        <a href = "index.php"><button> Home </button></a>
        <a href = "add_prod.php"><button> Add Product </button></a>
        <a href = "delete.php"><button> Delete Product </button></a>
        <br>
        <br>
        <form name = "update_prod_form1" method="POST" id = "update_prod_form1">
            <input list="Search_prod" autofocus="autofocus" id="Searchprod" name="Searchprod" placeholder = "Search Product" style="color: rgb(0, 0, 0); float : left; Font-size : 22px;">
            <?php
                $conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

                $arr_prod = array();
                if($conn->connect_error){
                    die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                }

                $select_prodX = "SELECT full_name FROM dummy;";
            
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
            
            $conn = mysqli_connect($host, $dbuname, $dbpsd, $dbname);

            if($conn->connect_error){
                die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
            }

            $select_prodX = "SELECT full_name FROM dummy;";
        
            if($result = mysqli_query($conn, $select_prodX)){
                while($row = $result->fetch_assoc()){
                    array_push($arr_prod, $row['full_name']);
                }
            }
            $conn->close();

            ?>
            </datalist>
            <button type="submit" name="searchX" style="background-color : green; color:white; font-size:26px">Search</button>
        </form>
        <br>
        <form name = "update_prod_form2" method="POST" id = "update_prod_form2" style=" border: 1px dashed gray;">
            <table style="padding: 15px; text-align: left;"  cellspacing ="15px">
                <tr><td><input type="checkbox" id="chk" name="chk_" onclick=ChangeText()><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td>
                <td><input type="checkbox" id="chk" name="chk_" onclick=ChangeText()><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td>
                <td><input type="checkbox" id="chk" name="chk_" onclick=ChangeText()><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td>
                <td><input type="checkbox" id="chk" name="chk_" onclick=ChangeText()><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td>
                <td><input type="checkbox" id="chk" name="chk_" onclick=ChangeText()><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td>
                <br />
                <tr> <td><button type="submit" name="add_prod_submit"> Add product </button></td> </tr>
            </table>
        </form>
        </div>
        <?php
            if(isset($_POST['add_prod_submit'])){
                $file = $_FILES['prod_img'];
                $pname = $_POST['prod_name'];
                $cname = $_POST['cat_dropbox'];
                $cx = explode("select_cat_", $cname);
                $select_checkbox = $_POST['chk'];
                $bname = $_POST['new_brand'];
                $xbname = $_POST['brand_dropbox'];
                $mrp = $_POST['prod_mrp'];
                $curr_price = $_POST['prod_curr_price'];

                if($select_checkbox == 1){
                    $conn =  mysqli_connect("localhost", "root", "", "price_tracker");

                    if($conn->connect_error){
                        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                    }
                    $qury = "INSERT into brand( brand_name ) VALUES ($bname);";
                    $sql = "SELECT * from brand;";
                    mysqli_query($conn, $qury);
                    if($result = mysqli_query($conn, $sql)){
                        $row = $result->fetch_assoc();
                        $bx = $row['brand_id'];
                    }
                }else{
                    $bx = explode("select_brand_", $xbname);
                }

                $fileName = $_FILES['prod_img']['name'];
                $fileTmpName = $_FILES['prod_img']['tmp_name'];
                $fileSize = $_FILES['prod_img']['size'];
                $fileError = $_FILES['prod_img']['error'];
                $fileType = $_FILES['prod_img']['type'];
                $fileExt = explode(".", $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allow = array('jpg', 'jpeg', 'png');

                $conn =  mysqli_connect("localhost", "root", "", "price_tracker");

                if($conn->connect_error){
                    die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                }

                $sql = "INSERT INTO product values ('"; 

                if(in_array($fileActualExt, $allow)){
                    if($fileError==0){
                        if($fileSize < 1000000){
                            $fil = uniqid('',true).".".$fileActualExt; 
                            $fileDest = "images/".basename($file);
                            mysqli_query($conn, $sql);
                            if(move_uploaded_file($fileTmpName, $fileDest)){
                                echo "Successfully Added Product";
                            }else{
                                echo "Failed to Add the Product";
                            }
                        }else{
                            echo "Upload file size lesser than 1Mb";
                        }
                    }else{
                        echo "There was an error uploading the file...";
                    }
                }else{
                    echo "upload image of (jpg, jpeg, png) type..";
                }

            }
        ?>
    </body>
</html>