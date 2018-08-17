<?php
// Array of image objects to return.
$response = array();
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include 'includes/funcoes.php';
include '../includes/arrays.php';
// Image types.
$image_types = array(
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/x-png"
);

// Filenames in the uploads folder.
$fnames = scandir("uploads");

// Check if folder exists.
if ($fnames) {
    // Go through all the filenames in the folder.
    $numero = 0;
    foreach ($fnames as $name) {
        // Filename must not be a folder.
        $numero++;
        if (!is_dir($name)) {
            // Check if file is an image.
            if (in_array(mime_content_type(getcwd() . "/uploads/" . $name), $image_types)) {
                // Build the image.
                $img = new StdClass;
                $img->url = "uploads/" . $name;
                $img->thumb = "uploads/" . $name;
                $img->name = $name;

                // Add to the array of image.
                array_push($response, $img);
            }
        }
    }
    $response->error = $numero;
}

// Folder does not exist, respond with a JSON to throw error.
else {
    $response = new StdClass;
    $response->error = "Pasta inexistente!";
}

$response = json_encode($response);

// Send response.
echo stripslashes($response);
?>