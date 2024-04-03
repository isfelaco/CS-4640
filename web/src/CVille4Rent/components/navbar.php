<!-- Bootstrap navbar with links to login/profile -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
  <nav class="navbar navbar-expand-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="./">CVille 4 Rent</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- navbar links -->
      <div class="collapse navbar-collapse">
        <div class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if (empty($_SESSION["user"])): ?>
            <button class="nav-link" data-bs-toggle="modal" data-bs-target="#modal">Login
            </button>
          <?php else: ?>
            <a class="nav-link" href="?command=profile">
              Profile
            </a>
            <a class="nav-link" href="?command=logout">
              Logout
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- login modal -->
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
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                  required>
                <label for="email">Email address</label>
                <div class="invalid-feedback">
                  Please enter a valid email address
                </div>
              </div>

              <!-- password input -->
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                  required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <label for="password">Password</label>
                <div class="invalid-feedback">
                  Please enter a password
                </div>
                <div class="invalid-feedback">
                  <b>Password requirements if creating a new account:</b>
                  <ul>
                    <li>At least one digit</li>
                    <li>At least one lowercase letter</li>
                    <li>At least one uppercase letter</li>
                    <li>At least 8 characters long</li>
                  </ul>

                </div>
              </div>

              <!-- login button - will submit form and authenticate user -->
              <button id="login-button" class="btn btn-primary" type="submit">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script>
    (function () {
      'use strict'
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation');

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        });
    })()
  </script>
</body>

</html>