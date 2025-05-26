<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ADD STUDENT</title>
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
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #1e1e24;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #ff4d4d;
            font-size: 24px;
            font-weight: 700;
        }

        .back-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 16px;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background-color: #cc0000;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            font-size: 15px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            background-color: #2a2a2f;
            color: white;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-group button,
        .btn-group a {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
            width: 48%;
            text-align: center;
        }

        .btn-group button:hover,
        .btn-group a:hover {
            background-color: #cc0000;
        }

        @media (max-width: 500px) {
            .btn-group {
                flex-direction: column;
                gap: 10px;
            }

            .btn-group button,
            .btn-group a {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Add New Student</h1>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID:</label>
                <input type="number" name="id" required>
            </div>
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="firstname" required>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="lastname" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" required>
            </div>
            <div class="form-group">
                <label>Course:</label>
                <input type="text" name="course" required>
            </div>
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <div class="btn-group">
                <button type="submit" name="submit">ADD</button>
                <a href="index.php">VIEW DATA</a>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $course = $_POST['course'];

            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $imageName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $imageName;
            $imageType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $validExtensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageType, $validExtensions)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $xml = new DOMDocument;
                    $xml->load('cict.xml');

                    $students = $xml->getElementsByTagName('student');
                    $idExists = false;

                    foreach ($students as $student) {
                        $existingId = $student->getElementsByTagName('id')->item(0)->nodeValue;
                        if ($existingId == $id) {
                            $idExists = true;
                            break;
                        }
                    }

                    if ($idExists) {
                        echo "<script>alert('ID already exists. Please use a unique ID.');</script>";
                    } else {
                        $newStudent = $xml->createElement('student');
                        $newStudent->appendChild($xml->createElement('id', $id));
                        $newStudent->appendChild($xml->createElement('firstname', $firstname));
                        $newStudent->appendChild($xml->createElement('lastname', $lastname));
                        $newStudent->appendChild($xml->createElement('email', $email));
                        $newStudent->appendChild($xml->createElement('course', $course));
                        $newStudent->appendChild($xml->createElement('image', $targetFilePath));

                        $xml->getElementsByTagName('Students')->item(0)->appendChild($newStudent);
                        $saved = $xml->save("cict.xml");

                        if ($saved) {
                            echo "<script>alert('Record added successfully!'); location.href='add.php';</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Failed to upload image.');</script>";
                }
            } else {
                echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            }
        }
        ?>
    </div>
</body>

</html>
