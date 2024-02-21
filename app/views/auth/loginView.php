<a href="javascript:history.back()">
    <div class="backIcon">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</a>
<section id="formContainer">
    <h1 class="formTitle">Log in</h1>
    <div class="formCard">
        <form method="POST" action="/login">
            <input type="email" name="email" id="loginEmail" placeholder="Email" />
            <input type="password" name="password" id="loginPassword" placeholder="Password" />
            <div class="formButtons">
                <a href="/register" class="registerLink">Register</a>
                <button type="submit" name="submit" class="loginButton">Login</button>
            </div>
        </form>
    </div>
</section>