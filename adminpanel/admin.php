<?php
// Database connection
$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "gadgetzone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all categories
function getCategories($conn) {
    $categories = [];
    $tables = ["kitchen_appliances", "smartphones", "cameras", "gadgets_accessories", "home_appliances", "computers", "televisions", "peripherals"];
    
    foreach ($tables as $table) {
        $categories[] = $table;
    }
    
    return $categories;
}

// Get all products from a category
function getProducts($conn, $category) {
    $sql = "SELECT * FROM $category";
    $result = $conn->query($sql);
    
    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    
    return $products;
}

// Get product by ID
function getProduct($conn, $category, $id) {
    $sql = "SELECT * FROM $category WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Get table columns for a category
function getTableColumns($conn, $category) {
    $sql = "SHOW COLUMNS FROM $category";
    $result = $conn->query($sql);
    
    $columns = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
    }
    
    return $columns;
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add product
    if (isset($_POST['add_product'])) {
        $category = $_POST['category'];
        $columns = getTableColumns($conn, $category);
        
        $fields = [];
        $values = [];
        
        foreach ($columns as $column) {
            if ($column != 'id' && isset($_POST[$column])) {
                $fields[] = $column;
                $values[] = "'" . $conn->real_escape_string($_POST[$column]) . "'";
            }
        }
        
        $sql = "INSERT INTO $category (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";
        
        if ($conn->query($sql) === TRUE) {
            $message = "New product added successfully";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Update product
    if (isset($_POST['update_product'])) {
        $category = $_POST['category'];
        $id = $_POST['id'];
        $columns = getTableColumns($conn, $category);
        
        $updates = [];
        foreach ($columns as $column) {
            if ($column != 'id' && isset($_POST[$column])) {
                $updates[] = "$column = '" . $conn->real_escape_string($_POST[$column]) . "'";
            }
        }
        
        $sql = "UPDATE $category SET " . implode(", ", $updates) . " WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Product updated successfully";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Delete product
    if (isset($_POST['delete_product'])) {
        $category = $_POST['category'];
        $id = $_POST['id'];
        
        $sql = "DELETE FROM $category WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Product deleted successfully";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$categories = getCategories($conn);


$selectedCategory = isset($_GET['category']) ? $_GET['category'] : (count($categories) > 0 ? $categories[0] : '');
$products = [];
$columns = [];

if ($selectedCategory) {
    $products = getProducts($conn, $selectedCategory);
    $columns = getTableColumns($conn, $selectedCategory);
}


$editProduct = null;
if (isset($_GET['edit']) && isset($_GET['category'])) {
    $editProduct = getProduct($conn, $_GET['category'], $_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель GadgetZone</title>
	 <link rel="icon" href="../photo/icon.jpg">
    <link rel="stylesheet" href="../css/style-admin.css">

</head>
<body>
    <div class="container">
        <h1>Адмін-панель GadgetZone</h1>
        
        <?php if (isset($message)): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="tabs">
            <?php foreach ($categories as $category): ?>
                <a href="?category=<?php echo $category; ?>" class="tab <?php echo ($selectedCategory == $category) ? 'active' : ''; ?>">
                    <?php echo ucwords(str_replace('_', ' ', $category)); ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="panel">
            <h2><?php echo $editProduct ? 'Редагувати товар' : 'Додати новий товар'; ?></h2>
            
            <form method="post" action="">
                <input type="hidden" name="category" value="<?php echo $selectedCategory; ?>">
                
                <?php if ($editProduct): ?>
                    <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
                <?php endif; ?>
                
                <?php if ($columns): ?>
                    <?php foreach ($columns as $column): ?>
                        <?php if ($column != 'id'): ?>
                            <div class="form-group">
                                <label for="<?php echo $column; ?>"><?php echo ucwords(str_replace('_', ' ', $column)); ?>:</label>
                                
                                <?php if (strpos($column, 'description') !== false || strpos($column, 'features') !== false || strpos($column, 'additional_features') !== false): ?>
                                    <textarea name="<?php echo $column; ?>" id="<?php echo $column; ?>" rows="4"><?php echo $editProduct ? $editProduct[$column] : ''; ?></textarea>
                                <?php else: ?>
                                    <input type="text" name="<?php echo $column; ?>" id="<?php echo $column; ?>" value="<?php echo $editProduct ? $editProduct[$column] : ''; ?>">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="form-group">
                    <?php if ($editProduct): ?>
                        <button type="submit" name="update_product">Оновити товар</button>
                    <?php else: ?>
                        <button type="submit" name="add_product">Додати товар</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="panel">
            <h2>Список товарів - <?php echo ucwords(str_replace('_', ' ', $selectedCategory)); ?></h2>
            
            <?php if (count($products) > 0): ?>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <?php foreach ($columns as $column): ?>
                                    <?php if ($column != 'id'): ?>
                                        <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <?php foreach ($columns as $column): ?>
                                        <?php if ($column != 'id'): ?>
                                            <td>
                                                <?php 
                                                    $value = $product[$column];
                                                    if (strlen($value) > 50) {
                                                        echo substr($value, 0, 50) . '...';
                                                    } else {
                                                        echo $value;
                                                    }
                                                ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td>
                                        <a href="?category=<?php echo $selectedCategory; ?>&edit=<?php echo $product['id']; ?>">
                                            <button class="button-edit">Редагувати</button>
                                        </a>
                                        <form method="post" action="" style="display: inline-block;" onsubmit="return confirm('Ви впевнені, що хочете видалити цей товар?');">
                                            <input type="hidden" name="category" value="<?php echo $selectedCategory; ?>">
                                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" name="delete_product" class="button-delete">Видалити</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Немає товарів у цій категорії.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>