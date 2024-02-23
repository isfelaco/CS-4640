<!-- Bootstrap navbar with links to login/profile -->
<nav class="navbar" >
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">CVille 4 Rent</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <!-- hidden={user logged in} -->
          <button
            class="nav-link"
            data-bs-toggle="modal"
            data-bs-target="#modal"
            >Login
          </button>
        </li>
        <li>
          <!-- hidden={no user logged in} -->
          <a
            class="nav-link"
            href="profile.php"
          >
            Profile
          </a>
        </li>
      </ul>
    </div>
  </div>

  <?php include 'components/login-modal.php'; ?>
</nav>
