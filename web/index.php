<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$primary = "PRIMARY_DB_IP";
$standby = "STANDBY_DB_IP";
$user = "appuser";
$pass = "App@123";
$db = "shopdb";

function connectDB($host, $user, $pass, $db) {
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($host, $user, $pass, $db);
    return $conn->connect_errno ? false : $conn;
}

// ===== CONNECT DB WITH FAILOVER =====
$conn = connectDB($primary, $user, $pass, $db);
$using = "PRIMARY";

if (!$conn) {
    $conn = connectDB($standby, $user, $pass, $db);
    $using = "STANDBY";
}

if (!$conn) {
    die("❌ Cannot connect to any database");
}

// ===== ADD PRODUCT =====
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $qty  = (int)$_POST['qty'];
    $conn->query("INSERT INTO products(name, quantity) VALUES ('$name', $qty)");
    header("Location: index.php");
    exit;
}

// ===== UPDATE PRODUCT =====
if (isset($_POST['update'])) {
    $id   = (int)$_POST['id'];
    $name = $_POST['name'];
    $qty  = (int)$_POST['qty'];
    $conn->query("UPDATE products SET name='$name', quantity=$qty WHERE id=$id");
    header("Location: index.php");
    exit;
}

// ===== DELETE PRODUCT =====
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: index.php");
    exit;
}

// ===== READ DATA =====
$result = $conn->query("SELECT * FROM products");
?>

<h2>Using Database: <?= $using ?></h2>

<h3>Add Product</h3>
<form method="post">
    Name: <input name="name" required>
    Qty: <input type="number" name="qty" required>
    <button name="add">Add</button>
</form>

<hr>

<h3>Product List</h3>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Qty</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<form method="post">
    <td><?= $row['id'] ?></td>
    <td><input name="name" value="<?= $row['name'] ?>"></td>
    <td><input type="number" name="qty" value="<?= $row['quantity'] ?>"></td>
    <td>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <button name="update">Update</button>
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</form>
</tr>
<?php endwhile; ?>
</table>
