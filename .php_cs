<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        '@Symfony:risky' => true,
//        'declare_strict_types' => true,
        'dir_constant' => true,
        'ereg_to_preg' => true,
        'mb_str_functions' => true,
        'modernize_types_casting' => true,
        'no_php4_constructor' => true,
        'php_unit_strict' => true,
        'psr4' => true,
//        'simplified_null_return' => true,
        'strict_comparison' => true,
        'strict_param' => true,
    ))
;
