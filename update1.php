<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UPDATE DATA</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #0e0e11;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #1e1e24;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            justify-content: center;
        }

        .header h1 {
            color: #ff4d4d;
            font-size: 26px;
            font-weight: bold;
            justify-content: center;
        }

        .back-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background-color: #cc0000;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 15px;
            margin-bottom: 5px;
            color: #ddd;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            background-color: #2a2a2f;
            color: white;
            width: 100%;
        }

        img {
            border-radius: 5px;
            width: 100px;
            height: 100px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-group button,
        .btn-group a {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
            flex: 1;
            text-align: center;
        }

        .btn-group button:hover,
        .btn-group a:hover {
            background-color: #cc0000;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .image-row {
            display: flex;
            align-items: center;
            gap: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Update Student</h1>
        </div>

        <?php
        if (!isset($_GET['id'])) {
            echo "<p>No ID specified.</p>";
            exit;
        }

        $id = $_GET['id'];
        $xml = new DOMDocument;
        $xml->load('cict.xml');

        $students = $xml->getElementsByTagName('student');
        $studentToUpdate = null;

        foreach ($students as $student) {
            if ($student->getElementsByTagName('id')->item(0)->nodeValue == $id) {
                $studentToUpdate = $student;
                break;
            }
        }

        if (!$studentToUpdate) {
            echo "<p>Student with ID $id not found.</p>";
            exit;
        }

        $firstname = $studentToUpdate->getElementsByTagName('firstname')->item(0)->nodeValue;
        $lastname = $studentToUpdate->getElementsByTagName('lastname')->item(0)->nodeValue;
        $email = $studentToUpdate->getElementsByTagName('email')->item(0)->nodeValue;
        $course = $studentToUpdate->getElementsByTagName('course')->item(0)->nodeValue;
        $imagePath = $studentToUpdate->getElementsByTagName('image')->item(0)->nodeValue;

        if (isset($_POST['submit'])) {
            $firstnameNew = $_POST['firstname'];
            $lastnameNew = $_POST['lastname'];
            $emailNew = $_POST['email'];
            $courseNew = $_POST['course'];

            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $newImagePath = $imagePath;
            if (!empty($_FILES["image"]["name"])) {
                $imageName = basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $imageName;
                $imageType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $validExtensions = array("jpg", "jpeg", "png", "gif");

                if (in_array($imageType, $validExtensions)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $newImagePath = $targetFilePath;
                    } else {
                        echo "<script>alert('Failed to upload new image.');</script>";
                    }
                } else {
                    echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
                }
            }

            $studentToUpdate->getElementsByTagName('firstname')->item(0)->nodeValue = $firstnameNew;
            $studentToUpdate->getElementsByTagName('lastname')->item(0)->nodeValue = $lastnameNew;
            $studentToUpdate->getElementsByTagName('email')->item(0)->nodeValue = $emailNew;
            $studentToUpdate->getElementsByTagName('course')->item(0)->nodeValue = $courseNew;
            $studentToUpdate->getElementsByTagName('image')->item(0)->nodeValue = $newImagePath;

            $saved = $xml->save('cict.xml');

            if ($saved) {
                echo "<script>alert('Record updated successfully!'); window.location.href='index.php';</script>";
                exit;
            } else {
                echo "<script>alert('Failed to save updated record.');</script>";
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID:</label>
                <input type="number" name="id" value="<?php echo htmlspecialchars($id); ?>" disabled>
            </div>
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label>Course:</label>
                <input type="text" name="course" value="<?php echo htmlspecialchars($course); ?>" required>
            </div>
            <div class="form-group">
    <label>Current Image:</label>
    <div class="image-row">
        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Current Image">
        <div style="display: flex; flex-direction: column;">
            <label style="margin-bottom: 5px;">Change:</label>
            <input type="file" name="image" accept="image/*">
        </div>
    </div>
</div>

            <div class="btn-group">
                <button type="submit" name="submit">UPDATE</button>
                <a href="index.php">BACK TO LIST</a>
            </div>
        </form>
    </div>
</body>

</html>