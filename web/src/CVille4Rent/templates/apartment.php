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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
    integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="controller.js"></script>
</head>

<body>
  <!-- <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?> -->
  <?php include '/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/components/navbar.php'; ?>


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
    <!-- favorite form -->
    <?php if (isset($_SESSION['user'])): ?>
      <form id="favorite-form" onsubmit="favoriteApartment(event)">
        <button type="submit" id="favorite-btn" class="btn btn-light">
          <?= $isApartmentFavorited ? "Un-Favorite Apartment" : 'Favorite Apartment'; ?>
          <i id="heart-icon" class="bi <?= $isApartmentFavorited ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
        </button>
        <input type="hidden" name="apartment_name" value="<?= $apartment['name'] ?>">
        <input type="hidden" name="action" value="<?= $isApartmentFavorited ?>">
      </form>
    <?php endif; ?>


    <!-- apartment info -->
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

    <!-- apartment ratings -->
    <section>
      <h2>Ratings</h2>
      <div id="carousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php foreach ($ratings as $index => $rating): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"">
              <h4>
                <?= $rating['title'] ?>
              </h4>
              <ul class=" list-group list-group-flush">
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
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
      </div>

      <!-- submit a rating -->
      <?php if (isset($_SESSION['user'])): ?>
        <div id="rating-alert" class="alert alert-danger" role="alert" style="display: none">
          Unable to Submit Rating
        </div>

        <form id="ratings-form" onsubmit="submitRating(event)">
          <div class="mb-3">
            <label for="title" class="form-label">Rating Title</label>
            <input type="text" name="title" placeholder="<?= $apartment["name"] ?> Rating" class="form-control me-2" />
          </div>

          <div class="mb-3">
            <label for="rent" class="form-label">Rent Paid</label>
            <input type="number" name="rent" class="form-control" />
          </div>

          <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="range" name="rating" class="form-range" id="rating-range" min="0" max="5">
          </div>


          <div class="mb-3">
            <textarea class="form-control" name="comment" placeholder="Comment"></textarea>
          </div>

          <input type="hidden" name="apartment-name" value="<?= $apartment["name"] ?>" />
          <input type="hidden" name="user" value="<?= $_SESSION["user"] ?>" />

          <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
      <?php endif; ?>
    </section>



  </div>
</body>

</html>