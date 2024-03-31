<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['err'] = "You must be logged in to update your profile image.";
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileName = $_FILES['picture']['name'];
        $fileSize = $_FILES['picture']['size'];
        $fileType = $_FILES['picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = array("jpg", "png", "gif");

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = '/uploads/pictures';
            $newFileName = uniqid() . '.' . $fileExtension;
            $destPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . '/' . $newFileName;

            // Ensure the destination directory exists
            if (!file_exists(dirname($destPath))) {
                mkdir(dirname($destPath), 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $sql = "UPDATE users SET profile_image = :profile_image WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $success = $stmt->execute(array(':profile_image' => $uploadDir . '/' . $newFileName, ':id' => $_SESSION['user_id'])); 

                if ($success) {
                    $_SESSION['profileimg']= $uploadDir . '/' . $newFileName;
                    $_SESSION['success'] = "File uploaded successfully.";
                } else {
                    $_SESSION['err'] = "Failed to update the database.";
                }
            } else {
                $_SESSION['err'] = "Failed to move the uploaded file.";
            }
        } else {
            $_SESSION['err'] = "Only .jpg, .png, or .gif files are allowed.";
        }
    } else {
        $_SESSION['err'] = "No file uploaded or an error occurred during upload.";
    }
} else {
    $_SESSION['err'] = "Invalid request method";
}

header("Location: ../account");
exit;
?>

