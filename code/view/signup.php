<div id="div-form">
    <h2>Signup to Fintech</h2><br>
    <form action="" class="">
        <div class="container">
            <i class="fa fa-user fa-lg" id="icon-name"></i>
            <input type="text" placeholder="Name" class="input-name" required><br>
            <i class="fa fa-envelope fa-lg" id="icon-email"></i>
            <input type="text" placeholder="Email" class="input-email" required><br>
            <i class="fa fa-lock fa-2x" id="icon-pass"></i>
            <input type="password" placeholder="Password" id="input-pass" onrequired>
            <i class="fa fa-eye fa-lg" id="icon-eye"></i>
        </div>
        <div class="clearfix">
            <button type="button" class="loginBtn">Signup</button>
        </div>
        <p>Already have an account? <a href="">Login here</a> </p>
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