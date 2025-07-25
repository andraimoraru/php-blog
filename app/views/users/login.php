<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <?php flash('register_success'); ?>
      <h2 class="text-center">Log Into Your Account</h2>

      <form action="<?php echo URLROOT; ?>/users/login" method="post">
        <!-- Email -->
        <div class="form-group mb-3">
          <label for="email">Email: <sup>*</sup></label>
          <input type="email" name="email" 
                 class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                 value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
          <label for="password">Password: <sup>*</sup></label>
          <input type="password" name="password" 
                 class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                 value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>
        <!-- Buttons -->
        <div class="row">
          <div class="col d-grid mb-2">
            <input type="submit" value="Login" class="btn btn-success btn-block">
          </div>
          <div class="col d-grid">
            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">
              No account? Register
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>