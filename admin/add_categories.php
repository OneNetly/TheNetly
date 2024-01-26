<?php
/* Include config.php to establish database connection */
require_once '../config.php';

/* Check if form is submitted */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Validate and sanitize input */
    $name = trim($_POST["name"]);
    $parent_id = isset($_POST["parent_id"]) ? $_POST["parent_id"] : null;

    /* Prepare SQL statement */
    $sql = "INSERT INTO categories (name, parent_id) VALUES (:name, :parent_id)";

    /* Attempt to execute the prepared statement */
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->execute();
        echo "Category added successfully.";
    } catch(PDOException $e) {
        die("ERROR: Could not execute query. " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <h2>Add Category</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="parent_id">Parent Category:</label>
            <select id="parent_id" name="parent_id">
                <option value="">Select Parent Category</option>
                <?php
                /* Fetch existing categories from the database */
                $sql = "SELECT id, name FROM categories";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <input type="submit" value="Add Category">
        </div>
    </form>
</body>
</html>

