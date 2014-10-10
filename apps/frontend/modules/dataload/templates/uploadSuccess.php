<?php

/**
 * Created by PhpStorm.
 * User: webtech
 * Date: 10/8/14
 * Time: 2:17 PM
 */
?>
<?php if($result)
{
    echo html_entity_decode($result);
}else{ ?>
<h2>
There is an error in the CSV file .
</h2>
<?php }?>
