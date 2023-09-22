<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// Assuming you have MySQL credentials
$servername = ".us-east-1.rds.amazonaws.com:3306";
$username = "root";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



return function ($event) use ($conn) {
    $method = $event['requestContext']['http']['method'];
    $path = $event['rawPath'];

    switch ($method) {
        case 'GET':
            return handleGET($event, $path, $conn);
        case 'POST':
            return handlePOST($event, $path, $conn);
        case 'PUT':
            return handlePUT($event, $path, $conn);
        case 'DELETE':
            return handleDELETE($event, $path, $conn);
        default:
            return json_encode(['message' => 'Unsupported method']);
    }
};


function handleGET($event, $path, $conn) {
    $name = $event['queryStringParameters']['name'] ?? null;

    if ($path === '/hello' && $name !== null) {
        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = 'Hello ' . $row["name"];
            }
        } else {
            $message = 'No records found for ' . $name;
        }

        $stmt->close();
        return json_encode(['message' => $message]);
    }

    return json_encode(['message' => 'Invalid path or missing name parameter']);
}

function handlePOST($event, $path, $conn) {
    if ($path === '/hello') {
        $postData = json_decode($event['body'], true);
        $name = $postData['name'] ?? 'world';

        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $stmt->close();
        return json_encode(['message' => 'POST Request: Hello ' . $name]);
    }

    return json_encode(['message' => 'Invalid path']);
}

function handlePUT($event, $path, $conn) {
    if ($path === '/hello') {
        $putData = json_decode($event['body'], true);
        $name = $putData['name'] ?? 'world';

        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();

        $stmt->close();
        return json_encode(['message' => 'PUT Request: Hello ' . $name]);
    }

    return json_encode(['message' => 'Invalid path']);
}

function handleDELETE($event, $path, $conn) {
    $name = $event['queryStringParameters']['name'] ?? null;

    if ($path === '/hello' && $name !== null) {
        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("DELETE FROM users WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $stmt->close();
        return json_encode(['message' => 'Delete Request: Hello ' . $name]);
    }

    return json_encode(['message' => 'Invalid path or missing name parameter']);
}


function getParameterFromPath($path, $paramName) {
    $pathParts = explode('/', $path);
    foreach ($pathParts as $i => $part) {
        if ($part === $paramName && isset($pathParts[$i+1])) {
            return $pathParts[$i+1];
        }
    }
    return null;
}
