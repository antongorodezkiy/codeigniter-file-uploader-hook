<?php

// ...

$hook['pre_controller'][] = array(
    'class'    => 'Fileuploader_hook',
    'function' => 'fillGlobalFiles',
    'filename' => 'fileuploader_hook.php',
    'filepath' => 'hooks',
    'params'   => array('name' => 'qqfile')
);

// ...