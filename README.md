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

3. Create and configure your .env file
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations
```bash
php artisan migrate
```

5. Run the development server
```bash
php artisan serve
```

## API Documentation

### Authentication

First, register a user or login to get your token:

```bash
# Register a new user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Or login with existing user
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

All subsequent requests must include the token in the Authorization header:
```
Authorization: Bearer your-token-here
```

### Endpoints

#### List Daily Sheets
```http
GET /api/daily-sheets
```

#### Get Daily Sheet by Date
```http
GET /api/daily-sheets/{date}
```

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

### Test cURLs

Replace `{token}` with your actual token in the commands below.

#### List Daily Sheets
```bash
curl -X GET http://localhost:8000/api/daily-sheets \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Get Daily Sheet
```bash
curl -X GET http://localhost:8000/api/daily-sheets/2024-01-10 \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Create Daily Sheet
```bash
curl -X POST http://localhost:8000/api/daily-sheets \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
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

#### Update Daily Sheet
```bash
curl -X PUT http://localhost:8000/api/daily-sheets/1 \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
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

### Validation Rules

- `date`: Required, unique date format YYYY-MM-DD
- `daily_focus`: Required string
- `day_rating`: Optional integer between 1-10
- `learned_today`: Optional string
- `priorities`: Array of 1-5 items
- `avoid_items`: Array of 1-3 items
- `gratitude_items`: Array of 1-3 items

### Error Responses

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