<?php
error_reporting(-1);
ini_set('display_errors', true);

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "price_tracker";

$select = "SELECT * FROM `category`";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if(mysqli_connect_error()):
    die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
endif;

$stmt = $conn->prepare($select);
if(!$stmt):
    echo "Prepare2 Failed.. $conn->error";
else:
    $stmt->execute();
    $query_result = $stmt->get_result();
    $rnum = $query_result->num_rows;
    echo $rnum;
    $dummy = 0;
    while($row = $query_result->fetch_assoc()): ?>
        <div>
            <?php $dummy++;?>
            <button id="<?php "button_".$dummy;?>"> <? echo $row['category_name'];?></button>
        </div>
    <?php endwhile;
    $stmt->close();
    $conn->close();
endif;

