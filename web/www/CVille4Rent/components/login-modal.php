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
            <div class="col-md-4">
              <label for="email-address" class="form-label">Email Address</label>
              <input type="text" class="form-control" id="email-address" required>
              <!-- validation to be added later -->
              <div class="invalid-feedback">
                No user associated with this email address
              </div>
            </div>

            <!-- password input -->
            <div class="col-md-4">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control" id="password" required>
              <!-- validation to be added later -->
              <div class="invalid-feedback">
                Incorrect Password
              </div>
            </div> 
          </form>
        </div>

        <div class="modal-footer">
          <!-- login button - will submit form and authenticate user -->         
          <button
            class="btn btn-primary" 
            type='submit'
            onclick="console.log('login');"
          >
            Login
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>