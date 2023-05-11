<?php
require 'config.php';
if (isset($_POST["register"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $department = $_POST["department"];
  $year = $_POST["year"];
  $position = $_POST["position"];

  // Check if the username or email is already taken
  $user = mysqli_query($conn, "SELECT * FROM tb_users WHERE phone = '$phone' OR email = '$email'");
  if (mysqli_num_rows($user) > 0) {
    echo "<script> alert('Username/Email Has Already Taken'); </script>";
  } else {
    // Handle file upload
    $image = $_FILES["image"];
    if ($image["name"]) {
      $image_name = $image["name"];
      $image_tmp = $image["tmp_name"];
      $image_size = $image["size"];
      $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
      $valid_exts = array("jpg", "jpeg", "png", "gif");
      if (in_array($image_ext, $valid_exts)) {
        $image_path = "uploads/" . uniqid() . "." . $image_ext;
        move_uploaded_file($image_tmp, $image_path);
      } else {
        echo "<script> alert('Invalid Image File'); </script>";
        exit();
      }
    }

    // Insert the user data into the database
    $query = "INSERT INTO tb_users VALUES('', '$name', '$email', '$phone', '$department', '$year', '$position', '$image_path')";
    mysqli_query($conn, $query);
    echo "<script> alert('Registration Successful'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>

<body>
<div class="title">
      <h2>B-league Season-11</h2>
    </div>
  <form class="container" action="" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend><strong> Register</strong></legend>
    <div class="half">
      <div class="item">
        <label for="name">Name</label>
        <input type="text" name="name" required value="">
      </div>
      <div class="item">
        <label for="email">Email</label>
        <input type="email" name="email" required value="">
      </div>
    </div>
    <div class="half">
      <div class="item">
        <label for="phone">Phone</label>
        <input type="tel" name="phone" required value="">
      </div>
      <div class="item">
        <label for="department">Department</label>
        <input type="text" name="department" required value="">
      </div>
    </div>
    <div class="full">
      <div class="item">
        <label for="year">Year</label>
        <input type="text" name="year" required value="">
        <!-- <select name="year" id="year" required >
          <option value="Select">--Select Year--</option>
          <option value="">First</option>
          <option value="">Second</option>
          <option value="">Third</option>
          <option value="">Fourth</option>
        </select> -->
      </div>
      <div class="item">
        <label for="position">Position</label>
        <input type="text" name="position" required value="">
      </div>
      <div class="item">
        <label for="image">Image</label>
        <input type="file" name="image" accept="image/*">
      </div>
    </div>
    <div class="action">
      <input type="submit" name="register" value="REGISTER">
      <marquee behavior="" direction="ltr">**<strong> Registration Fee</strong> has to be paid to <em> Organizing committie(Astrox)</em> (Only paid player will be shortlisted for Auction ).**</marquee>
    </div>
    </fieldset>
  </form>
  <footer>
    <p><em>Astrox</em>  proudly presents B-league season-11</p>
  </footer>
</body>

</html>