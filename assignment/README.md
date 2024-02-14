
Currency Conversion Project
====================================================================
The Currency Conversion Project is a PHP-based web application that facilitates currency conversion, error handling, and interaction with an external API. This project is designed to provide a flexible and modular solution for developers working on currency-related applications.

# Technologies
- _RAW PHP_ – used to build the backend part of the project.
- _JSON_ – a data format for some responses for errors and success responses. A JSON file has also been used on behalf of a database.
- _XML_ – XML format has been used for most success and error responses.
- _JavaScript_ – to enhance interactivity between the PHP APIs and the HTML view. It holds AJAX functions and render to the Document Object Model(DOM).
- _Fixer API_ – this is the source of 170 world currency exchange rates. We will be working with 25 exchange rates as required in the task.
- _Apache web Server_ – Allows users to call Rest API endpoints and view various content on the web pages.

# Features
----------------
## RESTFULL APIs and Request Methods
The requestMethods class defines methods corresponding to different HTTP request methods:

GET Method: This method retrieves the `from`, `to`, `amnt` and `format` parameters from a GET request, performs validations on them, and returns JSON or XML responses depending on the format specified on the request.

PUT Method: For updating currency data, the PUT method fetches and compares the latest currency rates against the earlier fetched rates, providing a detailed XML response.

POST Method: The POST method retrieves the currency data for a specific currency from the db json and returns the response in XML format.

DELETE Method: Deletes currency data for a specified currency is handled by the DELETE method, returning a required XML response.
## User Interface
The user interface is made up of two pages. One for testing the GET API and the the other for testing the other APIs.
The pages are well designed on `index.php` and `update.php` pages respectively. The pages utilize ajax and a JavaScript to initiate request and display responses on a text area.

# Usage
## To integrate this Currency Conversion Project into your application:
1. Install APACHE server to you machine.
2. Move the file to the root directory where the apache server can be able to display the webpages.
3. Run the commands below to load the projects settings as structured on .htaccess file.
- `sudo a2enmod rewrite`
- `sudo systemctl restart apache2`
- `sudo systemctl reload apache2`
 
4. Ensure the required dependencies, including the Fixer API, is included.
5. Instantiate the Currency class(fetch-currency.php) and provide the access token from the fixer API website to allow successfull fetching and processing of the currency data.
6. Depending on the required API, Utilize the requestMethods class to handle the get, put, post and delete HTTP request methods.
7. On the browser, enter the URL: https://localhost/atwd1/assignment/index.php. This will give you a User interface from which you can test various scenarios or request methods.

# Dependencies
This project has dependencies on some additional imports: Google Fonts to be used with styles,Prism to enhance the looks of XML responses, ajax from google APIs to initiate and render requests and responses, and the Fixer API to fetch information on over 150 currency rates.

# Problems and Challenges
- The Fixer API  limited (100) API calls on the free package.
- PHP endpoints work with the file extension indicated on the API endpoint while the requred endpoints defers slightly with the .php extension not included. 
- Lack of some of the required data from the Fixer API endpoint including the country and the location in which the currencies are used.

# Solution
- Limiting number of API calls and creating a new account.
- Including a .htaccess file on the root directory folder of the project to allow defining custom endpoints.
- Displaying the currency code instead of the location.

# Learning Outcomes

**XMLHttpRequest and XML Processing**
The project provided hands-on experience with the XMLHttpRequest object and processing XML responses. Understanding the importance of using responseXML instead of responseText for XML data manipulation was a key takeaway.

**User Interface Enhancement**
The project highlighted the significance of not only formatting data for readability but also considering the visual aspect for a better user experience. Applying appropriate styles to different XML components improves the user's ability to interpret the information.

**Problem-Solving Skills**
Encountering issues such as the lack of a formatXml implementation required problem-solving skills. Finding or creating a solution to this issue contributes to a better understanding of troubleshooting and debugging in JavaScript.

# License
The Currency Conversion Project is licensed under the MIT License. This open-source license ensures flexibility and encourages collaboration.nclude a .htaccess file on the root directory folder of our project