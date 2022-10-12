<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{$runtime['title']}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{$runtime.navbar.mainlink}">Home</a>
        </li>
<!--        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
-->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
              {foreach $runtime.navbar.dropdownitems as $linkname => $linkurl}
              <li><a class="dropdown-item" href="{$linkurl}">{$linkname}</a></li>
              {/foreach}
            </ul>
          </li>

          {if $runtime.UserAuthentification}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">{if $runtime.loggedin}{t}Hello{/t} {$runtime.user.sec_users_name}{else}{t}Login{/t}{/if}</a>
            <ul class="dropdown-menu">
              {foreach $runtime.navbar.userdropdownitems as $linkname => $linkurl}
              <li><a class="dropdown-item" href="{$linkurl}">{$linkname}</a></li>
              {/foreach}
            </ul>
          </li>
          {/if}
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>



    </div>
  </div>
</nav>