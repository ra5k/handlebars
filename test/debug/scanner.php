<?php

/* 
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 GitHub/ra5k
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../bootstrap.php';

use Ra5k\Handlebars\Parser;

// -------------
$hbs = <<<'EOF'
    abc{{ N.[12].X ('quoted text') a = "blah" }}def{{{ht.ml}}}ghi{{}}jkl'mno {{!-- Hello --}} EOF
EOF;
// ------------

$flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
$head = new Parser\Csr\TkStart($hbs, 0);
$start = $head->next();

for ($token = $start; $token->isValid(); $token = $token->next()) {
    echo json_encode($token->dump(), $flags), PHP_EOL;
}
