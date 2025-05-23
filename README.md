# Lytvynov Tech Task

## Home Page

The application provides a weather dashboard that displays current weather information for three cities:
- Cherkasy
- Kyiv
- Warsaw

The dashboard is accessible at the root URL (`/`) and uses Tailwind CSS for styling.

## API Endpoints

### Get Weather Data

```
GET /api/weather/{city}
```

Retrieves current weather data for the specified city.

#### Parameters

- `city` (string, required): The name of the city to get weather data for.

#### Response

On success (200 OK):

```json
{
  "city": "London",
  "country": "United Kingdom",
  "temperature": 15.5,
  "condition": "Partly cloudy",
  "humidity": 76,
  "wind_speed": 14.4,
  "last_updated": "2023-05-23 12:30"
}
```

On error (400 Bad Request):

```json
{
  "error": "Error message describing the issue"
}
```

## Configuration

The Weather API key is configured in `.env`:

```dotenv
API_WEATHER_KEY=your_real_api_key_here
```

## Tests

```bash
php bin/phpunit
```
