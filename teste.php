<?php

require_once DIR . 'Classes/Product.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Factorys/Exporter/ExporterFactoryProvider.php';

$pessoas[] = new Person(1, '1', 'M');
$pessoas[] = new Person(2, '2', 'F');
$pessoas[] = new Person(3, '3', 'M');
$pessoas[] = new Person(4, '4', 'O');

$produtos[] = new Product(55, 'caneca');
$produtos[] = new Product(55, 'computador');
$produtos[] = new Product(55, 'Garrafa');


$factory = new ExporterFactoryProvider();
$exportadorFactory = $factory->create('Json');

//Exportar pessoas
$exportatorDePessoas = $exportadorFactory->createExporterPerson();

$conteudo = $exportatorDePessoas->serializeObj($pessoas);

echo '<br>Pessoas exportadas <br>';
echo nl2br($conteudo);

//Exportar produtos
$exportadorDeProdutos = $exportadorFactory->createExporterProduct();

$conteudoDeProdutos = $exportadorDeProdutos->serializeObj($produtos);
echo '<br>Produtos exportadas <br>';
echo nl2br($conteudoDeProdutos);