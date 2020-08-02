<?php
    $host = "localhost";
    $dbuname = "root";
    $dbpsd = "";
    $dbname = "price_tracker";
    
    error_reporting(-1);
    ini_set('display_errors', true);

    if(isset($_POST['product_no'])){
        $button_prod_id = $_POST['product_no'];
        #echo $button_prod_id;
        $prod_id = explode("prod_", $button_prod_id);
        $select_prodX = "SELECT product_name, product.product_id, Images, mrp, brand_name, category_name, age_group_id, available, rating, current_price FROM product, brand, category, product_details WHERE product.product_id=".$prod_id[0]." AND product.brand_id=brand.brand_id AND product.category_id=category.category_id AND product.product_id = product_details.product_id;";
    }else if(isset($_POST['searchM'])){
        $button_prod = $_POST['Searchprod'];
        #echo $button_prod;
        $select_prodX = "SELECT product_name, product.product_id, Images, mrp, brand_name, category_name, age_group_id, available, rating FROM product, brand, category, dummy WHERE product.product_id=dummy.product_id AND product.brand_id=brand.brand_id AND product.category_id=category.category_id AND dummy.full_name ='".$button_prod."';";
    }
    else{
        $select_prodX = "SELECT product_name, product.product_id, Images, mrp, brand_name, category_name, age_group_id, available, rating FROM product, brand, category WHERE product.product_id=1 AND product.brand_id=brand.brand_id AND product.category_id=category.category_id;";
    }
    
    $conn = mysqli_connect($host, $dbuname, $dbpsd, $dbname);

    if($conn->connect_error){
        die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
    }
    
    $row = NULL;
    if($result = mysqli_query($conn, $select_prodX)){
        $row = $result->fetch_assoc();
    }
    $conn->close();
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
    <link href="css/searchbar_style.css" rel="stylesheet">
    <link href="css/range_slider.css" rel="stylesheet">
    <link href="css/table_style.css" rel="stylesheet">
    <script src="js/side_panel_js.js"> </script>
    <!--<script src = "js/range_slider.js"></script> -->
    <script defer src="js/modal_script.js"></script>
</head>
<body>
    <div style="text-align : center; margin-top : 20px">
        <h1> <?php echo $row['product_name']; ?> </h1>
        <form style="text-align : center">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['Images']); ?>" width="600px" height="400px"/>  
            <br><table><tr><td><b>BRAND : </b></td> <td><?php echo $row['brand_name'];?></td>
            <tr><td><b>CATEGORY : </b></td> <td><?php echo $row['category_name'];?></td>
            <table><tr><td><b>M. R. P. (Company Price) : </b></td> <td><?php echo $row['mrp'];?></td>
            <td><b>Current (Discount) Price :</b></td><td></td>
        </form>
    </div>
</body>
</html>