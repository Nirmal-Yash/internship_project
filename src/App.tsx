import React, { useState } from 'react';
import Header from './components/Header';
import Hero from './components/Hero';
import ProductGrid from './components/ProductGrid';
import ProductDetail from './components/ProductDetail';
import Cart from './components/Cart';
import Checkout from './components/Checkout';
import Footer from './components/Footer';
import LoginRegister from './components/Auth/LoginRegister';
import AdminDashboard from './components/Admin/AdminDashboard';
import CustomerDashboard from './components/Customer/CustomerDashboard';
import { Product, CartItem, User, Order } from './types';
import { sampleProducts } from './data/products';
import { sampleOrders } from './data/orders';

function App() {
  const [currentView, setCurrentView] = useState<'home' | 'product' | 'cart' | 'checkout' | 'admin' | 'customer'>('home');
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  const [cartItems, setCartItems] = useState<CartItem[]>([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [showAuth, setShowAuth] = useState(false);
  const [currentUser, setCurrentUser] = useState<User | null>(null);
  const [products, setProducts] = useState<Product[]>(sampleProducts);
  const [orders, setOrders] = useState<Order[]>(sampleOrders);

  const addToCart = (product: Product, quantity = 1) => {
    setCartItems(prev => {
      const existing = prev.find(item => item.id === product.id);
      if (existing) {
        return prev.map(item =>
          item.id === product.id
            ? { ...item, quantity: item.quantity + quantity }
            : item
        );
      }
      return [...prev, { ...product, quantity }];
    });
  };

  const removeFromCart = (productId: string) => {
    setCartItems(prev => prev.filter(item => item.id !== productId));
  };

  const updateCartQuantity = (productId: string, quantity: number) => {
    if (quantity <= 0) {
      removeFromCart(productId);
      return;
    }
    setCartItems(prev =>
      prev.map(item =>
        item.id === productId ? { ...item, quantity } : item
      )
    );
  };

  const viewProduct = (product: Product) => {
    setSelectedProduct(product);
    setCurrentView('product');
  };

  const handleLogin = (user: User) => {
    setCurrentUser(user);
    setShowAuth(false);
    if (user.role === 'admin') {
      setCurrentView('admin');
    } else {
      setCurrentView('customer');
    }
  };

  const handleLogout = () => {
    setCurrentUser(null);
    setCurrentView('home');
    setCartItems([]);
  };

  const handlePlaceOrder = (orderData: Omit<Order, 'id' | 'userId' | 'createdAt'>) => {
    const newOrder: Order = {
      ...orderData,
      id: Date.now().toString(),
      userId: currentUser?.id || 'guest',
      createdAt: new Date().toISOString()
    };
    
    setOrders(prev => [newOrder, ...prev]);
    setCartItems([]);
    
    if (currentUser?.role === 'customer') {
      setCurrentView('customer');
    } else {
      setCurrentView('home');
    }
    
    alert('Order placed successfully!');
  };

  // Admin functions
  const handleAddProduct = (productData: Omit<Product, 'id'>) => {
    const newProduct: Product = {
      ...productData,
      id: Date.now().toString()
    };
    setProducts(prev => [...prev, newProduct]);
  };

  const handleUpdateProduct = (id: string, productData: Partial<Product>) => {
    setProducts(prev =>
      prev.map(product =>
        product.id === id ? { ...product, ...productData } : product
      )
    );
  };

  const handleDeleteProduct = (id: string) => {
    setProducts(prev => prev.filter(product => product.id !== id));
  };

  const handleUpdateOrderStatus = (orderId: string, status: Order['status']) => {
    setOrders(prev =>
      prev.map(order =>
        order.id === orderId ? { ...order, status } : order
      )
    );
  };

  const filteredProducts = products.filter(product =>
    product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    product.category.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const cartTotal = cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
  const cartItemCount = cartItems.reduce((total, item) => total + item.quantity, 0);

  // Show admin or customer dashboard if logged in
  if (currentUser?.role === 'admin' && currentView === 'admin') {
    return (
      <AdminDashboard
        products={products}
        orders={orders}
        onAddProduct={handleAddProduct}
        onUpdateProduct={handleUpdateProduct}
        onDeleteProduct={handleDeleteProduct}
        onUpdateOrderStatus={handleUpdateOrderStatus}
      />
    );
  }

  if (currentUser?.role === 'customer' && currentView === 'customer') {
    return (
      <CustomerDashboard
        user={currentUser}
        orders={orders}
      />
    );
  }

  return (
    <div className="min-h-screen bg-white">
      <Header
        cartItemCount={cartItemCount}
        onCartClick={() => setCurrentView('cart')}
        onHomeClick={() => setCurrentView('home')}
        searchTerm={searchTerm}
        onSearchChange={setSearchTerm}
        currentUser={currentUser}
        onLoginClick={() => setShowAuth(true)}
        onLogout={handleLogout}
        onDashboardClick={() => setCurrentView(currentUser?.role === 'admin' ? 'admin' : 'customer')}
      />

      {currentView === 'home' && (
        <>
          <Hero />
          <ProductGrid
            products={filteredProducts}
            onProductClick={viewProduct}
            onAddToCart={addToCart}
          />
        </>
      )}

      {currentView === 'product' && selectedProduct && (
        <ProductDetail
          product={selectedProduct}
          onAddToCart={addToCart}
          onBackToHome={() => setCurrentView('home')}
        />
      )}

      {currentView === 'cart' && (
        <Cart
          items={cartItems}
          total={cartTotal}
          onUpdateQuantity={updateCartQuantity}
          onRemoveItem={removeFromCart}
          onBackToHome={() => setCurrentView('home')}
          onCheckout={() => setCurrentView('checkout')}
        />
      )}

      {currentView === 'checkout' && (
        <Checkout
          items={cartItems}
          total={cartTotal}
          onPlaceOrder={handlePlaceOrder}
          onBackToCart={() => setCurrentView('cart')}
        />
      )}

      <Footer />

      {showAuth && (
        <LoginRegister
          onLogin={handleLogin}
          onClose={() => setShowAuth(false)}
        />
      )}
    </div>
  );
}

export default App;