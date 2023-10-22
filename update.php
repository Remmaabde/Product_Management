<?php
@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'productpic/'.$product_image; 

    if(empty($product_name) || empty($product_description) || empty($product_price) || empty($product_quantity) || empty($product_image)){
        $message[] = 'Please fill all';
    }
    else{
        $update = "UPDATE product SET name='$product_name', description = '$product_description',
         price = '$product_price', quantity = '$product_quantity' , image = '$product_image' WHERE id = $id";
        $upload = mysqli_query($conn,$update);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'Product updated Successfully';
        }
        else{
            $message[] = 'Could not add the product';
        }
    }
};



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php

if(isset($message)){
    foreach($message as $message){
        echo '<span class = "message">' .$message.'</span>';
    }
}
?>

<div class="container">
<div class="admin-product-form-container centered">

<?php

$select = mysqli_query($conn,"SELECT * FROM product WHERE id = $id");
while($row = mysqli_fetch_assoc($select)){


?>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3>Update product</h3>
            <input type="text" placeholder="Enter product name" value = "<?php $row['name'];?>" name="product_name" class="box">
            <input type="text" placeholder="Enter description" name="product_description" class="box">
            <input type="number" placeholder="Enter product price" value= "<?php $row['price'];?>" name="product_price" class="box">
            <input type="number" placeholder="Quantity in stock" name="product_quantity" class="box">
            <input type="file" accept = "image/png image/jpg image/jpeg" name="product_image" class="box">
            <input type="submit" class="btn" name="update_product" value="update a product">
            <a href="admin_page.php" class="btn">Go back</a>
            </form>
            <?php };?>
        </div>
</div>

</body>
</html>