<?php

@include 'config.php';
if(isset($_POST['add_product'])){
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
        $insert = "INSERT INTO product(name,description,price,quantity,image) VALUES ('$product_name', '$product_description','$product_price',
        '$product_quantity','$product_image')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New Product Added Successfully';
        }
        else{
            $message[] = 'Could not add the product';
        }
    }
};
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM product WHERE id= $id");
    header("location:admin_page.php");
    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin.css">
    <title>Admin Page</title>
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
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3>Add new product</h3>
            <input type="text" placeholder="Enter product name" name="product_name" class="box">
            <input type="text" placeholder="Enter description" name="product_description" class="box">
            <input type="number" placeholder="Enter product price" name="product_price" class="box">
            <input type="number" placeholder="Quantity in stock" name="product_quantity" class="box">
            <input type="file" accept = "image/png image/jpg image/jpeg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="add a product">
            </form>
        </div>

    <?php
        $select = mysqli_query($conn, "SELECT * from product");
    ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                        <th>Product Image</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

           <?php
          while($row = mysqli_fetch_assoc($select)){ ?>
            <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><img src="productpic/<?php echo $row['image']; ?>" alt="" height = "100"></td>
                        <td>
                            <a href="update.php?edit=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-edit"></i>Update</a>
                            <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-trash"></i>Delete</a>
                        </td>
            </tr>

    <?php };  ?>
            </table>
        </div>
    </div>
</body>
</html>