# FarmSmart - Agricultural Market Information System

[![Database](https://img.shields.io/badge/Database-MySQL-blue.svg)](https://www.mysql.com/)
[![Backend](https://img.shields.io/badge/Backend-PHP-777BB4.svg)](https://www.php.net/)
[![Frontend](https://img.shields.io/badge/Frontend-HTML%2FCSS%2FJS-E34F26.svg)](https://developer.mozilla.org/en-US/docs/Web)

A comprehensive Database Management System (DBMS) project designed to connect farmers, buyers, suppliers, and market analysts in an integrated agricultural marketplace platform.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Architecture](#system-architecture)
- [User Roles](#user-roles)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Contributors](#contributors)

## 🌾 Overview

**FarmSmart** is a market information system that streamlines agricultural commerce by providing a centralized platform for crop trading, warehouse management, and market analysis. The system facilitates direct connections between farmers and buyers while providing data-driven insights for better decision-making.

### Key Objectives

- **Connect Stakeholders**: Bridge the gap between farmers, buyers, and suppliers
- **Market Transparency**: Provide real-time crop pricing and market trends
- **Efficient Logistics**: Manage warehouse operations and crop deliveries
- **Data-Driven Insights**: Offer analytical tools for market forecasting
- **Seasonal Recommendations**: Guide farmers with crop recommendations based on weather and seasons

## ✨ Features

### For Farmers 🚜
- **Crop Registration**: Post and manage crop inventory with details like growing season and quantity
- **Warehouse Delivery**: Submit crops to designated warehouses with pricing and delivery dates
- **Price Analytics**: View historical price trends for different crops
- **Seasonal Recommendations**: Receive month-wise crop suggestions based on weather conditions
- **Profile Management**: Update personal and location information

### For Buyers 🛒
- **Product Browsing**: Search and filter available crops from warehouses
- **Order Management**: Place orders with multiple payment options (BKash, Nogod, Rocket, Hand Cash)
- **Order Tracking**: View purchase history and order details
- **Direct Sourcing**: Connect with farmers for specific crop requirements

### For Suppliers 📦
- **Crop Procurement**: Browse and purchase crops from warehouses
- **Supply Management**: Track supply orders and deliveries
- **Market Insights**: Access market trends for informed purchasing

### For Analysts 📊
- **Price Data Entry**: Record and update daily crop prices
- **Market Analysis**: Generate reports on crop price fluctuations
- **Data Visualization**: View trends through interactive charts

### For Administrators 👨‍💼
- **User Management**: Oversee all user accounts (Farmers, Buyers, Suppliers, Analysts)
- **Warehouse Operations**: Create and manage warehouse zones and storage capacity
- **Crop Oversight**: Monitor all crops in the system
- **Recommendation Management**: Update monthly crop recommendations
- **Dashboard Analytics**: View system-wide statistics and user distribution
- **Data Visualization**: Bar charts for farmer crop analysis and pie charts for user distribution

## 🏗️ System Architecture

![FarmSmart System Architecture](https://raw.githubusercontent.com/Taif6612/DBMS_Project/main/docs/system_architecture.png)

The system follows a three-tier architecture:

1. **Presentation Layer**: Role-based user interfaces for Farmers, Buyers, Suppliers, Analysts, and Administrators
2. **Application Layer**: PHP backend with authentication, business logic, and data visualization modules
3. **Data Layer**: MySQL database with 11 normalized tables ensuring data integrity

### Architecture Highlights
- **PHP Middleware**: Handles all business logic and request processing
- **Session Management**: Secure user authentication and authorization
- **External Integrations**: Payment gateways (BKash, Nogod, Rocket)
- **Security Layer**: Input validation and data encryption

### Directory Structure

```
FarmSmart/
├── Market Information System/
│   ├── Login_CreateAcc/          # Authentication module
│   │   ├── login.php
│   │   ├── loginProcess.php
│   │   ├── registerPage.php
│   │   └── registerProcess.php
│   │
│   ├── FarmerUser/               # Farmer dashboard and operations
│   │   ├── LandingFarmer.php     # Dashboard with analytics
│   │   ├── postCrop.php          # Crop registration
│   │   ├── sell.php              # Warehouse delivery
│   │   ├── inventory.php         # Crop inventory management
│   │   └── profile.php
│   │
│   ├── buyer/                    # Buyer interface
│   │   ├── index.php             # Buyer dashboard
│   │   ├── buyproduct.php        # Product browsing
│   │   ├── preOrder.php          # Order placement
│   │   └── allOrder.php          # Order history
│   │
│   ├── supplier/                 # Supplier portal
│   │   ├── index.php             # Supplier dashboard
│   │   ├── browsecrops.php       # Crop browsing
│   │   └── orders.php            # Purchase tracking
│   │
│   ├── analysist/                # Market analyst tools
│   │   ├── index.php             # Analyst dashboard
│   │   ├── addPrice.php          # Price data entry
│   │   └── allCrops.php          # Crop price management
│   │
│   └── admin/                    # Administrative panel
│       ├── admin.php             # Admin dashboard
│       ├── manage_user.php       # User management
│       ├── warehouse.php         # Warehouse management
│       └── manage-crops.php      # Recommendation management
│
└── database/
    └── farmsmart.sql             # Database schema and seed data
```

## 👥 User Roles

| Role | Responsibilities | Key Features |
|------|-----------------|--------------|
| **Farmer** | Crop production and delivery | Post crops, deliver to warehouses, view price analytics |
| **Buyer** | Purchase agricultural products | Browse products, place orders, track purchases |
| **Supplier** | Procure crops for distribution | Browse crops, manage supply orders |
| **Analyst** | Market data management | Update crop prices, analyze market trends |
| **Administrator** | System oversight | Manage users, warehouses, and recommendations |

## 🗄️ Database Schema

![FarmSmart Database Schema](https://raw.githubusercontent.com/Taif6612/DBMS_Project/main/docs/database_schema.png)

The system uses **MySQL** with the following core tables:

### User Tables
- `farmer_information` - Farmer profiles and credentials
- `buyer_information` - Buyer accounts
- `supplier_information` - Supplier details
- `analysist_information` - Market analyst accounts

### Crop & Inventory Tables
- `crop_information_per_farmer` - Crop details (name, season)
- `crop_farmer_zone_warehouse_info` - Warehouse delivery records
- `analysis_data_for_crops` - Historical price data

### Transaction Tables
- `order_details` - Buyer orders
- `order_crop_relationship` - Order line items
- `supply_info` - Supplier purchases
- `supply_crop_details` - Supply line items

### System Tables
- `warehouse` - Warehouse zones and capacity
- `recommendation` - Monthly crop recommendations with weather conditions

### Key Relationships
- Farmers → Crops (One-to-Many)
- Crops → Warehouses (Many-to-Many through `crop_farmer_zone_warehouse_info`)
- Buyers → Orders → Crops (Many-to-Many)
- Suppliers → Supply Orders → Crops (Many-to-Many)
- Analysts → Price Data → Crops (Many-to-Many)

## 🚀 Installation

### Prerequisites
- **XAMPP** or **WAMP** (Apache + MySQL + PHP)
- **PHP** 7.4 or higher
- **MySQL** 5.7 or higher
- Modern web browser

### Setup Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Taif6612/DBMS_Project.git
   cd DBMS_Project
   ```

2. **Start XAMPP/WAMP**
   - Start Apache and MySQL services

3. **Import Database**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`)
   - Create a new database named `farmsmart`
   - Import `database/farmsmart .sql`

4. **Configure Database Connection**
   - Update database credentials in PHP files if needed:
     ```php
     $conn = mysqli_connect("localhost", "root", "", "farmsmart");
     ```

5. **Access the Application**
   - Place the project in `htdocs` (XAMPP) or `www` (WAMP)
   - Navigate to: `http://localhost/DBMS_Project/Market Information System/Login_CreateAcc/login.php`

### Default Test Credentials

| User Type | User ID | Password |
|-----------|---------|----------|
| Farmer | usr_675751e9653fb | 11111 |
| Buyer | usr_675753a18e399 | 11111 |
| Supplier | usr_67615176228ae | 11111 |
| Analyst | usr_675767fe76dad | 11111 |

## 📖 Usage

### Farmer Workflow
1. Login with farmer credentials
2. Navigate to "Post Crops" to register new crops
3. Use "Deliver In warehouse" to submit crops with pricing
4. View price analytics on the dashboard
5. Check seasonal recommendations for crop planning

### Buyer Workflow
1. Login as a buyer
2. Browse available products from warehouses
3. Add items to cart and place orders
4. Select payment method (BKash, Nogod, Rocket, or Hand Cash)
5. Track orders in "My Product" section

### Admin Workflow
1. Access admin panel
2. Manage users across all roles
3. Create and configure warehouse zones
4. Update monthly crop recommendations
5. Monitor system analytics and user distribution

## 🛠️ Technologies Used

### Backend
- **PHP** - Server-side scripting
- **MySQL** - Relational database management
- **phpMyAdmin** - Database administration

### Frontend
- **HTML5** - Structure
- **CSS3** - Styling with custom themes
- **JavaScript** - Client-side interactivity
- **Bootstrap 4.5.2** - Responsive design framework
- **Font Awesome 6.0** - Icons

### Development Tools
- **XAMPP/WAMP** - Local development environment
- **Git** - Version control

## 📊 Database Statistics

- **11 Tables** with normalized relationships
- **Foreign Key Constraints** for data integrity
- **Sample Data** included for testing
- **Supports** multiple payment methods and warehouse zones

## 🎯 Future Enhancements

- [ ] Real-time chat between farmers and buyers
- [ ] Mobile application (Android/iOS)
- [ ] Payment gateway integration
- [ ] Advanced analytics with ML-based price prediction
- [ ] Multi-language support
- [ ] Email/SMS notifications for orders
- [ ] GPS-based warehouse location tracking

## 👨‍💻 Contributors

This project was developed as part of a university Database Management Systems course.

## 📄 License

This project is developed for educational purposes as part of a university DBMS course.

---

**Note**: This is an academic project demonstrating database design, normalization, and web application development principles.

For questions or issues, please open an issue in the repository.
