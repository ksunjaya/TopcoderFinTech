<?php
if(isset($_GET['status']) && $_GET['status'] == 1)
    echo "
        <div class='error-box'>
            <p>Email has already been taken.</p>
        </div>
        ";
?>

<div id="div-form">
    <h2>Signup to Fintech</h2><br>

    <form action="signup" class="" method="POST">
        <div class="container">
            <div class="input-inner">
                <input type="text" placeholder="Name" class="input-name" name="name" required><br>
                <i class="fa fa-user fa-lg" id="icon-name"></i>
            </div>
            <div class="input-inner">
                <input type="text" placeholder="Email" class="input-email" name="email" required><br>
                <i class="fa fa-envelope fa-lg" id="icon-email"></i>
            </div>
            <div class="input-inner">
                <input type="password" placeholder="Password" id="input-pass" name="password" onrequired>
                <i class="fa fa-lock fa-2x" id="icon-pass"></i>
                <i class="fa fa-eye fa-lg" id="icon-eye"></i>
            </div>
        </div>
        <div class="clearfix">
            <input type="submit" class="customBtn" value="Sign Up">
        </div>
        <p>Already have an account? <a href="login">Login here</a> </p>
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