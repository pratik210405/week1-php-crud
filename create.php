<?php
require "config.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($name === "" || $email === "" || $phone === "" || $department === "") {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO employees (name, email, phone, department) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $department);

        if ($stmt->execute()) {
            header("Location: index.php?message=" . urlencode("Employee added successfully."));
            exit;
        }
        $error = "Unable to add employee.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Employee</title><link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container form-container">
    <div class="header">
        <div><h1>Add Employee</h1><p>Create a new employee record</p></div>
        <a class="btn secondary" href="index.php">← Back</a>
    </div>
    <div class="card form-card">
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Full Name</label><input type="text" name="name" required value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
            <label>Email</label><input type="email" name="email" required value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            <label>Phone</label><input type="text" name="phone" required value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>">
            <label>Department</label>
            <select name="department" required>
                <option value="">Select department</option>
                <?php foreach (["IT","HR","Finance","Marketing","Operations"] as $d): ?>
                    <option <?= (($_POST["department"] ?? "") === $d) ? "selected" : "" ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn" type="submit">Save Employee</button>
        </form>
    </div>
</div>
</body>
</html>