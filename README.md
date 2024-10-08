﻿# sawProject -- E-commerce Demonstration Project

## Overview

This project is a demonstration of a basic e-commerce platform developed using PHP and JavaScript with a MySQL database, featuring a custom-built routing system without the use of external libraries. The platform includes essential e-commerce functionalities such as product management, user registration and login, dynamic shopping cart management, a checkout process, and a review system. This project is intended for educational purposes and does not include real payment processing.

## Features

### Backend
- **PHP**: The entire application is built using PHP, with a custom routing system that handles all HTTP requests without relying on external libraries.
- **MySQL Database**: The platform uses a MySQL database to manage:
  - **Products**: Information such as name, price, description, stock quantity,  ecc...
  - **Users**: User details including registration information and profile customization.
  - **Orders**: Tracking of user orders, including the products purchased and order status.

### User Management
- **Registration and Login**: Users can create an account and log in to access personalized features.
- **Profile Management**: Users can edit their profile information, including optional fields like a public username used in product reviews.

### Shopping Cart
- **Dynamic Cart**: The shopping cart is dynamically updated with every addition or removal of a product. Each action triggers a query that updates the corresponding database table.
- **Checkout System**: The checkout process includes a quantity check to ensure that products are still available in the required quantities.

### Product Reviews
- **Rating System**: Users can leave reviews for products they have purchased. Reviews include:
  - **Star Ratings**: From 1 to 5 stars, with the option to give half-star ratings (e.g., 1.5 stars).
  - **Comments**: Users can provide a title and description for their review.
- **Review Restrictions**: Reviews can only be submitted for products that the user has purchased and not yet reviewed.
