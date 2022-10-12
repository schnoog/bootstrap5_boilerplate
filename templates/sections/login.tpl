
<div class="wrapper">
        <div class="text-center mt-4 name">
            {t}Login{/t}
        </div>
        <form class="p-3 mt-3" method="post">
        {$runtime.csrf_token_control}
        <p>{t}Username{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="{t}Username{/t}">
            </div>
        <p>{t}Password{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="{t}Password{/t}">
            </div>
        <p>{t}Remember me{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="checkbox" name="setcookie" id="setcookie">
            </div>

            <button class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
            <a href="/pwreset">Forget password?</a> or <a href="/register">Sign up</a>
        </div>
    </div>


