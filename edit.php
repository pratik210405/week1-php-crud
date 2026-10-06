<?php
require "config.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) {
    header("Location: index.php?message=" . urlencode("Invalid employee ID."));
    exit;
}

$stmt = $conn->prepare("SELECT name, email, phone, department FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();

if (!$employee) {
    header("Location: index.php?message=" . urlencode("Employee not found."));
    exit;
}

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
        $update = $conn->prepare("UPDATE employees SET name=?, email=?, phone=?, department=? WHERE id=?");
        $update->bind_param("ssssi", $name, $email, $phone, $department, $id);
        if ($update->execute()) {
            header("Location: index.php?message=" . urlencode("Employee updated successfully."));
            exit;
        }
        $error = "Unable to update employee.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Employee</title><link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container form-container">
    <div class="header">
        <div><h1>Edit Employee</h1><p>Update employee information</p></div>
        <a class="btn secondary" href="index.php">← Back</a>
    </div>
    <div class="card form-card">
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Full Name</label><input type="text" name="name" required value="<?= htmlspecialchars($_POST["name"] ?? $employee["name"]) ?>">
            <label>Email</label><input type="email" name="email" required value="<?= htmlspecialchars($_POST["email"] ?? $employee["email"]) ?>">
            <label>Phone</label><input type="text" name="phone" required value="<?= htmlspecialchars($_POST["phone"] ?? $employee["phone"]) ?>">
            <label>Department</label>
            <select name="department" required>
                <?php foreach (["IT","HR","Finance","Marketing","Operations"] as $d): ?>
                    <option <?= (($_POST["department"] ?? $employee["department"]) === $d) ? "selected" : "" ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn" type="submit">Update Employee</button>
        </form>
    </div>
</div>
</body>
</html>