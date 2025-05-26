<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Delete Student</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body,
    html {
      height: 100%;
      background-color: #0e0e11;
      color: white;
    }

    main {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      text-align: center;
    }

    h2 {
      color: #ff4d4d;
      margin-bottom: 30px;
      font-size: 2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    form {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }

    select {
      padding: 10px 15px;
      font-size: 1rem;
      border-radius: 5px;
      border: 2px solid #ff4d4d;
      min-width: 250px;
      background-color: #2a2a2f;
      color: white;
    }

    button {
      padding: 10px 20px;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      border: 2px solid #ff4d4d;
      background-color: #ff4d4d;
      color: white;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    button:hover {
      background-color: transparent;
      color: #ff4d4d;
    }

    .back-btn {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <main>
    <h2>Choose Name to Delete</h2>
    <form method="POST">
      <select name="fullname" required>
        <option value="">Select Name</option>
        <?php
        $xml = simplexml_load_file("cict.xml");
        foreach ($xml->student as $stud) {
          $firstname = trim((string) $stud->firstname);
          $lastname = trim((string) $stud->lastname);
          $fullname = $firstname . ($lastname ? " $lastname" : "");
          echo "<option value=\"$fullname\">$fullname</option>";
        }
        ?>
      </select>
      <button type="submit" name="submit">DELETE</button>
    </form>

    <div class="back-btn">
      <button onclick="location.href='index.php'">BACK TO LIST</button>
    </div>

    <?php
    if (isset($_POST['submit'])) {
      $input = trim($_POST['fullname']);
      $inputParts = explode(' ', $input);

      $xml = new DOMDocument();
      $xml->formatOutput = true;
      $xml->load('cict.xml');
      $students = $xml->getElementsByTagName('student');
      $root = $xml->getElementsByTagName('Students')->item(0);
      $found = false;

      foreach ($students as $student) {
        $fname = trim($student->getElementsByTagName('firstname')->item(0)->nodeValue);
        $lname = trim($student->getElementsByTagName('lastname')->item(0)->nodeValue);

        if (count($inputParts) === 1) {
          if (strcasecmp($fname, $inputParts[0]) == 0) {
            $root->removeChild($student);
            $found = true;
          }
        } elseif (count($inputParts) >= 2) {
          $full = $fname . " " . $lname;
          if (strcasecmp($full, $input) == 0) {
            $root->removeChild($student);
            $found = true;
          }
        }
      }

      if ($found) {
        $xml->save('cict.xml');
        echo "<script>alert('Deleted Successfully: $input'); location.href='index.php';</script>";
      } else {
        echo "<script>alert('No match found for: $input');</script>";
      }
    }
    ?>
  </main>
</body>

</html>
