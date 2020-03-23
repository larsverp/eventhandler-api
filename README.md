# Eventhandler API :lock:
API used to communicate between application and database. Build for RockStars IT.

The API is reachable via ``URL/api/{endpoint}``. **The returned data is always in JSON format.**

:rotating_light:If an endpoint requires data in the body, this is shown underneath the endpoint:rotating_light:

## Current endpoints:
- `/users/login` **(Only Post)**
- `/events` **(Get, Post and Put)**

## Authentication:
The `/users/login` endpoint is used to check a `username` + `password` and recieve the `access_token` and `refresh_token`.

### :key: Get access_token
Send a `POST request` to the `/users/login` endpoint. This endpoint requires a `username` and `password` in the body. 

**FOR TESTING PURPOSES ONLY:** You can use the following `username` and `password`:
```
{
    "username":"tiana.stroman@example.com",
    "password":"password"
}
```
##### :heavy_check_mark: On succes:
If the `username` and `password` match you will receive a `200 OK` status and receive the following JSON response:

```
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx(This is actual realy long)",
    "refresh_token": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx(This is actual realy long)"
}
```
The `expires_in` is currently set to 1 year. This is too long and will be changed in a future version.

##### :x: No succes:
If the `username` and/or `password` do not match you will receive a `400 Bad request` status and a JSON response similar to this one:

```
{
    "error": "invalid_grant",
    "error_description": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.",
    "hint": "",
    "message": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client."
}
```

### :closed_lock_with_key: How to authenticate a request:
**Every request needs to be authenticated.** (The only exception is the ``/users/login`` endpoint.)

You can authenticate the request via the header in your request. 

The **key** should be `Authorization`.

The **value** should be `Bearer access_token`. 

**Attention: `Bearer` has to be capitalized and a [space] has to be added between the `Bearer` and the `acces_token`**

##### :heavy_check_mark: On succes:
- The request will be successfully executed as expected.

##### :x: Errors:
- You didn't authorized your request - You will receive a `401 Unauthorized` status and the following JSON response:
```
{
    "message": "Unauthenticated."
}
```
- You didn't make a correct API request - You will receive a `405 Method not allowed` and the following JSON response:
```
{
    "message": "This URL is used as a REST API. This means only API calls are allowed!"
}
```

## Events
The `events` endpoind is used to list and create events.

#### :page_facing_up: Checklist
- [x] Create a get method, so the events can be shown.
- [x] Create a create method, so new events can be created.
- [x] Create an update method, so events can be changed.
- [ ] Create a remove method, so events can be removed.

<br>

### :book: Get events (get method)
The `get endpoints` do not use any body text.
- `/api/events` returns all events.
- `/api/events/[id]` returns event with specific `id`.

##### :x: Errors:
- `[]` - There are no events to show
- `404` - The specific event you're looking for doesn't exist.

##### :heavy_check_mark: On succes:
`200 OK` - returns a JSON object with all/specific event(s).

<br>

### :pencil2: Create events (post method)
The `post endpoints` **require** all body data as described.
- `/api/events` returns the data added to the DB.
  - `title` (**required**, string, max:191) - The title.
  - `description` (**required**, text) - The description.
  - `date` (**required**, timestamp, after or equal to today) - The date (and time) of the new event.
  - `thumbnail` (**required**, url, max:191) - The url of a image used as a thumbnail..
  - `seats` (**required**, int, min:0) - Total available seats.
  - `postal_code` (**required**, string, NL/BE/DE postal code) - Postal code of the location.
  - `hnum` (**required**, string, max:191) - House number of the location.
  - `notification` (**required**, bool) - True if you want to send a mail about the new event.
  
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
`201 Created` - returns a JSON object with the created event data.

<br>

### :pencil: Update events (put method)
The `put endpoints` do not require anything in the body. Only add the fields you want to change to the body.
- `/api/events/[id]` returns the entire (edited) event.
  - `title` (string, max:191) - The title.
  - `description` (text) - The description.
  - `date` (timestamp, after or equal to today) - The date (and time) of the new event.
  - `thumbnail` (url, max:191) - The url of a image used as a thumbnail..
  - `seats` (int, min:0) - Total available seats.
  - `postal_code` (string, NL/BE/DE postal code) - Postal code of the location.
  - `hnum` (string, max:191) - House number of the location.
  - `notification` (bool) - True if you want to send a mail about the new event.
  
##### :x: Errors:
- Errors are equal to the `create endpoint`
- **No error** will be trown when the body is empty

##### :heavy_check_mark: On succes:
`200 OK` - returns a JSON object with the updated event data.
