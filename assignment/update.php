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
        <div class="loading">
            <img id ="loadingImage"  src="loader.gif" alt="loading">
        </div>
        <div class="update-button">
                <a href="index.php">Test Get Method</a>
            </div>
            <form class="form">
                <div class="form-header">
                    <span>Form Interface for POST, PUT & DELETE</span>
                </div>
                <div class="form-radio-button">
                    <label for="action" id="action">Action</label>
                    <div class="form-radio-button-actions">
                        <label>PUT</label>
                        <input type="radio" name="action" id="put" value="PUT" required>

                        <label>POST</label>
                        <input type="radio" name="action" id="post" value="POST" required>

                        <label>DELETE</label>
                        <input type="radio" name="action" id="delete" value="DELETE" required>
                    </div>
                </div>
                <div class="select-currency">
                    <label for="cur">Curr :</label>
                    <?php
                    require_once('classes.php');
                    $filter = new Filter('','','');
                        $currencies = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];
                        echo '<select name="currency" id="cur" required>';
                        echo '<option value="">Select Currency</option>';
                        foreach ($currencies as $currency) {
                            echo '<option value="' . $currency . '">' . $currency . '</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
            </form>
            <div class="submit-button">
                    <input id="button" type="submit" onclick="submitForm()" value="Submit">
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