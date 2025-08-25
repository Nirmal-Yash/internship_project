import React from 'react';

const Hero: React.FC = () => {
  return (
    <section className="relative bg-gradient-to-r from-blue-600 to-purple-700 text-white">
      <div className="container mx-auto px-4 py-20">
        <div className="max-w-3xl">
          <h1 className="text-5xl md:text-6xl font-bold mb-6 leading-tight">
            Discover Amazing
            <span className="text-yellow-300"> Products</span>
          </h1>
          <p className="text-xl md:text-2xl mb-8 text-blue-100">
            Shop the latest trends with premium quality and unbeatable prices. 
            Your perfect product is just a click away.
          </p>
          <div className="flex flex-col sm:flex-row gap-4">
            <button className="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-yellow-300 transform hover:scale-105 transition-all duration-200">
              Shop Now
            </button>
            <button className="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
              Learn More
            </button>
          </div>
        </div>
      </div>
      
      {/* Background decoration */}
      <div className="absolute top-0 right-0 w-1/3 h-full opacity-10">
        <div className="w-full h-full bg-white rounded-l-full"></div>
      </div>
    </section>
  );
};

export default Hero;