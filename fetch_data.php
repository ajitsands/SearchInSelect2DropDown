<?php
$host = "localhost"; 
$user = "sandsl23_divinevoice_user"; 
$pass = "s@nds1@b"; 
$db = "sandsl23_divinevoice_magazine"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

$sql = "SELECT ids, concat(poname,' ' ,pin) as poname FROM  postalcodes WHERE poname LIKE ? or pin like ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$search_param = "%{$search}%";
$stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row['ids'],
        "text" => $row['poname']
    ];
}

// Check if there are more records
$sql_total = "SELECT COUNT(*) AS total FROM postalcodes WHERE poname LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $search_param);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_row = $result_total->fetch_assoc();
$total_records = $total_row['total'];

$response = [
    "results" => $data,
    "more" => ($offset + $limit) < $total_records
];

echo json_encode($response);
?>
