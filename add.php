<?php
/* Registered Email : dkdeveloper15@gmail.com */

include 'db.php';

$message = "";

if(isset($_POST['submit'])){

    $product_name = trim($_POST['product_name']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);

    if(
        !empty($product_name) &&
        !empty($category) &&
        $price > 0 &&
        $stock >= 0
    ){

        $stmt = $pdo->prepare("
        INSERT INTO products
        (product_name,category,price,stock)
        VALUES(?,?,?,?)
        ");

        $stmt->execute([
            $product_name,
            $category,
            $price,
            $stock
        ]);

        header("Location:index.php");
        exit();

    }else{

        $message="Please fill all fields correctly.";

    }

}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Add Product</title>

<link rel="stylesheet"
href="style.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>Add Product</h1>

<a href="index.php"
class="btn">
← Dashboard
</a>

</div>

<?php if($message!=""): ?>

<p style="
background:#fee2e2;
padding:12px;
border-radius:8px;
margin-bottom:20px;
color:#991b1b;
">

<?= htmlspecialchars($message) ?>

</p>

<?php endif; ?>

<form method="POST">

<label>Product Name</label>

<input
type="text"
name="product_name"
placeholder="Enter Product Name"
required>

<label>Category</label>

<input
type="text"
name="category"
placeholder="Enter Category"
required>
<label>Price</label>

<input
type="number"
name="price"
step="0.01"
min="0"
placeholder="Enter Price"
required>

<label>Stock</label>

<input
type="number"
name="stock"
min="0"
placeholder="Enter Stock Quantity"
required>

<button
type="submit"
name="submit"
class="btn">

Save Product

</button>

<br><br>

<a href="index.php" class="btn">

← Back to Dashboard

</a>

</form>

<div class="footer">

<p>
Product Management System © 2026
</p>

</div>

</div>

</body>

</html>