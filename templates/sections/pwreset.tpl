
<div class="wrapper">
 <!--       <div class="logo">
            <img src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-bird-symbols-png-logo-0.png" alt="">
        </div>
-->
        <div class="text-center mt-4 name">
            {t}Request passwort reset link{/t}
        </div>
        <form class="p-3 mt-3" method="post">
        {$runtime.csrf_token_control}
        <p>{t}Username{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username2" id="username2" placeholder="{t}Username{/t}">
            </div>
        <p>{t}E-Mail{/t}</p>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="email" name="email2" id="email2" placeholder="{t}E-Mail{/t}">
            </div>


            <button class="btn mt-3">{t}Request passwort reset link{/t}</button>
        </form>

    </div>


