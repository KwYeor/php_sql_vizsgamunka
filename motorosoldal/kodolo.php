<?php

// md5 tesztelés, a HASH nem vált be

$pass = '54321';
echo md5(md5($pass . 'xXxX') . 'xXxX') . '<br>';
