<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="author" content="Bella Felaco" />
    <meta name="description" content="Charlottesville Renter's Application" />
    <meta
      name="keywords"
      content="UVA Charlottesville Rent Renter Renting Apartment Apartments"
    />

    <!-- title -->
    <title>CVille 4 Rent: Home</title>

    <!-- styles -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>

    <link rel="stylesheet/less" type="text/css" href="styles/main.less" />
    <script src="https://cdn.jsdelivr.net/npm/less"></script>

  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
    <?php include 'data/getApartments.php'; ?>

    <h1>CVille 4 Rent</h1>
    <div class="container">
      <!-- instructions and search bar -->
      <span>
        <i>Click an apartment to view more information or Search by name</i>
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">
            Search
          </span>
          <input
            type="text"
            class="form-control"
            aria-label="Sizing example input"
            aria-describedby="inputGroup-sizing-default"
          />
        </div>
      </span>

      <!-- listing of apartments -->
      <div class="list-group" aria-label="apartments">
        <?php
          $jsonString = file_get_contents('data/apartments.json');
          $apartments = json_decode($jsonString, true);
          echo generateApartmentList($apartments);
        ?>
      </div>

      <!-- will navigate to paginated results of apartments -->
      <nav aria-label="pagination">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="">1</a></li>
          <li class="page-item"><a class="page-link" href="">2</a></li>
          <li class="page-item"><a class="page-link" href="">3</a></li>
          <li class="page-item"><a class="page-link" href="">Next</a></li>
        </ul>
      </nav>
    </div>
  </body>
</html>
