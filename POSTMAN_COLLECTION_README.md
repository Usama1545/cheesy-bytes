# CheesyBite API Postman Collection

This document explains how to use the Postman collection for testing the CheesyBite API.

## 📦 Importing the Collection

1. Open Postman
2. Click **Import** button (top left)
3. Select the file: `CheesyBite_API_Collection.postman_collection.json`
4. Click **Import**

## 🔧 Setup Environment Variables

After importing, set up environment variables:

### Create a New Environment

1. Click the **Environments** icon (left sidebar) in Postman
2. Click **+** to create a new environment
3. Name it: `CheesyBite API Local` or `CheesyBite API Production`

### Add Variables

| Variable Name | Initial Value | Current Value | Description |
|--------------|---------------|---------------|-------------|
| `base_url` | `http://localhost:8000` | `http://localhost:8000` | Base URL of your API |
| `auth_token` | (leave empty) | (will be set automatically) | Authentication token |

**For Production:**
- Set `base_url` to your production URL: `https://yourdomain.com`

### Select Environment

1. Select your created environment from the dropdown (top right)
2. Make sure it's active before making requests

## 🔑 Authentication Flow

### Step 1: Register a New User

1. Go to **Authentication** → **Register**
2. Update the request body with your details:
```json
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "mobile": "1234567890",
    "password": "password123",
    "checkbox": true,
    "referral_code": ""
}
```
3. Send the request
4. You should receive a response indicating OTP was sent (if email verification is enabled)

### Step 2: Verify OTP

1. Go to **Authentication** → **Verify OTP**
2. Enter the OTP code received:
```json
{
    "otp": "123456",
    "email": "john.doe@example.com"
}
```
3. Send the request
4. **Important:** Copy the `token` from the response
5. Paste it into the `auth_token` environment variable

### Step 3: Login (Alternative)

1. Go to **Authentication** → **Login**
2. Enter your credentials:
```json
{
    "email": "john.doe@example.com",
    "password": "password123"
}
```
3. Send the request
4. Copy the `token` from the response
5. Update the `auth_token` environment variable

## 📝 API Endpoints Overview

### Public Endpoints (No Authentication Required)

- **POST** `/api/register` - Register new user
- **POST** `/api/verify-otp` - Verify OTP code
- **POST** `/api/resend-otp` - Resend OTP
- **POST** `/api/login` - User login
- **POST** `/api/forgot-password` - Reset password

### Protected Endpoints (Authentication Required)

All protected endpoints automatically use the `auth_token` variable. Just make sure it's set!

- **GET** `/api/profile` - Get user profile
- **POST** `/api/profile/update` - Update profile
- **GET** `/api/profile/send-email-status` - Toggle email notifications
- **GET** `/api/refer-earn` - Get referral information
- **POST** `/api/changepassword` - Change password
- **POST** `/api/logout` - Logout

### Other Endpoints

- **GET** `/api/branches` - Get all branches
- **GET** `/api/home-items` - Get home page items
- **GET** `/api/categories` - Get categories
- **GET** `/api/category-items/{slug}` - Get category items
- **GET** `/api/item-details/{slug}` - Get item details
- **GET** `/api/deals` - Get deals
- **GET** `/api/favoriteItems` - Get favorites (requires auth)
- **POST** `/api/managefavorite` - Toggle favorite (requires auth)

## 🎯 Quick Testing Tips

### Testing Authentication

1. **Register** → Copy OTP or wait for email
2. **Verify OTP** → Copy token and save to `auth_token`
3. **Get Profile** → Should work with the token

### Testing Protected Routes

1. Make sure `auth_token` is set in your environment
2. All protected routes automatically include the token in headers
3. If you get 401 errors, your token may have expired - login again

### Updating the Token Automatically

You can set up a Postman test script to automatically save the token:

1. Go to **Authentication** → **Login** request
2. Click on **Tests** tab
3. Add this script:

```javascript
if (pm.response.code === 200) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.token) {
        pm.environment.set("auth_token", jsonData.data.token);
        console.log("Token saved automatically!");
    }
}
```

4. Now whenever you login, the token will be saved automatically!

## 🔄 Common Request Parameters

### Query Parameters

- `branch_id` - Required for most item/deal endpoints
- `page` - For paginated responses

### Headers

All requests automatically include:
- `Accept: application/json`
- `Content-Type: application/json` (for POST requests)
- `Authorization: Bearer {token}` (for protected routes)

## 📋 Example Responses

### Success Response
```json
{
    "status": true,
    "message": "Success",
    "data": {
        ...
    }
}
```

### Error Response
```json
{
    "status": false,
    "message": "Error message here",
    "errors": {
        ...
    }
}
```

## 🛠️ Troubleshooting

### Token Not Working

1. Check if `auth_token` is set in your environment
2. Verify you selected the correct environment
3. Token might have expired - try logging in again
4. Make sure the token is in format: `Bearer {token}` (handled automatically)

### 404 Errors

1. Check your `base_url` is correct
2. Make sure your Laravel server is running
3. Check if the route exists in `routes/api.php`

### 422 Validation Errors

1. Check all required fields are provided
2. Verify data format matches examples
3. Check error messages in response for details

### CORS Errors

If you get CORS errors:
1. Check your Laravel CORS configuration
2. Make sure `APP_URL` in `.env` matches your `base_url`
3. Verify middleware is properly configured

## 📚 Additional Resources

- Laravel Sanctum Documentation: https://laravel.com/docs/sanctum
- Postman Documentation: https://learning.postman.com/

## 🔐 Security Notes

- Never commit tokens to version control
- Use different environments for development and production
- Rotate tokens regularly in production
- Use HTTPS in production

---

**Happy Testing! 🚀**


