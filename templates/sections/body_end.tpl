
    </main>
    <footer class="pt-5 my-5 text-muted border-top">
        Created by the Bootstrap team &middot; &copy; 2022
    </footer>
    </div>

    {if count($runtime.debug)> 0}
      <div class="alert alert-light" role="alert">
      <ul>
      {foreach $runtime.debug as $debug}<li>{$debug}</li>{/foreach}
      </ul>
      </div>
    {/if}

        {foreach $runtime.js_to_include as $js_to_include}
            <script src="{$runtime.BaseUrl}js/{$js_to_include}"></script>
        {/foreach}

      
  </body>

