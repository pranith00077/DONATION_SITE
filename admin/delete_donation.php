    <?php
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => ''];

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the raw POST data
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Check if ID is provided
        if (isset($data['id']) && is_numeric($data['id'])) {
            $donationId = $data['id'];

            // Database connection (replace with your actual connection details)
            $servername = "localhost";
            $username = "root"; // Your database username
            $password = "";
            $dbname = "ngo_site"; // Your database name

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare and execute the DELETE statement
                $stmt = $conn->prepare("DELETE FROM donations WHERE id = :id");
                $stmt->bindParam(':id', $donationId, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $response['success'] = true;
                    $response['message'] = "Donation with ID $donationId deleted successfully.";
                } else {
                    $response['message'] = "No donation found with ID $donationId or already deleted.";
                }
            } catch (PDOException $e) {
                $response['message'] = "Database error: " . $e->getMessage();
            } finally {
                $conn = null; // Close connection
            }
        } else {
            $response['message'] = "Invalid or missing donation ID.";
        }
    } else {
        $response['message'] = "Invalid request method.";
    }

    echo json_encode($response);
    ?>
    