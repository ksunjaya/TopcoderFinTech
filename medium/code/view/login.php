<?php
if(isset($_GET['status']) && $_GET['status'] == 2)
    echo "
        <div class='error-box'>
            <p>Sorry, we could not find your account.</p>
        </div>
        ";

else if(isset($_GET['status']) && $_GET['status'] == 1)
    echo "
        <div class='ok-box'>
            <p>Registration completed</p>
        </div>
        ";
?>

<div id="div-form">
    <h2>Login to Fintech</h2><br>
    <form class="" method="POST">
        <div class="container">
            <div class="input-inner">
                <input type="text" placeholder="Email" name="email" class="input-email" required><br>
                <i class="fa fa-envelope fa-lg" id="icon-email"></i>
            </div>
            <div class="input-inner">
                <input type="password" placeholder="Password" name="password" id="input-pass" onrequired>
                <i class="fa fa-lock fa-2x" id="icon-pass"></i>
                <i class="fa fa-eye fa-lg" id="icon-eye"></i>
            </div>
        </div>
        <div class="clearfix">
            <input type="submit" class="customBtn" value="Login">
        </div>
        <p>Don't have an account? <a href="signup">Signup here</a> </p>
    </form>
</div>
<script>
    const togglePass = document.querySelector('#icon-eye');
    const password = document.querySelector('#input-pass');
    togglePass.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script> 