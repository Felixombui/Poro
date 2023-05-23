<?php
include 'config.php';
include 'header.php';
?>
<?php
// Retrieve form data
$keywords = $_POST['keywords'];
$category = $_POST['category'];
$price_range = $_POST['price_range'];
$features = $_POST['features'];

// Construct SQL query
$sql = "SELECT * FROM products WHERE 1=1"; // Start with a dummy WHERE clause

if (!empty($keywords)) {
  $sql .= " AND (name LIKE '%$keywords%' OR description LIKE '%$keywords%')";
}

if (!empty($category)) {
  $sql .= " AND category = '$category'";
}

if (!empty($price_range)) {
  $price_range_parts = explode('-', $price_range);
  $min_price = $price_range_parts[0];
  $max_price = $price_range_parts[1];
  $sql .= " AND price BETWEEN $min_price AND $max_price";
}

if (!empty($features)) {
  $features_list = implode(',', $features);
  $sql .= " AND features IN ($features_list)";
}

// Execute SQL query and display results
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Output product information here
  }
} else {
  echo "No results found.";
}
?>
 <style>
        <?php include 'styles.css' ?>
    </style>