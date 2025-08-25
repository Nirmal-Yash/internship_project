import { Product } from '../types';

export const sampleProducts: Product[] = [
  {
    id: '1',
    name: 'Premium Wireless Headphones',
    price: 299.99,
    image: 'https://images.pexels.com/photos/3945667/pexels-photo-3945667.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/3945667/pexels-photo-3945667.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/8534088/pexels-photo-8534088.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Electronics',
    description: 'High-quality wireless headphones with noise cancellation and premium sound quality.',
    rating: 4.8,
    reviews: 234,
    inStock: true,
    features: ['Active Noise Cancellation', '30-hour battery life', 'Premium materials', 'Wireless charging case']
  },
  {
    id: '2',
    name: 'Smart Watch Pro',
    price: 399.99,
    image: 'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/1616516/pexels-photo-1616516.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Electronics',
    description: 'Advanced smartwatch with health monitoring, GPS, and premium design.',
    rating: 4.6,
    reviews: 189,
    inStock: true,
    features: ['Heart rate monitoring', 'GPS tracking', 'Water resistant', 'Premium build quality']
  },
  {
    id: '3',
    name: 'Stylish Backpack',
    price: 89.99,
    image: 'https://images.pexels.com/photos/2905238/pexels-photo-2905238.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/2905238/pexels-photo-2905238.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/2081166/pexels-photo-2081166.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Fashion',
    description: 'Durable and stylish backpack perfect for daily use and travel.',
    rating: 4.5,
    reviews: 156,
    inStock: true,
    features: ['Multiple compartments', 'Water resistant', 'Ergonomic design', 'Premium materials']
  },
  {
    id: '4',
    name: 'Coffee Maker Deluxe',
    price: 199.99,
    image: 'https://images.pexels.com/photos/2061127/pexels-photo-2061127.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/2061127/pexels-photo-2061127.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/302902/pexels-photo-302902.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Home & Kitchen',
    description: 'Professional-grade coffee maker with programmable features and premium build.',
    rating: 4.7,
    reviews: 98,
    inStock: true,
    features: ['Programmable brewing', '12-cup capacity', 'Auto-shutoff', 'Thermal carafe']
  },
  {
    id: '5',
    name: 'Wireless Speaker',
    price: 149.99,
    image: 'https://images.pexels.com/photos/1649771/pexels-photo-1649771.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/1649771/pexels-photo-1649771.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/6991463/pexels-photo-6991463.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Electronics',
    description: 'Portable wireless speaker with exceptional sound quality and long battery life.',
    rating: 4.4,
    reviews: 267,
    inStock: false,
    features: ['360° sound', 'Waterproof design', '20-hour battery', 'Voice assistant compatible']
  },
  {
    id: '6',
    name: 'Fitness Tracker',
    price: 79.99,
    image: 'https://images.pexels.com/photos/4498489/pexels-photo-4498489.jpeg?auto=compress&cs=tinysrgb&w=500',
    images: [
      'https://images.pexels.com/photos/4498489/pexels-photo-4498489.jpeg?auto=compress&cs=tinysrgb&w=800',
      'https://images.pexels.com/photos/267394/pexels-photo-267394.jpeg?auto=compress&cs=tinysrgb&w=800',
    ],
    category: 'Health & Fitness',
    description: 'Advanced fitness tracker with heart rate monitoring and sleep tracking.',
    rating: 4.3,
    reviews: 445,
    inStock: true,
    features: ['Heart rate monitoring', 'Sleep tracking', 'Step counter', '7-day battery life']
  }
];