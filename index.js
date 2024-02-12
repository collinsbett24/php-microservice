function submitForm() {
    let requestMethod = $("input[name='action']:checked").val();
    let symbol = $('#cur').val();

    if (requestMethod && symbol) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.getElementById("response").innerHTML = this.responseText;
        };
        // Encode the symbol value before appending it to the URL
        const encodedSymbol = encodeURIComponent(symbol);
        const url = "assignment.php?symbol=" + encodedSymbol;

        xhttp.open(requestMethod, url);
        xhttp.send();
    } else {
        alert('Please select both action and currency.');
    }
}
