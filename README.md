# valor-stock
Biblioteca para consulta de valor de ações da bovespa.

Como usar:

include 'vendor/autoload.php';
use StockValor\StockValor;
use StockValor\ManipulaStockExchange;

$stock = new StockValor('TIET11');
//Buscar último valor da ação TIET11

$tucker = $stock->getLastValor();
