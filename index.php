<?php
require_once "vendor/autoload.php";

$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c837d1iad3ift3bm32fg');
$client = new Finnhub\Api\DefaultApi(new GuzzleHttp\Client(), $config);

$search = $_GET['search'] ?? '';
$symbols = ["AAPL", "TSLA", "PXD", "MSFT"];
$symbolSearch = $client->quote(strtoupper($search));
$results = [];

foreach ($symbols as $symbol){
    try {
        $results[$symbol] = $client->quote($symbol);
    } catch (\Finnhub\ApiException $e) {
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stocks API</title>
</head>
<style>

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        height: 8%;
        font-size: larger;
        border: 10px #000000;
        background-color:  #FFD600;
    }

    .table1 {
        font-family: arial, sans-serif;
        margin: auto;
        width: 20%;
        height: 8%;
        font-size: larger;
        border: 10px #000000;
        background-color:  #FFD600;
    }

    td, th {
        border: 1px solid #000000;
        text-align: center;
        padding: 8px;
    }

    .button {
        background-color: white;
        color: black;
        border: 2px solid #e7e7e7;
        border-radius: 4px;
        font-size: 16px;
    }
</style>
<body style="background-color:  #FFD600">
<br>
    <form method="get" action="/">
        <table>
            <tr><?php foreach($results as $stock => $value): ?>
            <th><?= $stock . " Price: " . (round($value->getC(), 2)) . " $ <br>";
            if($value->getDp() < 0): ?>
               <span style="color: maroon"><?= "▼" . round($value->getDp(), 2) . "%" . "<br>";?></span>
                <?php
                elseif($value->getDp() > 0): ?>
                <span style="color: #00bd00"><?= "▲" . round($value->getDp(), 2) . "%" . "<br>";?></span>
                <?php endif; ?>
            <?php
                if($value->getD() < 0): ?>
                <span style="color: maroon"><?= ' ' . round($value->getDp(), 2) . "<br>";?></span>
                <?php
                elseif($value->getD() > 0): ?>
                <span style="color: #00bd00"><?= ' ' . round($value->getDp(), 2) . "<br>";?></span>
                <?php endif; ?>
                <?php endforeach; ?>
            </th>
           </tr>
        </table>
    <br>
    </form>
    <form method="get" action="/">
        <label>
            <input class="button" name="search" placeholder="AAPL" value="">
        </label>
        <button class="button" type="submit">Search</button>
        <br><br><br><br>
        <?php $search = strtoupper($search);
        if($search !== ''): ?>
        <table style="display: flex;" class="table1">
            <tr>
                <th><?= $search . " Price: " . (round($symbolSearch->getC(), 2)) . " $ <br>";
                    if($symbolSearch->getDp() < 0): ?>
                        <span style="color: maroon"><?= "▼" . round($symbolSearch->getDp(), 2) . "%" . "<br>";?></span>
                    <?php
                    elseif($symbolSearch->getDp() > 0): ?>
                        <span style="color: #00bd00"><?= "▲" . round($symbolSearch->getDp(), 2) . "%" . "<br>";?></span>
                    <?php endif; ?>
                    <?php
                    if($symbolSearch->getD() < 0): ?>
                        <span style="color: maroon"><?= ' ' . round($symbolSearch->getDp(), 2) . "<br>";?></span>
                    <?php
                    elseif($symbolSearch->getD() > 0): ?>
                        <span style="color: #00bd00"><?= ' ' . round($symbolSearch->getDp(), 2) . "<br>";?></span>
                    <?php endif; ?>
                </th>
                <?php endif; ?>
            </tr>
        </table>
</body>
</html>