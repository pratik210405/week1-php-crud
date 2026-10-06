<?php
require "config.php";

$result = $conn->query("SELECT id, name, email, phone, department, created_at FROM employees ORDER BY id DESC");
$message = $_GET["message"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee CRUD Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Employee Management</h1>
            <p>PHP & MySQL CRUD Application</p>
        </div>
        <a class="btn" href="create.php">+ Add Employee</a>
    </div>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
                    <th>Department</th><th>Created</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row["id"] ?></td>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td><?= htmlspecialchars($row["phone"]) ?></td>
                        <td><?= htmlspecialchars($row["department"]) ?></td>
                        <td><?= htmlspecialchars($row["created_at"]) ?></td>
                        <td class="actions">
                            <a class="btn small edit" href="edit.php?id=<?= (int)$row["id"] ?>">Edit</a>
                            <a class="btn small delete" href="delete.php?id=<?= (int)$row["id"] ?>" onclick="return confirmDelete()">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="empty">No employees found. Add the first employee.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>