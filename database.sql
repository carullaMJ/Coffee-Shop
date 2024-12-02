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
    accountID int, Foreign key(accountID) references accounts(accountID)
    position varchar(50),
);

--Product table
CREATE TABLE products (
    productID int Primary key AUTO_INCREMENT,
    ProductName varchar(100),
    price numeric,
    availability boolean,
    date_created TIMESTAMP
);

--Order table
CREATE TABLE orders (
    orderID int Primary key AUTO_INCREMENT,
    quantity int,
    totalAmount numeric,
    payment numeric,
    change numeric,
    date_created TIMESTAMP
);

--Customer table
CREATE TABLE customers (
    customerID int Primary key AUTO_INCREMENT,
    name varchar(100),
    description varchar(100),
    date_created TIMESTAMP
);

--Delete Logs table
CREATE TABLE delete_log (
    del_logID int Primary key AUTO_INCREMENT,
    tableName varchar(50),
    id int,
    date_deleted TIMESTAMP
);
