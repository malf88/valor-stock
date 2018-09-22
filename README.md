# valor-stock
Biblioteca para consulta de valor de ações da bovespa.

Como usar:

include 'vendor/autoload.php';<br />
use StockValor\StockValor; <br />
use StockValor\ManipulaStockExchange;<br />

$stock = new StockValor('TIET11');<br />
//Buscar último valor da ação TIET11 <br />

$tucker = $stock->getLastValor();
