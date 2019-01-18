<?php

/* 
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 GitHub/ra5k
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../bootstrap.php';

use Ra5k\Handlebars\{Parser, Script};

// --------------------------------------------------------------------
$hbs = <<<'EOF'
   {{#if AA}}
       <p>{{.}}</p>
   {{else if BB}}
       <p>DEFAULT</p>
   {{/if}}
EOF;

// --------------------------------------------------------------------

//   {{else if BB}}
//       <p>ALT 1</p>

$script = new Script\Memory($hbs);
$parser = new Parser\Csr();        
$model = $parser->model($script);

printf("Length: %d\n", strlen($hbs));
var_dump($hbs);
$flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
echo json_encode($model->root()->dump(), $flags), PHP_EOL;


