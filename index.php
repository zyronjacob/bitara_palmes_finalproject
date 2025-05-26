<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
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
        }

        .container {
            max-width: 1250px;
            margin: 50px auto;
            background-color: #1e1e24;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
        }

        .title h4 {
            font-size: 32px;
            font-weight: bold;
            padding: 15px 30px;
            color: #ff4d4d;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #ccc;
            margin-bottom: 30px;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nav-buttons button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .nav-buttons button:hover {
            background-color: #cc0000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #552020;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #2a2a2f;
        }

        .actions a {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
            margin: 0 5px;
        }

        .search-data {
            display: flex;
            justify-content: center;
        }

        .search-data button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-data button:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <h4>Welcome!</h4>
        </div>
        <p class="subtitle">Manage and update student informations.</p>

        <div class="nav-buttons">
            <button onclick="location.href='aboutus.html'">&#8592; BACK</button>
            <button onclick="location.href='add.php'">+ ADD NEW STUDENT</button>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            $xml = new DOMDocument;
            $xml->load('cict.xml');
            $students = $xml->getElementsByTagName('student');

            foreach ($students as $student) {
                $id = $student->getElementsByTagName('id')->item(0)->nodeValue;
                $firstname = $student->getElementsByTagName('firstname')->item(0)->nodeValue;
                $lastname = $student->getElementsByTagName('lastname')->item(0)->nodeValue;
                $email = $student->getElementsByTagName('email')->item(0)->nodeValue;
                $course = $student->getElementsByTagName('course')->item(0)->nodeValue;
                $image = $student->getElementsByTagName('image')->item(0)->nodeValue;

                echo "<tr>
                        <td>$id</td>
                        <td>$firstname</td>
                        <td>$lastname</td>
                        <td>$email</td>
                        <td>$course</td>
                        <td><img src='$image' width='50' height='50' style='object-fit: cover; border-radius: 5px;' alt='Student Image'></td>
                        <td class='actions'>
                            <a href='update1.php?id=$id'>Edit</a> |
                            <a href='delete.php?id=$id'>Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>

        <div class="search-data">
            <button onclick="location.href='update.php'">SEARCH DATA</button>
        </div>
    </div>
</body>

</html>
