
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
            <input type="hidden" name="action" id="action" value="activation">
            <button class="btn mt-3">Aktivate your account</button>
        </form>

    </div>


