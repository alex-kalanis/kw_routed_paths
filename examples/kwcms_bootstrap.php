<?php

//// Example bootstrap code for KWCMS

// where is the system?
$systemPaths = new \kalanis\kw_paths\Path();
$systemPaths->setDocumentRoot(realpath($_SERVER['DOCUMENT_ROOT']));
$systemPaths->setPathToSystemRoot('/..');
\kalanis\kw_paths\Stored::init($systemPaths);

// load virtual parts - if exists
$routedPaths = new \kalanis\kw_routed_paths\RoutedPath(new \kalanis\kw_routed_paths\Sources\Server(
    strval(getenv('VIRTUAL_DIRECTORY') ?: 'web/')
));
\kalanis\kw_routed_paths\StoreRouted::init($routedPaths);

// init config
\kalanis\kw_confs\Config::init(new \kalanis\kw_confs\Loaders\PhpLoader($systemPaths, $routedPaths));
\kalanis\kw_confs\Config::load('Core'); // autoload core config

// init langs - the similar way like configs, but it's necessary to already have loaded params
\kalanis\kw_langs\Lang::init(
    new \kalanis\kw_langs\Loaders\PhpLoader($systemPaths, $routedPaths),
    \kalanis\kw_langs\Support::fillFromPaths(
        $systemPaths,
        \kalanis\kw_confs\Config::get('Core', 'page.default_lang', 'hrk'),
        false
    )
);
\kalanis\kw_langs\Lang::load('Core'); // autoload core lang

// pass parsed params as external source
$source = new \kalanis\kw_input\Sources\Basic();
$source->setCli($argv)->setExternal($routedPaths->getArray()); // argv is for params from cli
$inputs = new \kalanis\kw_input\Inputs();
$inputs->setSource($source)->loadEntries();

// And now we have all necessary variables to build the context
