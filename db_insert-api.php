<?php
require __DIR__. '/is_admin.php';
require __DIR__. '/db_connect.php';


$output = [
    'success' => false,
    'code' => 0,
    'error' => '參數不足',
];

if(! isset($_POST['name']) or ! isset($_POST['orderid'])){
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



$sql="INSERT INTO `custo_order`( `name`, `banana`, `strawberry`, `blueberry`, `productid`, `saleid`) VALUES (?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
        $_POST['name'],
        $_POST['banana'],
        $_POST['straw'],
        $_POST['berry'],
        $_POST['proid'],      
        $_POST['orderid'],      
        
]);

$output['rowCount'] = $stmt->rowCount();
if($stmt->rowCount()){
    $output['success'] = true;
    unset($output['error']);
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);