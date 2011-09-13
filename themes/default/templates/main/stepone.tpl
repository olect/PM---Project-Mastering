{extends file='index.tpl'}
{block name=body}

<div id="form">
    {$form}
</div>
<p>{$message}</p>
<a href="{$link}" title="{$title}">{$title}</a>
    
{/block}