<?php
// Define the output directory
$outputDirectory = 'resultsUploads/';

// Check if the output directory exists, create if it doesn't
if (!is_dir($outputDirectory)) {
    mkdir($outputDirectory, 0755, true);
}

// Read the raw input data
$imageData = file_get_contents('php://input');

// Check if data is received
if ($imageData !== false) {
    // Generate a random filename
    $randomFilename = uniqid('image_', true) . '.png';
    $outputPath = $outputDirectory . $randomFilename;

    // Save the binary data to a file
    if (file_put_contents($outputPath, $imageData) !== false) {
        // Construct the URL to the uploaded image
        $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $outputPath;

        // Return the URL to the client
        echo json_encode(['message' => 'Image uploaded successfully!', 'url' => $imageUrl]);
    } else {
        echo json_encode(['error' => 'Failed to save the image.']);
    }
} else {
    echo json_encode(['error' => 'No data received.']);
}
?>
