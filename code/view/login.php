<div id="div-form">
    <h2>Login to Fintech</h2><br>
    <form action="" class="">
        <div class="container">
            <div class="input-inner">
                <input type="text" placeholder="Email" class="input-email" required><br>
                <i class="fa fa-envelope fa-lg" id="icon-email"></i>
            </div>
            <div class="input-inner">
                <input type="password" placeholder="Password" id="input-pass" onrequired>
                <i class="fa fa-lock fa-2x" id="icon-pass"></i>
                <i class="fa fa-eye fa-lg" id="icon-eye"></i>
            </div>
        </div>
        <div class="clearfix">
            <input type="button" class="loginBtn" value="Login">
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