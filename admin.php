<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="css/admin.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="container">
    <h2>Registered Details</h2>
    <?php
    // establish database connection
    $conn = mysqli_connect("localhost", "root", "", "regform");

    // check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // get years from database
    $sql = "SELECT DISTINCT year FROM tb_users";
    $year_result = mysqli_query($conn, $sql);

    // display tables for each year
    if (mysqli_num_rows($year_result) > 0) {
        while ($year_row = mysqli_fetch_assoc($year_result)) {
            $year = $year_row['year'];
            echo "<h3>Year-$year</h3>";
            $sql = "SELECT * FROM tb_users WHERE year = '$year'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Position</th><th>Image</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["department"] . "</td><td>" . $row["position"] . "</td><td><img src='" . $row["image"] . "' height='50'></td><td><form method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><input type='submit' name='delete' value='Delete'></form></td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        }
    } else {
        echo "0 results";
    }

    // delete record if form submitted
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_users WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Record deleted successfully');</script>";
        } else {
            echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
        }
    }

    // close database connection
    mysqli_close($conn);
    ?>
  </div>
</body>

</html>
