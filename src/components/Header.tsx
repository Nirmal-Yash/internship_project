import React from 'react';
import { ShoppingCart, Search, Menu, User, LogOut, Settings } from 'lucide-react';
import { User as UserType } from '../types';

interface HeaderProps {
  cartItemCount: number;
  onCartClick: () => void;
  onHomeClick: () => void;
  searchTerm: string;
  onSearchChange: (term: string) => void;
  currentUser: UserType | null;
  onLoginClick: () => void;
  onLogout: () => void;
  onDashboardClick: () => void;
}

const Header: React.FC<HeaderProps> = ({
  cartItemCount,
  onCartClick,
  onHomeClick,
  searchTerm,
  onSearchChange,
  currentUser,
  onLoginClick,
  onLogout,
  onDashboardClick,
}) => {
  return (
    <header className="sticky top-0 z-50 bg-white shadow-md">
      <div className="container mx-auto px-4 py-4">
        <div className="flex items-center justify-between">
          {/* Logo */}
          <button
            onClick={onHomeClick}
            className="text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors"
          >
            ShopHub
          </button>

          {/* Search Bar */}
          <div className="flex-1 max-w-lg mx-8">
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              <input
                type="text"
                placeholder="Search products..."
                value={searchTerm}
                onChange={(e) => onSearchChange(e.target.value)}
                className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>

          {/* Navigation */}
          <div className="flex items-center space-x-6">
            {currentUser ? (
              <div className="flex items-center space-x-4">
                <span className="text-sm text-gray-600">
                  Welcome, {currentUser.name}
                </span>
                <button
                  onClick={onDashboardClick}
                  className="text-gray-600 hover:text-blue-600 transition-colors flex items-center space-x-1"
                >
                  <Settings className="w-5 h-5" />
                  <span className="hidden md:inline">Dashboard</span>
                </button>
                <button
                  onClick={onLogout}
                  className="text-gray-600 hover:text-red-600 transition-colors"
                >
                  <LogOut className="w-5 h-5" />
                </button>
              </div>
            ) : (
              <button
                onClick={onLoginClick}
                className="text-gray-600 hover:text-blue-600 transition-colors flex items-center space-x-1"
              >
                <User className="w-5 h-5" />
                <span className="hidden md:inline">Login</span>
              </button>
            )}
            
            <button
              onClick={onCartClick}
              className="relative text-gray-600 hover:text-blue-600 transition-colors"
            >
              <ShoppingCart className="w-6 h-6" />
              {cartItemCount > 0 && (
                <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                  {cartItemCount}
                </span>
              )}
            </button>

            <button className="md:hidden text-gray-600 hover:text-blue-600 transition-colors">
              <Menu className="w-6 h-6" />
            </button>
          </div>
        </div>
      </div>
    </header>
  );
};

export default Header;