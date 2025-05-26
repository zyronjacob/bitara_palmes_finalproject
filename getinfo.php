<?php
$q = $_GET["q"];

$xmlDoc = new DOMDocument();
$xmlDoc->load("cict.xml");

$students = $xmlDoc->getElementsByTagName('student');
$foundStudent = null;

foreach ($students as $student) {
  $firstName = $student->getElementsByTagName('firstname')->item(0)->nodeValue ?? '';
  $lastName = $student->getElementsByTagName('lastname')->item(0)->nodeValue ?? '';
  $fullName = trim($firstName . " " . $lastName);

  if ($fullName === $q) {
    $foundStudent = $student;
    break;
  }
}

if ($foundStudent !== null) {
  //Show the image if available
  $imageNode = $foundStudent->getElementsByTagName('image')->item(0);
  if ($imageNode) {
    $imageSrc = htmlspecialchars($imageNode->nodeValue);
    echo "<div class='info-item image-container'>
          <img src='{$imageSrc}' alt='Student Image' class='student-img'>
        </div>";
  }

  // Show ID 
  $idNode = $foundStudent->getElementsByTagName('id')->item(0);
  if ($idNode) {
    echo "<div class='info-item'><span class='info-label'>ID:</span><span class='info-value'>" . htmlspecialchars($idNode->nodeValue) . "</span></div>";
  }

  // Full name
  echo "<div class='info-item'><span class='info-label'>Name:</span><span class='info-value'>" . htmlspecialchars($fullName) . "</span></div>";

  // Display other fields except id, firstname, lastname, image
  $skipFields = ['id', 'firstname', 'lastname', 'image'];
  foreach ($foundStudent->childNodes as $child) {
    if ($child->nodeType === 1 && !in_array($child->nodeName, $skipFields)) {
      $fieldName = ucfirst($child->nodeName);
      $value = htmlspecialchars($child->nodeValue);
      echo "<div class='info-item'><span class='info-label'>{$fieldName}:</span><span class='info-value'>{$value}</span></div>";
    }
  }
} else {
  echo "<div class='info-item'><span class='info-label'>No data found for \"{$q}\"</span></div>";
}
?>

<html>
<head>
  <style>
    .info-item {
      display: flex;
      justify-content: space-between;
      padding: 8px 12px;
      margin: 10px 0;
      border-radius: 10px;
      background-color: #f9f9fb;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
      margin-bottom: 0;
    }

    .info-label {
      font-weight: 600;
      color: #1e2a38; 
      flex: 1;
    }

    .info-value {
      flex: 2;
      text-align: right;
      font-family: 'Courier New', Courier, monospace;
      color:rgb(27, 21, 22); 
      overflow-wrap: break-word;
    }

    .student-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #ff4d4d; 
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .info-item.image-container {
      justify-content: center;
      background: none;
      box-shadow: none;
    }
  </style>
</head>

<body>