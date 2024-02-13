function testGetMethod() {
    let format = $("input[name='format']:checked").val();
    let from = $('#from').val();
    let to = $('#to').val();
    let amnt = $('#amnt').val();

    if (from && to) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            const xmlDocument = this.responseText;

            if (xmlDocument) {
                const rawXml = this.responseText;
                document.getElementById("response").innerHTML = rawXml;
            } else {
                alert('Invalid XML response.');
            }
        };

        // Encode the symbol value before appending it to the URL
        const encodedFormat = encodeURIComponent(format);
        const encodedFrom = encodeURIComponent(from);
        const encodedTo = encodeURIComponent(to);
        const encodedAmnt = encodeURIComponent(amnt);
        const url = "assignment.php?from=" + encodedFrom + "&to=" + encodedTo + "&amnt=" + encodedAmnt + "&format=" + encodedFormat;

        xhttp.open('GET', url);
        xhttp.send();
    } else {
        alert('Please select both action and currency.');
    }

}
function submitForm() {
    let requestMethod = $("input[name='action']:checked").val();
    let symbol = $('#cur').val();

    if (requestMethod && symbol) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            // Use responseXML instead of responseText
            const xmlDocument = this.responseText;

            if (xmlDocument) {
                const rawXml = this.responseText;

                const formattedXml = formatXml(rawXml);
                document.getElementById("response").innerHTML = formattedXml;
            } else {
                alert('Invalid XML response.');
            }
        };

        // Encode the symbol value before appending it to the URL
        const encodedSymbol = encodeURIComponent(symbol);
        const url = "../assignment.php?symbol=" + encodedSymbol;

        xhttp.open(requestMethod, url);
        xhttp.send();
    } else {
        alert('Please select both action and currency.');
    }
}

function formatXml(xmlString) {
    // Create a new DOMParser
    const parser = new DOMParser();

    // Parse the XML string
    const xmlDoc = parser.parseFromString(xmlString, 'application/xml');

    // Create a new XMLSerializer
    const serializer = new XMLSerializer();

    // Serialize the parsed XML document back to a formatted XML string
    const formattedXml = serializer.serializeToString(xmlDoc);

    return formattedXml;
}