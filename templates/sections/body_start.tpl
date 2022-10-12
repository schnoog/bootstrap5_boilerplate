
  <body>
    {include file="sections/navbar.tpl" }
    <div class="col-lg-8 mx-auto p-4 py-md-5">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">

    </header>

    <main class="container">
    {if count($runtime.error) >0}
      <div class="alert alert-danger" role="alert">
      <ul>
      {foreach $runtime.error as $error}<li>{$error}</li>{/foreach}
      </ul>
      </div>
    {/if}
    {if count($runtime.success) >0}
      <div class="alert alert-success" role="alert">
      <ul>
      {foreach $runtime.success as $success}<li>{$success}</li>{/foreach}
      </ul>
      </div>
    {/if}
    {if count($runtime.message)> 0}
      <div class="alert alert-light" role="alert">
      <ul>
      {foreach $runtime.message as $message}<li>{$message}</li>{/foreach}
      </ul>
      </div>
    {/if}




