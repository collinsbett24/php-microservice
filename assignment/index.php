<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Conversion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">

</head>

<body>
    <div class="container">
        <div class="update-button">
            <a href="update.php">Test Update Methods</a>
        </div>
        <form class="form">
            <div class="form-header">
                <span>Form Interface for GET</span>
            </div>
            <div class="select-currency">
                <label for="from">From :</label>
                <?php
                require_once('classes.php');
                $filter = new Filter('','','');
                    $currencies = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];
                    echo '<select name="from" id="from" required>';
                    echo '<option value="">Select Currency</option>';
                    foreach ($currencies as $currency) {
                        echo '<option value="' . $currency . '">' . $currency . '</option>';
                    }
                    echo '</select>';
                ?>
            </div>
            <div class="select-currency">
                <label for="to">To :</label>
                <?php
                require_once('classes.php');
                $filter = new Filter('','','');
                    $currencies = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];
                    echo '<select name="to" id="to" required>';
                    echo '<option value="">Select Currency</option>';
                    foreach ($currencies as $currency) {
                        echo '<option value="' . $currency . '">' . $currency . '</option>';
                    }
                    echo '</select>';
                ?>
            </div>
            <div class="amount-div">
                <label for="amont">Amount :</label>
                <input type="number" name="amnt" id="amnt" require>
            </div>
            <div class="form-radio-button">
                <label for="format" id="format">Format :</label>
                <div class="form-radio-button-formats">
                    <label>XML</label>
                    <input type="radio" name="format" id="xml" value="xml" >

                    <label>JSON</label>
                    <input type="radio" name="format" id="json" value="json" >

                    <label>WRONG</label>
                    <input type="radio" name="format" id="wrong" value="wrong">
                </div>
            </div>
        </form>
        <div class="submit-button">
                <input id="button" type="submit" onclick="testGetMethod()" value="Submit">
            </div>
        <div class="response-area">
            <label for="response">Response XML</label>
            <!-- <span id="response"></span> -->
            <textarea name="response" id="response" cols="35" rows="5" placeholder="Response"></textarea>
        </div>
    </div>
</body>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="index.js"></script>

</html>