<!DOCTYPE html>
<html lang="en">

<head>
  <!-- meta tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="author" content="Bella Felaco" />
  <meta name="description" content="Charlottesville Renter's Application" />
  <meta name="keywords" content="UVA Charlottesville Rent Renter Renting Apartment Apartments" />

  <!-- title -->
  <title>CVille 4 Rent: Profile</title>

  <!-- styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>

  <link rel="stylesheet/less" type="text/css" href="main.less" />
  <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>

<body>
  <!-- <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?> -->
  <?php include '/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/components/navbar.php'; ?>

  <h1>Profile</h1>

  <div class="base-container">
    <!-- user email address -->
    <div class="col-md-4">
      <label for="update-email" class="form-label">Email Address</label>
      <div id="update-email" class="input-group mb-3">
        <input type="text" class="form-control" placeholder="User"
          value="<?= isset($_SESSION['user']) ? $_SESSION['user'] : ''; ?>" disabled>
      </div>
    </div>
    <div class="btn-group" role="group">
      <a role="button" href="?command=favorites" class="btn btn-outline-dark">View Favorite Apartments</a>
      <a role="button" href="?command=ratings" class="btn btn-outline-dark">View Ratings</a>
    </div>
  </div>
</body>

</html>