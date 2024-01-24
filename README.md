# Message Microservice

## Overview
The Message Microservice is designed to handle the storage of user messages. It features a secure endpoint that requires users to be authenticated before they can save their messages. Authentication is managed through token verification, which is done by interfacing with an external Authentication Microservice.

### Features
- **Save Message**: Allows authenticated users to save messages by providing a title and content. Authentication is done via JWT tokens, verified through the Authentication Microservice.

## Getting Started

### Prerequisites
- Docker
- Access to the Authentication Microservice for token validation.
- Any REST client (like Postman) for testing the endpoints.


### Installation
1. Clone the repository:
```
git clone https://github.com/afshin-phpy/message-microservice.git
```

2. Navigate to the project directory:

```
cd message-microservice
```
3. Install dependencies:
```
composer install
```
4. Build container:
```
docker-compose build
```

5. Run the container:
```
docker-compose up -d
```

6. Create a .env file in root directory and copy .env.example content into .env file

7. Edit following key in .env file and put your system IP address:

```
AUTH_API_URL = "Your_IP_Address"
```

8. Run following command for database migration:
```
docker-compose exec app1 php artisan migrate
```


### Using the Microservice

#### Login
- **Host**: `127.0.0.1:9000`
- **Endpoint**: `/api/message/store`
- **Headers**:  `Authorization: Bearer [JWT]`
- **Method**: POST
- **Body**:
```json
{
 "title": "[message title]",
 "content": "[message content]"
}
```

#### Response:
    Success: Confirmationc of message saving.
    Error: Relevant error message, including authentication failures.

Example:
```json
{
    "data": {
        "status": "success",
        "message": "your data has been stored."
    }
}
```


#### Token Validation

- The microservice sends the received JWT token to the Authentication Microservice's `/validate` endpoint.
- If the token is valid, the message is saved.
- If not, the user is prevented from saving the message.


### Running Tests

To ensure the functionality of the microservice, tests are provided. Run the following command to execute the tests:

    docker-compose exec app vendor/bin/phpunit