# Eventhandler API :lock:
API used to communicate between application and database. Build for RockStars IT.

The API is reachable via ``URL/api/{endpoint}``. <b>The returned data is always in JSON format.</b><br>

:rotating_light:If an endpoint requires data in the body, this is shown underneath the endpoint:rotating_light:

## Current endpoints:
- ``/events`` <b>(Get and Post)</b>


## Events:
The ``events`` endpoind is used to list and create events.

#### :page_facing_up: Checklist
- [x] Create a get method, so the events can be shown.
- [x] Create a create method, so new events can be created.
- [ ] Create an update method, so events can be changed.
- [ ] Create a remove method, so events can be removed.

### :book: Get events (get method)
- ``/api/events`` returns all events.
- ``/api/events/[id]`` returns event with specific ``id``.

##### :x: Errors:
- ``[]`` - There are no events to show
- ``404`` - The specific event you're looking for doesn't exist.

##### :heavy_check_mark: On succes:
``200 OK`` - returns a JSON object with all/specific event(s).

### :pencil2: Create events (post method)
- ``/api/events`` returns the data added to the DB.
  - ``title`` (string) - The title.
  - ``description`` (text) - The description.
  - ``date`` (timestamp) - The date (and time) of the new event.
  - ``thumbnail`` (url) - The url of a image used as a thumbnail..
  - ``seats`` (int) - Total available seats.
  - ``postal_code`` (string) - Postal code of the location.
  - ``hnum`` (string) - House number of the location.
  - ``notification`` (bool) - True if you want to send a mail about the new event.
  
##### :x: Errors:
- Error is only trown when body data is incorrect. Errors are in english like the example below.
```
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title has already been taken."
        ],
        "thumbnail": [
            "The thumbnail is not a valid URL."
        ],
        "postal_code": [
            "This postal code is not recognized. Insert something like: 1234 AB, 4000, 26133 "
        ]
    }
}
```

##### :heavy_check_mark: On succes:
``201 Created`` - returns a JSON object with the created event data.
