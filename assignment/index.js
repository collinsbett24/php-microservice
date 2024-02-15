//method to test the get API
function testGetMethod() {
    $('#loadingImage').show();
    //get values from form
    let format = $("input[name='format']:checked").val();
    let from = $('#from').val();
    let to = $('#to').val();
    let amnt = $('#amnt').val();

    if (from && to) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            const xmlDocument = this.responseText;

            if (xmlDocument) {
                $('#loadingImage').hide();
                //display the data to the HTML text area
                const rawXml = this.responseText;
                document.getElementById("response").innerHTML = rawXml;
            } else {
                $('#loadingImage').hide();
                alert('Invalid XML response.');
            }
        };

        // Encode the symbol value before appending it to the URL
        const encodedFormat = encodeURIComponent(format);
        const encodedFrom = encodeURIComponent(from);
        const encodedTo = encodeURIComponent(to);
        const encodedAmnt = encodeURIComponent(amnt);
        const url = "./?from=" + encodedFrom + "&to=" + encodedTo + "&amnt=" + encodedAmnt + "&format=" + encodedFormat;
        //initiate the request
        xhttp.open('GET', url);
        xhttp.send();
    } else {
        alert('Please select both action and currency.');
    }

}

//method to test put, post and delete
function submitForm() {
    $('#loadingImage').show();
    //get values from input fields
    let requestMethod = $("input[name='action']:checked").val();
    let symbol = $('#cur').val();
    let action = requestMethod.toLowerCase();

    if (requestMethod && symbol) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            // Use responseXML instead of responseText
            const xmlDocument = this.responseText;
            if (xmlDocument) {
                $('#loadingImage').hide();
                //display the data to the HTML text area
                const rawXml = this.responseText;

                const formattedXml = formatXml(rawXml);
                document.getElementById("response").innerHTML = formattedXml;
            } else {
                $('#loadingImage').hide();
                alert('Invalid XML response.');
            }
        };

        // Encode the symbol value before appending it to the URL
        const encodedSymbol = encodeURIComponent(symbol);
        const url = "update/?cur=" + encodedSymbol + "&action=" + action;
        //initiate the request to the php files
        xhttp.open(`${requestMethod}`, url);
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