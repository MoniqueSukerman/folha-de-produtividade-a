# Folha de Produtividade API

A productivity sheet API to help track daily focus, priorities, things to avoid, and gratitude items.

## Local Setup

1. Clone the repository

```bash
git clone https://github.com/yourusername/folha-de-produtividade-a.git
cd folha-de-produtividade-a
```

2. Install dependencies
```bash
composer install
```

3. Run the development server
```bash
php artisan serve
```

4. Run migrations
```bash
php artisan migrate
```

5. Create a user and generate token
```bash
php artisan tinker
$user = \App\Models\User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')]);
$token = $user->createToken('test-token')->plainTextToken;
```

## API Documentation

### Authentication

All endpoints require authentication using Laravel Sanctum. Include the token in the Authorization header:

```

### Endpoints

#### Create Daily Sheet

```http
POST /api/daily-sheets

Request Body:
{
    "date": "2024-01-10",
    "daily_focus": "Complete project milestone",
    "day_rating": 8,
    "learned_today": "Learned about Laravel relationships",
    "priorities": [
        {"description": "Priority 1"},
        {"description": "Priority 2"}
    ],
    "avoid_items": [
        {"description": "Avoid 1"},
        {"description": "Avoid 2"}
    ],
    "gratitude_items": [
        {"description": "Gratitude 1"},
        {"description": "Gratitude 2"}
    ]
}
```

#### Get Daily Sheet
```http
GET /api/daily-sheets/{date}
```

#### Update Daily Sheet
```http
PUT /api/daily-sheets/{id}

Request Body:
{
    "daily_focus": "Updated focus",
    "day_rating": 9,
    "learned_today": "Updated learning",
    "priorities": [
        {"description": "Updated priority 1"},
        {"description": "Updated priority 2"}
    ],
    "avoid_items": [
        {"description": "Updated avoid 1"}
    ],
    "gratitude_items": [
        {"description": "Updated gratitude 1"}
    ]
}
```

### Validation Rules

- `date`: Required, unique date format YYYY-MM-DD
- `daily_focus`: Required string
- `day_rating`: Optional integer between 1-10
- `learned_today`: Optional string
- `priorities`: Array of 1-5 items
- `avoid_items`: Array of 1-3 items
- `gratitude_items`: Array of 1-3 items

## Test cURLs

First, replace `{token}` with your actual token in the commands below.

### Create Daily Sheet
```bash
curl -X POST http://localhost:8000/api/daily-sheets \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "date": "2024-01-10",
    "daily_focus": "Complete project milestone",
    "day_rating": 8,
    "learned_today": "Learned about Laravel relationships",
    "priorities": [
        {"description": "Priority 1"},
        {"description": "Priority 2"}
    ],
    "avoid_items": [
        {"description": "Avoid 1"},
        {"description": "Avoid 2"}
    ],
    "gratitude_items": [
        {"description": "Gratitude 1"},
        {"description": "Gratitude 2"}
    ]
}'
```

### Get Daily Sheet
```bash
curl -X GET http://localhost:8000/api/daily-sheets/2024-01-10 \
  -H "Authorization: Bearer {token}"
```

### Update Daily Sheet
```bash
curl -X PUT http://localhost:8000/api/daily-sheets/1 \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "daily_focus": "Updated focus",
    "day_rating": 9,
    "learned_today": "Updated learning",
    "priorities": [
        {"description": "Updated priority 1"},
        {"description": "Updated priority 2"}
    ],
    "avoid_items": [
        {"description": "Updated avoid 1"}
    ],
    "gratitude_items": [
        {"description": "Updated gratitude 1"}
    ]
}'
```

## Error Responses

The API returns appropriate HTTP status codes:

- `401` - Unauthorized (invalid or missing token)
- `404` - Daily sheet not found
- `422` - Validation error
- `500` - Server error

For validation errors, the response includes detailed error messages:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": [
            "Error message"
        ]
    }
}
```

This README provides:
1. Clear setup instructions
2. API documentation with request/response examples
3. Validation rules
4. Test cURLs for all endpoints
5. Error handling information

Would you like me to add or modify anything in the documentation?
