<!-- Bootstrap navbar with links to login/profile -->
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
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <?php include '/opt/src/CVille4Rent/components/login-modal.php'; ?>
</nav>