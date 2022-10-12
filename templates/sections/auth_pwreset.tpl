
    <div class="wrapper">
        <div class="text-center mt-4 name">
            {t}Account activation{/t}
        </div>
        <form class="p-3 mt-3" method="post">
        {$runtime.csrf_token_control}
            <p>{t}Username{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="{t}Username{/t}">
            </div>
            <p>{t}Authentification key{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="text" name="authkey" id="pwd" placeholder="{t}Authentification key{/t}">
            </div>
            
            <p>{t}Password{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password1" id="pwd1" placeholder="{t}Password{/t}">
            </div>
            <p>{t}Please repeat the password{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password2" id="pwd2" placeholder="{t}Please repeat the password{/t}">
            </div>
                <input type="hidden" name="action" id="action" value="pwreset">
            <button class="btn mt-3">Aktivate your account</button>
        </form>

    </div>


