# PHP E-commerce Backend

This is a complete PHP backend for the e-commerce website with MySQL database integration.

## Setup Instructions

### 1. Database Setup
1. Open phpMyAdmin in your browser
2. Create a new database called `ecommerce_db`
3. Import the `database/schema.sql` file to create all tables and sample data

### 2. Server Configuration
1. Copy all files to your web server (XAMPP, WAMP, or live server)
2. Update database credentials in `config/database.php`:
   - `$host` - your database host (usually 'localhost')
   - `$db_name` - database name ('ecommerce_db')
   - `$username` - your database username
   - `$password` - your database password

### 3. CORS Configuration
Update the CORS origin in `config/cors.php` to match your React app URL:
```php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Your React app URL
```

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration

### Products
- `GET /api/products/read.php` - Get all products
- `GET /api/products/read_one.php?id={id}` - Get single product
- `POST /api/products/create.php` - Create product (Admin only)
- `PUT /api/products/update.php` - Update product (Admin only)
- `DELETE /api/products/delete.php` - Delete product (Admin only)

### Orders
- `GET /api/orders/read.php` - Get all orders (Admin only)
- `GET /api/orders/read_by_user.php?user_id={id}` - Get user orders
- `POST /api/orders/create.php` - Create new order
- `PUT /api/orders/update_status.php` - Update order status (Admin only)

## Default Users
- **Admin**: admin@shophub.com / admin123
- **Customer**: customer@example.com / customer123

## Frontend Integration

To connect your React frontend with this PHP backend, update the API calls in your React components:

```javascript
// Example: Fetch products
const fetchProducts = async () => {
  const response = await fetch('http://your-server.com/api/products/read.php');
  const data = await response.json();
  return data.records;
};

// Example: User login
const login = async (email, password) => {
  const response = await fetch('http://your-server.com/api/auth/login.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password })
  });
  return await response.json();
};
```

## File Structure
```
php-backend/
├── config/
│   ├── database.php      # Database connection
│   └── cors.php         # CORS headers
├── models/
│   ├── User.php         # User model
│   ├── Product.php      # Product model
│   ├── Order.php        # Order model
│   └── OrderItem.php    # Order items model
├── api/
│   ├── auth/           # Authentication endpoints
│   ├── products/       # Product endpoints
│   ├── orders/         # Order endpoints
│   └── .htaccess       # URL rewriting
├── database/
│   └── schema.sql      # Database schema
└── README.md
```

## Security Features
- Password hashing using PHP's `password_hash()`
- SQL injection prevention using prepared statements
- Input sanitization
- CORS protection
- Transaction support for order creation

## Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- PDO extension enabled