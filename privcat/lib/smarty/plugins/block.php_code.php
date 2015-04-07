<?php 
function smarty_block_php_code($params, $content, &$smarty)
{
    if (is_null($content))
    {
        return;
    }
    if ('<?php' == substr($content,0,5) && '?>' == substr($content, -2))
        $content = substr($content,5,-2);
    ob_start();
    eval($content);
    return ob_get_clean();
}
?>