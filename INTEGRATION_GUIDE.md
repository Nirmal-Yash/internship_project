# Frontend-Backend Integration Guide

This guide explains how to integrate the React frontend with the PHP backend.

## Step 1: Update API Configuration

Create an API configuration file in your React app:

```javascript
// src/config/api.js
const API_BASE_URL = 'http://localhost/php-backend/api'; // Update with your server URL

export const API_ENDPOINTS = {
  // Auth
  LOGIN: `${API_BASE_URL}/auth/login.php`,
  REGISTER: `${API_BASE_URL}/auth/register.php`,
  
  // Products
  PRODUCTS: `${API_BASE_URL}/products/read.php`,
  PRODUCT_DETAIL: `${API_BASE_URL}/products/read_one.php`,
  CREATE_PRODUCT: `${API_BASE_URL}/products/create.php`,
  UPDATE_PRODUCT: `${API_BASE_URL}/products/update.php`,
  DELETE_PRODUCT: `${API_BASE_URL}/products/delete.php`,
  
  // Orders
  ORDERS: `${API_BASE_URL}/orders/read.php`,
  USER_ORDERS: `${API_BASE_URL}/orders/read_by_user.php`,
  CREATE_ORDER: `${API_BASE_URL}/orders/create.php`,
  UPDATE_ORDER_STATUS: `${API_BASE_URL}/orders/update_status.php`,
};
```

## Step 2: Create API Service Functions

```javascript
// src/services/api.js
import { API_ENDPOINTS } from '../config/api';

// Auth Services
export const authService = {
  login: async (email, password) => {
    const response = await fetch(API_ENDPOINTS.LOGIN, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password })
    });
    return await response.json();
  },

  register: async (name, email, password, role = 'customer') => {
    const response = await fetch(API_ENDPOINTS.REGISTER, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, password, role })
    });
    return await response.json();
  }
};

// Product Services
export const productService = {
  getAll: async () => {
    const response = await fetch(API_ENDPOINTS.PRODUCTS);
    const data = await response.json();
    return data.records || [];
  },

  getById: async (id) => {
    const response = await fetch(`${API_ENDPOINTS.PRODUCT_DETAIL}?id=${id}`);
    return await response.json();
  },

  create: async (productData) => {
    const response = await fetch(API_ENDPOINTS.CREATE_PRODUCT, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(productData)
    });
    return await response.json();
  },

  update: async (id, productData) => {
    const response = await fetch(API_ENDPOINTS.UPDATE_PRODUCT, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, ...productData })
    });
    return await response.json();
  },

  delete: async (id) => {
    const response = await fetch(API_ENDPOINTS.DELETE_PRODUCT, {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    });
    return await response.json();
  }
};

// Order Services
export const orderService = {
  getAll: async () => {
    const response = await fetch(API_ENDPOINTS.ORDERS);
    const data = await response.json();
    return data.records || [];
  },

  getByUser: async (userId) => {
    const response = await fetch(`${API_ENDPOINTS.USER_ORDERS}?user_id=${userId}`);
    const data = await response.json();
    return data.records || [];
  },

  create: async (orderData) => {
    const response = await fetch(API_ENDPOINTS.CREATE_ORDER, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(orderData)
    });
    return await response.json();
  },

  updateStatus: async (id, status) => {
    const response = await fetch(API_ENDPOINTS.UPDATE_ORDER_STATUS, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, status })
    });
    return await response.json();
  }
};
```

## Step 3: Update React Components

Replace the mock data and local state management with API calls:

```javascript
// In your App.tsx or relevant components
import { useEffect, useState } from 'react';
import { productService, authService, orderService } from './services/api';

function App() {
  const [products, setProducts] = useState([]);
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);

  // Load products from API
  useEffect(() => {
    const loadProducts = async () => {
      try {
        const productsData = await productService.getAll();
        setProducts(productsData);
      } catch (error) {
        console.error('Error loading products:', error);
      } finally {
        setLoading(false);
      }
    };

    loadProducts();
  }, []);

  // Handle login
  const handleLogin = async (email, password) => {
    try {
      const result = await authService.login(email, password);
      if (result.user) {
        setCurrentUser(result.user);
        // Load user-specific data
        if (result.user.role === 'admin') {
          const ordersData = await orderService.getAll();
          setOrders(ordersData);
        } else {
          const userOrders = await orderService.getByUser(result.user.id);
          setOrders(userOrders);
        }
        return result.user;
      } else {
        throw new Error(result.message);
      }
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  };

  // Handle product creation (Admin)
  const handleAddProduct = async (productData) => {
    try {
      await productService.create(productData);
      // Reload products
      const updatedProducts = await productService.getAll();
      setProducts(updatedProducts);
    } catch (error) {
      console.error('Error adding product:', error);
    }
  };

  // Handle order creation
  const handlePlaceOrder = async (orderData) => {
    try {
      const result = await orderService.create({
        ...orderData,
        userId: currentUser?.id
      });
      
      if (result.order_id) {
        // Reload orders
        const updatedOrders = currentUser?.role === 'admin' 
          ? await orderService.getAll()
          : await orderService.getByUser(currentUser.id);
        setOrders(updatedOrders);
        
        // Clear cart
        setCartItems([]);
        alert('Order placed successfully!');
      }
    } catch (error) {
      console.error('Error placing order:', error);
    }
  };

  // Rest of your component logic...
}
```

## Step 4: Error Handling

Add proper error handling for API calls:

```javascript
// src/utils/errorHandler.js
export const handleApiError = (error, defaultMessage = 'An error occurred') => {
  if (error.response) {
    // Server responded with error status
    return error.response.data.message || defaultMessage;
  } else if (error.request) {
    // Request was made but no response received
    return 'Network error. Please check your connection.';
  } else {
    // Something else happened
    return error.message || defaultMessage;
  }
};
```

## Step 5: Loading States

Add loading states to your components:

```javascript
// Example loading component
const LoadingSpinner = () => (
  <div className="flex justify-center items-center py-8">
    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
  </div>
);

// Use in your components
{loading ? <LoadingSpinner /> : <ProductGrid products={products} />}
```

## Step 6: Authentication State Management

Consider using Context API or a state management library for authentication:

```javascript
// src/contexts/AuthContext.js
import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export const useAuth = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [currentUser, setCurrentUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Check for stored user session
    const storedUser = localStorage.getItem('currentUser');
    if (storedUser) {
      setCurrentUser(JSON.parse(storedUser));
    }
    setLoading(false);
  }, []);

  const login = async (email, password) => {
    const result = await authService.login(email, password);
    if (result.user) {
      setCurrentUser(result.user);
      localStorage.setItem('currentUser', JSON.stringify(result.user));
    }
    return result;
  };

  const logout = () => {
    setCurrentUser(null);
    localStorage.removeItem('currentUser');
  };

  const value = {
    currentUser,
    login,
    logout,
    loading
  };

  return (
    <AuthContext.Provider value={value}>
      {!loading && children}
    </AuthContext.Provider>
  );
};
```

This integration guide will help you connect your React frontend with the PHP backend seamlessly. Make sure to update the API base URL to match your server configuration.