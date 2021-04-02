<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="container mx-auto">
     <div class="row">
        <div class="col-md-6 mx-auto">
            <div class ="card card-body bg-light mt-5 login-form" style="margin-bottom: 6rem;">
                <?php flash('register_success'); ?>
                <noscript>
                    Javascript is disabled, Please enable it to continue.
                    </noscript>
                <h2 class="mb-3">Login</h2>
                <p>Enter details to login</p>
                <form id="login_form" action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="text" 
                               name="email" 
                               class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="text" 
                               name="password" 
                               class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <div class="progress progress_login">
							<div id="login_progress_bar" class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
                        <span class="invalid-feedback"><?php echo $data['password_err'] ?></span>
                    </div>
                    <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_PUBLIC_KEY ?>"></div>
                    <br>
                    <?php flash('recaptcha_success'); ?>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">No account? Register here</a>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th scope="col" class="px-3 py-2">element</th>
                            <th scope="col" class="px-3 py-2">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <!-- <td class="px-3 py-2"><?php echo 'login token'; ?><td><?php echo $data['csrf']; ?></td>-->
                        </tr>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php //<?php echo '<form>' . $data['csrf'] . $data['login_auth'] . '</form>';?
//echo 'login token = ' . $data['csrf'];
?>
<?php require APPROOT . '/views/includes/footer.php';
