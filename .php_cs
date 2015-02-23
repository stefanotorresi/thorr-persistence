<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->append([
        __DIR__ . '/Module.php'
    ])
;

$config = Symfony\CS\Config\Config::create()
    ->finder($finder)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-phpdoc_short_description',
        '-single_array_no_trailing_comma',
        '-concat_without_spaces',
        '-no_empty_lines_after_phpdocs',
        'concat_with_spaces',
        'align_equals',
        'align_double_arrow',
        'ordered_use',
        'short_array_syntax',
    ])
;

return $config;
