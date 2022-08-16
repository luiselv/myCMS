<?php

declare(strict_types=1);

//use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->skip([
        __DIR__ . '/_css',
        __DIR__ . '/_img',
        __DIR__ . '/_js',
        __DIR__ . '/_swf',
        __DIR__ . '/cache',
        __DIR__ . '/*/cache/*',
    ]);

    $rectorConfig->paths([
        __DIR__ . '/control/*.php',
        __DIR__ . '/control/_include',
        __DIR__ . '/control/data',
        __DIR__ . '/control/layout'
    ]);

    // register a single rule
    //$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_73,
        SetList::PHP_73,
        SetList::MYSQL_TO_MYSQLI,
        SetList::TYPE_DECLARATION_STRICT
    ]);

    $rectorConfig->disableParallel();
};
