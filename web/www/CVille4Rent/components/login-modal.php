 <div id="modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form class="row g-3 needs-validation" novalidate>
            <!-- email address input -->
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="email" placeholder="name@example.com">
              <label for="email">Email address</label>
              <!-- validation to be added later -->
              <div class="invalid-feedback">
                No user associated with this email address
              </div>
            </div>

            <!-- password input -->
            <div class="form-floating">
              <input type="password" class="form-control" id="password" placeholder="Password">
              <label for="password">Password</label>
              <!-- validation to be added later -->
              <div class="invalid-feedback">
                Incorrect Password
              </div>
            </div>

            <!-- login button - will submit form and authenticate user -->         
            <button
              class="btn btn-primary" 
              type='submit'
              onclick="console.log('login');"
            >
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>