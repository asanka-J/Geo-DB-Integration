### API Integration with GeoDB Cities API

This solution query information from the GeoDB Cities API.

### Project Overview
The API integration enables users to perform the following queries:
- Retrieve country details including country code, currency, and flag image.
- Fetch details of the capital city including region, elevation, latitude, longitude, and population.
- Obtain information about places near a specific city using the city's ID.

### How to Test the Integration
1. Clone the repository to your local machine.
2. Duplicate the .env_sample, generate and replace api key for GEODB_API_KEY
2. Navigate to the project directory.
3. Set up the project dependencies using - `composer install`
4. Use the provided API routes to query country and city information.

### API Routes
- **GET /countries:** Retrieve a list of all countries.
- **GET /country:** Retrieve details of a specific country.
- **GET /cities:** Retrieve a list of cities by country.
- **GET /city:** Retrieve details of a specific city by its ID.
- **GET /city/nearby:** Retrieve nearby places of a specific city.
- **GET /country/search:** Search for a country and retrieve its information.
- 
These API's can be used to improve and implement more features

### Postman Collection
I have added a Postman collection file named `GEODB.postman_collection.json` to the project root. It provides API requests used to connect to the GeoDB API.

Additionally, I've included an API documentation file named `API.postman_collection.json`, which provides detailed documentation for the project's APIs.

### Testing the UI
To test the user interface:
1. Navigate to the `/` location from your browser.
2. Select a country from the dropdown menu.
3. Submit the form.
4. View the displayed country, capital, and nearby cities' details.
