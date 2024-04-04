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
  <title>CVille 4 Rent: Apartment</title>

  <!-- styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet/less" type="text/css" href="main.less" />
  <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>

<body>
  <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?>

  <?php
  if (isset($_SESSION['user'])) {
    $isApartmentFavorited = false;
    $favoritedApartments = $this->db->getFavoritedApartments($_SESSION['user']);
    foreach ($favoritedApartments as $favApartment) {
      if ($favApartment['name'] == $apartment['name']) {
        $isApartmentFavorited = true;
        break;
      }
    }
  }
  ?>
  <h1>
    <?= $apartment['name']; ?>
  </h1>

  <div class="base-container">
    <form id="favorite-form" method="post" action="?command=favorite">
      <?php if (isset($_SESSION['user'])): ?>
        <button type="submit" id="heart-icon" class="btn btn-light">
          <?= $isApartmentFavorited ? "Un-Favorite Apartment" : 'Favorite Apartment'; ?> <i
            class="bi <?= $isApartmentFavorited ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
        </button>
      <?php endif; ?>
      <input type="hidden" name="apartment_name" value="<?= $apartment['name'] ?>">
      <input type="hidden" name="favorite" value="<?= $isApartmentFavorited ?>">
    </form>

    <div class="list-group" aria-label="list">
      <div class="list-group-item">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><b>Address:</b>
            <?= $apartment['address'] ?? 'N/A'; ?>
          </li>
          <li class="list-group-item"><b>Rent:</b>
            <?= $apartment['rent'] ?? 'N/A'; ?>
          </li>
          <li class="list-group-item"><b>Bedrooms:</b>
            <?= $apartment['bedrooms'] ?? 'N/A'; ?>
          </li>
          <li class="list-group-item"><b>Bathrooms:</b>
            <?= $apartment['bathrooms'] ?? 'N/A'; ?>
          </li>
          <li class="list-group-item"><b>Description:</b>
            <?= $apartment['description'] ?? 'N/A'; ?>
          </li>
        </ul>
      </div>
    </div>

    <section>
      <h2>Ratings</h2>
      <div class="list-group" aria-label="list">
        <?php foreach ($ratings as $rating): ?>
          <div class="list-group-item">
            <h4>
              <?= $rating['title'] ?>
            </h4>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><b>Apartment Name: </b>
                <?= $rating["apartment_name"] ?>
              </li>
              <li class="list-group-item"><b>Rent Paid: </b>
                <?= $rating["rent_paid"] ?>
              </li>
              <li class="list-group-item"><b>Rating: </b>
                <?= $rating["rating"] ?>
              </li>
              <li class="list-group-item"><b>Comment: </b>
                <?= $rating["comment"] ?>
              </li>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</body>

</html>