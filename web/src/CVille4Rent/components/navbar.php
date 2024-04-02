<!-- Bootstrap navbar with links to login/profile -->
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- url: https://cs4640.cs.virginia.edu/isf4rjk/CVille4Rent -->

  <!-- meta tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="author" content="Bella Felaco" />
  <meta name="description" content="Charlottesville Renter's Application" />
  <meta name="keywords" content="UVA Charlottesville Rent Renter Renting Apartment Apartments" />

  <!-- title -->
  <title>CVille 4 Rent: NavBar</title>
</head>

<body>
  <nav class="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="./">CVille 4 Rent</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if (empty($_SESSION["user"])): ?>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="modal" data-bs-target="#modal">Login
              </button>
            </li>
          <?php else: ?>
            <li>
              <a class="nav-link" href="?command=profile">
                Profile
              </a>
            </li>
            <li>
              <a class="nav-link" href="?command=logout">
                Logout
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <div id="modal" class="modal fade" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="login-form" class="row g-3 needs-validation" novalidate action="?command=login" method="POST">
              <!-- email address input -->
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <label for="email">Email address</label>
                <!-- validation to be added later -->
                <div class="invalid-feedback">
                  No user associated with this email address
                </div>
              </div>

              <!-- password input -->
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
                <!-- validation to be added later -->
                <div class="invalid-feedback">
                  Incorrect Password
                </div>
              </div>

              <!-- login button - will submit form and authenticate user -->
              <!-- <button class="btn btn-primary" type="submit">
                Login
              </button> -->
            </form>
          </div>
          <div class="modal-footer">
            <!-- login button - will submit form and authenticate user -->
            <button id="login-button" class="btn btn-primary" type="submit">
              Login
            </button>
          </div>
        </div>
      </div>
    </div>

  </nav>
  <script>
    document.getElementById('login-button').addEventListener('click', function () {
      document.getElementById('login-form').submit();
    });
  </script>
</body>

</html>