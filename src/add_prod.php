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

    $sql = "SELECT * FROM `brand`";
    
    $arr_brand_id = array();
    $arr_brand_name = array();
    $stmt = $conn->prepare($sql);
    if(!$stmt)
        echo "Prepare Failed.. $conn->error";
    else{
        $stmt->execute();
        $query_result = $stmt->get_result();
        $rnum = $query_result->num_rows;
        
        while($row = $query_result->fetch_assoc()){
            array_push($arr_brand_name, $row['brand_name']);
            array_push($arr_brand_id, $row['brand_id']);
        }
    }
    $stmt->close();
    $conn->close();
?>
<html>
    <head>
        <title>Add Product </title>
        <link href="css/searchbar_style.css" rel="stylesheet">
        <style type="text/css">
        #add_prod_form {
            left: 50%;
            top: 50%;
            position: absolute;
            -webkit-transform: translate3d(-50%, -50%, 0);
            -moz-transform: translate3d(-50%, -50%, 0);
            transform: translate3d(-50%, -50%, 0);
        }
        </style>
        <script type = "text/javascript">
            function ChangeText(chkb) {
                var b_div = document.getElementById('brand_div_text');
                var bb_div = document.getElementById('brand_div_box');
                b_div.disabled = !chkb.checked;
                var chl1 = b_div.children;
                bb_div.disabled = chkb.checked;
                var chl2 = bb_div.children;
                
                for(var i=0; i< chl1.length; i++){
                    chl1[i].disabled = !chkb.checked;
                }
                for(var i=0; i< chl2.length; i++){
                    chl2[i].disabled = chkb.checked;
                }
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div id = "parent">
            <h1>Add Product</h1>
            <a href = "index.php"><button> Home </button></a>
            <a href = "update_prod.php"><button> Update Values </button></a>
            <a href = "delete.php"><button> Delete Product </button></a>
        
            <form name = "add_prod_form" method="POST" enctype="multipart/form-data" id = "add_prod_form" style=" border: 1px dashed gray;">
                <table style="padding: 15px; text-align: left;"  cellspacing ="15px">
                    <tr> <td> Select Category : </td> 
                    <td><select name="cat_dropbox" id = "cat_dropbox"> 
                        <?php $dummy=0;
                        while($dummy<count($arr_id)):?>
                            <option value= "<?php 'select_cal_'.$arr_id[$dummy]?>" > <?php echo $arr_name[$dummy]; ?> </option>
                        <?php
                        $dummy++; 
                        endwhile; ?>
                    </select></td></tr>
                    <tr><td> </td><td><input type="checkbox" id="chk" name="chk" onclick=ChangeText(this)><label for="chk" style="font-size : 12px"><i> Enter New Brand <i></label></td></tr>
                    <tr> <td><label>New Brand : <label></td><td>
                    <div id="brand_div_text">
                        <input type="text" placeholder="Enter Brand Name" name = "new_brand"/>
                    </div></td></tr>
                    <tr> <td><label>Select Brand : <label><br></td><td>
                    <div id="brand_div_box">
                        <select name="brand_dropbox" id = "brand_dropbox">
                            <?php $dummy=0;
                            while($dummy<count($arr_brand_id)):?>
                                <option value= "<?php 'select_brand_'.$arr_brand_id[$dummy]?>" > <?php echo $arr_brand_name[$dummy]; ?> </option>
                            <?php
                            $dummy++;
                            endwhile; ?>
                        </select>
                    </div>
                    </td> </tr>
                    <tr> <td><label>Product Name : <label></td> <td><input type="text" name="prod_name" /><td> </tr>
                    <tr> <td><label> Upload Image : <label></td> <td><input type="file" name="prod_img" /></td> </tr>
                    <tr> <td><label> M. R. P. : <label></td> <td><input type="number" step="0.01" name="prod_mrp" /></td> </tr>
                    <tr> <td><label> Current Price : <label></td> <td><input type="number" step="0.01" name="prod_curr_price" /></td> </tr>
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
                $mrp = $_POST['prod_mrp'];
                $curr_price = $_POST['prod_curr_price'];
        
                if($select_checkbox == 1){

                    $bname = $_POST['new_brand'];
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
                    $xbname = $_POST['brand_dropbox'];
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
                $imgData = addslashes(file_get_contents($fileTmpName));

                $conn =  mysqli_connect("localhost", "root", "", "price_tracker");
                        
                if($conn->connect_error){
                    die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
                }
        
                $sql = "INSERT INTO product(product_name, brand_id, category_id, age_group_id, available, mrp, Images, rating) values ('".$pname."', $bx[0], $cx[0], 1, 'Y', $mrp, ${imgData}, 0"; 
            
                if(in_array($fileActualExt, $allow)){
                    if($fileError==0){
                        if($fileSize < 1000000){
                            $fil = uniqid('',true).".".$fileActualExt; 
                            $fileDest = "images/".$fil;
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