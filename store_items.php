<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemsetsInput = $_POST["itemsetsInput"];
    if (!empty($itemsetsInput)) {
        // Split and trim the input
        $itemsets = explode(",", $itemsetsInput);
        $itemsets = array_map("trim", $itemsets);

        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "webhost");

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert items into the database
        foreach ($itemsets as $item) {
            $item = strtolower($item);
            $sql = "INSERT INTO sales_items (item, count) VALUES ('$item', 1) ON DUPLICATE KEY UPDATE count = count + 1";
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    }
    header("Location: mainPage.html"); // Redirect back to the main page
}
?>
