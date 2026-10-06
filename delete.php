<?php
require "config.php";

$id = (int)($_GET["id"] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $message = $stmt->affected_rows > 0 ? "Employee deleted successfully." : "Employee not found.";
} else {
    $message = "Invalid employee ID.";
}

header("Location: index.php?message=" . urlencode($message));
exit;
?>