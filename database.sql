--database name
create database CoffeeShop;

--TABLES

--Account table
CREATE TABLE accounts (
    accountId int Primary key AUTO_INCREMENT,
    name varchar(100),
    username varchar(100),
    e_mail varchar(100),
    password varchar(255),
    position varchar(50),
    pin int;
    date_created TIMESTAMP
);

--Account Logs table
CREATE TABLE account_logs (
    logID int Primary key AUTO_INCREMENT,
    login_date TIMESTAMP,
    accountID int, 
    Foreign key(accountID) references accounts(accountID),
    position varchar(50),
    username varchar(100)
);

--Product table
CREATE TABLE products (
    productID int Primary key AUTO_INCREMENT,
    ProductName varchar(100),
    price numeric,
    availability varchar(16),
    date_created TIMESTAMP
);

--Order table
CREATE TABLE orders (
   orderID int Primary key AUTO_INCREMENT,
    customer_name varchar(50),
    quantity int,
    productID int,
    productName varchar(100),
    description varchar(100),
    is_served boolean,
    is_cancelled boolean,
    Foreign key(productID) references products(productID),
    date_created TIMESTAMP
); 
