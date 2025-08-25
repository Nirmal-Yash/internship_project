import { User } from '../types';

export const sampleUsers: User[] = [
  {
    id: '1',
    email: 'admin@shophub.com',
    name: 'Admin User',
    role: 'admin'
  },
  {
    id: '2',
    email: 'customer@example.com',
    name: 'John Doe',
    role: 'customer'
  }
];

// Mock credentials for demo
export const mockCredentials = {
  'admin@shophub.com': { password: 'admin123', role: 'admin' as const },
  'customer@example.com': { password: 'customer123', role: 'customer' as const }
};