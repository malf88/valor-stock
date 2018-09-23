#valor-stock
<h2>Como usar</h2>

<h3>Instalar</h3>
composer require malf88/stock-valor

include 'vendor/autoload.php';
use StockValor\StockValor;


<h3>Pegar última cotação</h3>


$stock = new StockValor('TIET11');

$tucker = $stock->getListValue();

<h3>Pegar lista de cotações de um período</h3>


$dateInicio = new DateTime();

$dateInicio->setDate('2018','09','21');

$dateInicio->setTime('10','00','00');

$dateTermino = new DateTime();

$dateTermino->setDate('2018','09','21');

$dateTermino->setTime('18','00','00');

$stock = new StockValor('TIET11',$dateInicio,$dateTermino);

$tucker = $stock->getListValue();

var_dump($tucker);
