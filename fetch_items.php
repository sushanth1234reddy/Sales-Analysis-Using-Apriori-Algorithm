<?php
if (isset($_GET["limit"])) {
    $limit = intval($_GET["limit"]);

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "webhost");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the most purchased items from the database
    $sql = "SELECT item, count FROM sales_items ORDER BY count DESC LIMIT $limit";
    $result = $conn->query($sql);
    $items = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Send the data as JSON
    header('Content-Type: application/json');
    echo json_encode($items);
} else {
    echo "Invalid request.";
}
?>
