<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require_once "db.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);

    if ($username == "" || $display_name == "") {
        $message = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $display_name);

        try {
            if ($stmt->execute()) {
                $message = "Judge added successfully!";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $message = "Error: Username already exists.";
            } else {
                $message = "Error: " . $e->getMessage();
            }
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Add Judge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Admin Panel – Add Judge</h2>

            <?php if ($message != ""): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Name</label>
                    <input type="text" name="display_name" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Judge</button>
            </form>
        </div>
    </div>
</body>
</html>
