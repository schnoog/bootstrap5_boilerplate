
{if !$runtime.parse_only_content}
  {include file='sections/doc_start.tpl'}
  {include file='sections/head_start.tpl'}
  {include file='sections/head_end.tpl'}
  {include file='sections/body_start.tpl'}
{/if}
    

{include file=$template}


{if !$runtime.parse_only_content}
  {include file='sections/body_end.tpl'}
  {include file='sections/doc_end.tpl'}
{/if}