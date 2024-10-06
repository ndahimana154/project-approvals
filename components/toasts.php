<!-- Toast Notification for Register -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11; margin-top: 20px;">
    <div id="registerToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Registration</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php if ($registerError): ?>
                <div class="text-danger"><?php echo $registerError; ?></div>
            <?php elseif ($registerSuccess): ?>
                <div class="text-success"><?php echo $registerSuccess; ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Toast Notification for Login -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11; margin-top: 20px;">
    <div id="loginToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Login</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-danger">
            <?php echo $loginError; ?>
        </div>
    </div>
</div>