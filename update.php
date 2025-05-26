<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>SEARCH DATA</title>
  <script>
    function showData(str) {
      if (str === "") {
        document.getElementById("a").innerHTML = "";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("a").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "getinfo.php?q=" + encodeURIComponent(str), true);
      xmlhttp.send();
    }
  </script>

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

    .container-info {
      margin: 3rem auto 1rem auto;
      width: 320px;
      background-color: #1e1e24;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(255, 77, 77, 0.1);
      text-align: center;
    }

    .select-acc {
      color: #ff4d4d;
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    #selectors {
      width: 100%;
      padding: 0.6rem 1rem;
      font-size: 1rem;
      border: 2px solid #ff4d4d;
      border-radius: 6px;
      cursor: pointer;
      background-color: #2a2a2f;
      color: white;
      transition: border-color 0.3s ease;
    }

    #selectors:hover,
    #selectors:focus {
      border-color: #ff9999;
      outline: none;
    }

    #a {
      margin-top: 2rem;
      max-width: 400px;
      background: #2a2a2f;
      border: 2px solid #ff4d4d;
      border-radius: 8px;
      padding: 1rem 1.5rem;
      color: #ddd;
      box-shadow: 0 4px 12px rgba(255, 77, 77, 0.15);
      font-size: 1rem;
      line-height: 1.5;
      min-height: 80px;
      margin-left: auto;
      margin-right: auto;
      text-align: left;
      display: block;
    }

    .info-detail {
      font-weight: 500;
      display: block;
      margin-bottom: 0.5rem;
    }

    .root-tags {
      text-transform: uppercase;
      font-weight: 700;
      color: #ff4d4d;
      display: block;
      margin-bottom: 0.3rem;
    }

    .detail-text {
      font-family: 'Courier New', Courier, monospace;
      color: #ffcccc;
      display: block;
      margin-bottom: 0.5rem;
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

    @media (max-width: 500px) {
      .container-info {
        width: 90%;
        padding: 1rem;
      }

      #a {
        max-width: 90%;
      }
    }
  </style>
</head>

<body>

  <div class="container-info">
    <form>
      <h3 class="select-acc">Select Account to Display Information:</h3>
      <select name="cds" onchange="showData(this.value)" id="selectors">
        <option value="">Names:</option>
        <?php
        $xml = simplexml_load_file("cict.xml");
        foreach ($xml->student as $student) {
          $fullname = trim($student->firstname . " " . $student->lastname);
          echo "<option value=\"$fullname\">$fullname</option>";
        }
        ?>
      </select>
    </form>
  </div>

  <div id="a"><b class="info-detail">Account information will be listed here...</b></div>

  <div style="margin-top: 20px; text-align: center;">
    <button onclick="location.href='index.php'">BACK TO LIST</button>
  </div>

</body>

</html>
