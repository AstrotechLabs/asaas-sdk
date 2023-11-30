<?php

declare(strict_types=1);

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->notPath('runtime')
    ->notPath('mail')
    ->notPath('.docker')
    ->notPath('.github')
    ->notPath('.environment')
    ->notPath('.docker')
    ->notPath('.tevun')
    ->notPath('database')
    ->notPath('storage')
    ->notPath('src/@core')
    ->in(__DIR__)
    ->name('*.php');

$config = new PhpCsFixer\Config();

$config
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'psr_autoloading' => true,
        'declare_strict_types' => true,
        'linebreak_after_opening_tag' => true,
        'blank_line_after_opening_tag' => true,
        'no_unused_imports' => true,
        'new_with_braces' => true,
        'type_declaration_spaces' => [
            'elements' => ['function', 'property']
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'blank_line_before_statement' => [
            'statements' => ['declare'],
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'length'
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_functions' => false,
            'import_constants' => false,
        ]
    ]);

return $config;
