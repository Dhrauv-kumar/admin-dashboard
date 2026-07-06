<?php
/* Registered Email : dkdeveloper15@gmail.com */

include 'db.php';

if(!isset($_GET['id'])){
    header("Location:index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){
    die("Product not found.");
}

$message = "";

if(isset($_POST['update'])){

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
        UPDATE products
        SET
        product_name=?,
        category=?,
        price=?,
        stock=?
        WHERE id=?
        ");

        $stmt->execute([
            $product_name,
            $category,
            $price,
            $stock,
            $id
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

<title>Edit Product</title>

<link rel="stylesheet"
href="style.css">

</head>

<body>

<div class="container">

<div class="header">

<h1>Edit Product</h1>

<a href="index.php"
class="btn">
← Dashboard
</a>

</div>

<?php if($message!=""): ?>

<p style="background:#fee2e2;padding:12px;border-radius:8px;color:#991b1b;margin-bottom:20px;">

<?= htmlspecialchars($message) ?>

</p>

<?php endif; ?>

<form method="POST">

<label>Product Name</label>

<input
type="text"
name="product_name"
value="<?= htmlspecialchars($product['product_name']) ?>"
required>

<label>Category</label>

<input
type="text"
name="category"
value="<?= htmlspecialchars($product['category']) ?>"
required>
<label>Price</label>

<input
type="number"
name="price"
step="0.01"
min="0"
value="<?= htmlspecialchars($product['price']) ?>"
required>

<label>Stock</label>

<input
type="number"
name="stock"
min="0"
value="<?= htmlspecialchars($product['stock']) ?>"
required>

<button
type="submit"
name="update"
class="btn">

Update Product

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