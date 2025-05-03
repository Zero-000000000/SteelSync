<?php
$host = "localhost";
$dbname = "steelsync";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $query = "SELECT u.*, 
                     p.id AS position_id,
                     CASE 
                         WHEN u.role = 'employee' THEN (SELECT position FROM employee WHERE user_id = u.id)
                         WHEN u.role = 'hr_admin' THEN (SELECT position FROM hr_admin WHERE user_id = u.id)
                         WHEN u.role = 'support_admin' THEN (SELECT position FROM support_admin WHERE user_id = u.id)
                     END AS position_name
              FROM users u
              LEFT JOIN positions p ON 
                  (u.role = 'employee' AND EXISTS (SELECT 1 FROM employee e WHERE e.user_id = u.id AND e.position = p.name)) OR
                  (u.role = 'hr_admin' AND EXISTS (SELECT 1 FROM hr_admin h WHERE h.user_id = u.id AND h.position = p.name)) OR
                  (u.role = 'support_admin' AND EXISTS (SELECT 1 FROM support_admin s WHERE s.user_id = u.id AND s.position = p.name))
              WHERE u.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Account not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}

$conn->close();
