# Eventhandler API :lock:
API used to communicate between application and database. Build for RockStars IT.

The API is reachable via ``URL/api/{endpoint}``. **The returned data is always in JSON format.**

:rotating_light:If an endpoint requires data in the body, this is shown underneath the endpoint:rotating_light:

## Current endpoints:
- ``/events`` **(Get, Post and Put)**


## Events:
The ``events`` endpoind is used to list and create events.

#### :page_facing_up: Checklist
- [x] Create a get method, so the events can be shown.
- [x] Create a create method, so new events can be created.
- [x] Create an update method, so events can be changed.
- [ ] Create a remove method, so events can be removed.

### :book: Get events (get method)
The ``get endpoints`` do not use any body text.
- ``/api/events`` returns all events.
- ``/api/events/[id]`` returns event with specific ``id``.

##### :x: Errors:
- ``[]`` - There are no events to show
- ``404`` - The specific event you're looking for doesn't exist.

##### :heavy_check_mark: On succes:
``200 OK`` - returns a JSON object with all/specific event(s).

<br><br>

### :pencil2: Create events (post method)
The ``post endpoints`` **require** all body data as described.
- ``/api/events`` returns the data added to the DB.
  - ``title`` (**required**, string) - The title.
  - ``description`` (**required**, text) - The description.
  - ``date`` (**required**, timestamp) - The date (and time) of the new event.
  - ``thumbnail`` (**required**, url) - The url of a image used as a thumbnail..
  - ``seats`` (**required**, int) - Total available seats.
  - ``postal_code`` (**required**, string) - Postal code of the location.
  - ``hnum`` (**required**, string) - House number of the location.
  - ``notification`` (**required**, bool) - True if you want to send a mail about the new event.
  
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

<br><br>

### :pencil: Update events (put method)
The ``put endpoints`` do not require anything in the body. Only add the fields you want to change to the body.
- ``/api/events/[id]`` returns the entire (edited) event.
  - ``title`` (<b>optional</b>, string) - The title.
  - ``description`` (<b>optional</b>, text) - The description.
  - ``date`` (<b>optional</b>, timestamp) - The date (and time) of the new event.
  - ``thumbnail`` (<b>optional</b>, url) - The url of a image used as a thumbnail..
  - ``seats`` (<b>optional</b>, int) - Total available seats.
  - ``postal_code`` (<b>optional</b>, string) - Postal code of the location.
  - ``hnum`` (<b>optional</b>, string) - House number of the location.
  - ``notification`` (<b>optional</b>, bool) - True if you want to send a mail about the new event.
  
##### :x: Errors:
- Errors are equal to the ``create endpoint``
- **No error** will be trown when the body is empty

##### :heavy_check_mark: On succes:
``200 OK`` - returns a JSON object with the updated event data.
