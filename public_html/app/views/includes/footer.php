<!--<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table-striped ">
                    <thead>
                        <tr>
                            <th scope="col">element</th>
                            <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><php echo 'name'; ?><td><php echo 'value'; ?></td>
                        </tr>
                        <tr>
                            <td><php echo 'name'; ?><td><php echo 'value'; ?></td>
                        </tr>     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>-->


<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div style="min-height:500px"></div>
            </div>
        </div>
    </div>
</section>
<footer class="footer-bs material-lightgrey">

    <div class="row">
        <div class="col-md-12">
            <table id="sess_stats" class="table table-sm table-striped d-none d-lg-block" style="font-size:9px">

            </table>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3 footer-brand animated fadeInLeft">
            <h2>Garry Macphee</h2>
            <p>Software Developer.</p>
            <p><?php echo '© ' . date('Y') . ' All rights reserved'; ?></p>
        </div>
        <div class="col-md-4 footer-nav animated fadeInUp">
            <div class="row">
                <div class="col-md-6">
                    <h4>Menu</h4>
                    <ul class="list">
                        <li><a href="<?php echo URLROOT ?>/pages/about"">About Us</a></li>
                        <li><a href="#">Contacts</a></li>
                        <li><a href="#">Terms & Condition</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <!-- <ul class="pages">
                       <li><a href="#">Home</a></li>
                       <li><a href="#">Dashboard</a></li>
                       <li><a href="#">Uploads</a></li>
                       <li><a href="#">Chats</a></li>
                       <li><a href="#">Posts</a></li>
                   </ul>-->
                </div>
            </div>
        </div>
        <div class="col-md-2 footer-social animated fadeInDown">
            <h4>Follow Us</h4>
            <ul>
                <li><a href="https://github.com/GarryMacphee">Github</a></li>
                <li><a href="https://www.linkedin.com/in/garrymacphee/">LinkedIn</a></li>
            </ul>
        </div>
        <div class="col-md-3 footer-ns animated fadeInRight">
            <h4>Looking for something in particular?</h4>
            <p>search for content.</p>

            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span
                                class="glyphicon glyphicon-envelope"></span></button>
                </span>
            </div>
        </div>
    </div>
</footer>

<div id="modal-main" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Main Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php

$captchaArray = ['login', 'users/register/index.php'];
$query_string = explode('=', basename($_SERVER['QUERY_STRING']));
$name = strtolower(end($query_string));
$current_page = $name;

if (!isset($_SESSION['user_id'])) :
    echo '<script src="https://www.google.com/recaptcha/api.js?h1=en" async defer></script>';
endif;
if (in_array($current_page, $captchaArray)) :
    echo '<script src="https://www.google.com/recaptcha/api.js?h1=en" async defer></script>';
endif;
if ($current_page == 'dashboards') :

    echo '<script src="<?php echo URLROOTS; ?>assets/js/global.js"></script>';
    echo '<script src="<?php echo URLROOTS; ?>assets/js/uploads.js"></script>';
    echo '<script src="<?php echo URLROOTS; ?>assets/js/dashboard.js"></script>';
    echo '<script src="<?php echo URLROOTS; ?>assets/js/images_js.js"></script>';

endif;
?>

<script src="<?php echo URLROOTS; ?>assets/js/main.js"></script>

<script src="<?php echo URLROOTS; ?>assets/js/cookie.js"></script>
</body>
</html>