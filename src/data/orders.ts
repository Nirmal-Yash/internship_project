import { Order } from '../types';

export const sampleOrders: Order[] = [
  {
    id: '1',
    userId: '2',
    items: [
      {
        id: '1',
        name: 'Premium Wireless Headphones',
        price: 299.99,
        image: 'https://images.pexels.com/photos/3945667/pexels-photo-3945667.jpeg?auto=compress&cs=tinysrgb&w=500',
        images: [],
        category: 'Electronics',
        description: 'High-quality wireless headphones',
        rating: 4.8,
        reviews: 234,
        inStock: true,
        features: [],
        quantity: 1
      }
    ],
    total: 299.99,
    status: 'pending',
    createdAt: '2024-01-15T10:30:00Z',
    customerInfo: {
      name: 'John Doe',
      email: 'customer@example.com',
      address: '123 Main St, City, State 12345',
      phone: '+1 (555) 123-4567'
    }
  },
  {
    id: '2',
    userId: '2',
    items: [
      {
        id: '2',
        name: 'Smart Watch Pro',
        price: 399.99,
        image: 'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg?auto=compress&cs=tinysrgb&w=500',
        images: [],
        category: 'Electronics',
        description: 'Advanced smartwatch',
        rating: 4.6,
        reviews: 189,
        inStock: true,
        features: [],
        quantity: 2
      }
    ],
    total: 799.98,
    status: 'confirmed',
    createdAt: '2024-01-14T15:45:00Z',
    customerInfo: {
      name: 'John Doe',
      email: 'customer@example.com',
      address: '123 Main St, City, State 12345',
      phone: '+1 (555) 123-4567'
    }
  }
];