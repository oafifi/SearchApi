Tajawal Hotel Search API
----------

## Usage

 - Clone the repo using: **git clone** https://github.com/oafifi/SearchApi.git
 - cd to the project directory and run **composer install**
 - Run the integrated dev server using: **php bin/console server:run**
 - To test the end point use the url: http://127.0.0.1:8000/api/search/hotels
 - To run unit tests use: **php bin/phpunit**

## Request Parameters

 - *name* search by name http://127.0.0.1:8000/api/search/hotels?name=Hilton
 - *city* search by city name http://127.0.0.1:8000/api/search/hotels?city=london
 - *price_from* and price_to search by price range http://127.0.0.1:8000/api/search/hotels?price_from=10.5&price_to=15.6
 - *date_from* and *date_to* search by availability date range http://127.0.0.1:8000/api/search/hotels?date_from=10-11-2018&date_to=13-11-2018
 - *sort_by* sort results by either name or price http://127.0.0.1:8000/api/search/hotels?sort_by=name

## Example Requests

**Search by City**
http://127.0.0.1:8000/api/search/hotels?city=london
*Response*

    [
        {
            "name": "Le Meridien",
            "price": 89.6,
            "city": "london",
            "availability": \[
             {
                "from": "01-10-2020",
                "to": "12-10-2020"
             },
             {
                "from": "05-10-2020",
                "to": "10-11-2020"
             },
             {
                "from": "05-12-2020",
                "to": "28-12-2020"
         }
    ]

**Invalid sort_by parameter**
http://127.0.0.1:8000/api/search/hotels?sort_by=invalid_sort_by
*Response*

    {
      "status_code": 400,
      "type": "validation_error",
      "title": "There is a validation error",
      "errors": {
        "sort_by": [
          "This value is not valid."
        ]
      }
    }
