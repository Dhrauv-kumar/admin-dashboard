<?php
include 'db.php';

$search = "";

if(isset($_GET['search']) && $_GET['search'] != ""){

    $search = trim($_GET['search']);

    $stmt = $pdo->prepare("
        SELECT * FROM products
        WHERE product_name LIKE ?
        OR category LIKE ?
        ORDER BY id DESC
    ");

    $stmt->execute([
        "%$search%",
        "%$search%"
    ]);

}else{

    $stmt = $pdo->prepare("
        SELECT * FROM products
        ORDER BY id DESC
    ");

    $stmt->execute();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProducts = count($products);

$totalStock = 0;
$totalValue = 0;

foreach($products as $row){

    $totalStock += $row['stock'];

    $totalValue += ($row['price'] * $row['stock']);

}

$date = date("d F Y");
$time = date("h:i:s A");

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Premium Product Dashboard</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<div class="top-bar">

<div>

<h1>🛒 Product Management Dashboard</h1>

<h3>Welcome, Admin 👋</h3>

</div>

<div class="datetime">
🕒 <span id="clock"></span>
</div>


<a href="add.php"
class="add-btn">

+ Add Product

</a>

</div>

<div class="cards">

<div class="card purple">

<div class="icon">

🛍️

</div>

<div>

<h4>Total Products</h4>

<h2><?= $totalProducts ?></h2>

</div>

</div>

<div class="card green">

<div class="icon">

📦

</div>

<div>

<h4>Total Stock</h4>

<h2><?= $totalStock ?></h2>

</div>

</div>

<div class="card orange">

<div class="icon">

💰

</div>

<div>

<h4>Total Value</h4>

<h2>

₹<?= number_format($totalValue,2) ?>

</h2>

</div>

</div>

</div>

<div class="search-box">

<form method="GET">

<input
type="text"
name="search"
placeholder="🔍 Search Product or Category..."
value="<?= htmlspecialchars($search) ?>">

</form>

</div>
<table>

<tr>

<th>S.No.</th>
<th>Product Name</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>

</tr>

<?php

$sn = 1;

foreach($products as $product):

?>

<tr>

<td><?= $sn++ ?></td>

<td><?= htmlspecialchars($product['product_name']) ?></td>

<td><?= htmlspecialchars($product['category']) ?></td>

<td>₹<?= number_format($product['price'],2) ?></td>


<td>
<?php
if($product['stock'] <= 5){
    echo "<span style='color:#ef4444;font-weight:bold;'>{$product['stock']}</span>";
}elseif($product['stock'] <= 10){
    echo "<span style='color:#f59e0b;font-weight:bold;'>{$product['stock']}</span>";
}else{
    echo "<span style='color:#22c55e;font-weight:bold;'>{$product['stock']}</span>";
}
?>
</td>
<td class="action">

<a href="edit.php?id=<?= $product['id'] ?>"
class="edit-btn">

✏ Edit

</a>

<a href="delete.php?id=<?= $product['id'] ?>"
class="delete-btn"
onclick="return confirm('Delete this product?')">

🗑 Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php if(count($products)==0): ?>

<tr>

<td colspan="6">

No Products Found

</td>

</tr>

<?php endif; ?>

</table>

<div class="footer">

<h2>🚀 Product Management Dashboard</h2>

<p> Powered by PHP • MySQL • HTML • CSS </p>

<p> Version 1.0 </p>

</p> Designed & Developed by
      <strong>Dhrauv Kumar</strong></p>

<p> © 2026 All Rights Reserved </p>

</div>

</div>
<script>
function updateClock() {
    const now = new Date();

    const options = {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    };

    const date = now.toLocaleDateString('en-IN', options);
    const time = now.toLocaleTimeString('en-IN');

    document.getElementById("clock").innerHTML = date + " | " + time;
}

updateClock();
setInterval(updateClock, 1000);
</script>
</body>

</html>