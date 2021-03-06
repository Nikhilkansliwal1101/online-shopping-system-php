SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS online DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE online;

INSERT INTO admin (adminid, `name`, mobile, email, `password`) VALUES
(1, 'Nikhil kansliwal', '9521176040', 'nikhilkansliwal1101@gmail.com', '$2y$10$luWjP40.88rXC8sE.K5qYukCXikcYMR4DIHJXdXWHdFFGMXKw9pJq'),
(2, 'Akhil kansliwal', '9461001760', 'akhilkansliwal2010@gmail.com', '$2y$10$OKZvOdkH5gI5VmCKuAqweOl0j66LTCOgLi1lWgcR72pf8zZwMLiHa');

INSERT INTO carousel (id, clable, cdisc, image) VALUES
(1, 'Grand Offer', 'Shop and Save up to 20%', 'GrandOffer.jpg'),
(2, 'Grocery Offer', 'Get Great deals on your daily needs', 'GroceryOffer.jpg'),
(3, 'Great Offer', 'Get best deals on beauty and grooming products', 'GreatOffer.jpg');

INSERT INTO category (catid, catname, catdesc, image) VALUES
(2, 'Grocery Item', 'Get your daily needs at your house', 'GroceryItem.jpg'),
(3, 'Snacks', 'Get namkeen, noodels and many more for snacks.', 'Snacks.jfif'),
(4, 'Drinks and Beverages', 'Stay hyderated and beat the heat.', 'SoftDrinks.jfif'),
(6, 'Beauty and Body care', 'Get Branded body care product at best prices.', 'Beauty.jfif'),
(7, 'Stationery', 'Get all type of books and notebooks at your doorstep.', 'Stationery.jfif'),
(12, 'Havan and Pujan Samagri', 'All type of yagya and pujan samgri at best price', 'HavanandPujanSamagri.jfif'),
(19, 'Organic Store', 'Get fresh and organic fruits and vegies', 'OrganicStore.jfif');

INSERT INTO customer (custid, `name`, email, `password`, mobile, address, city, state, pincode, `date`) VALUES
(1, 'Nikhil kansliwal', 'nikhilkansliwal1101@gmail.com', '$2y$10$59LljXS0HBJY2watoskRfOPaZ0avJ93sqa7LeBSOy9rWVABc85PoO', '9461001760', 'near manoharpur gate , shahpura', 'Jaipur', 'Rajasthan', 303103, '2021-03-16 17:55:51'),
(8, 'Ishika khandelwal', 'ishikakhan1901@gmail.com', '$2y$10$6bBV0YES2Me2ix/nw.RyY.YyPbPz6GQN4zrLzrNn/KZ5Fn.JQKktm', '7627062104', '10-A panchvati, near kamla nehru nagar, ', 'jaipur', 'Rajasthan', 302006, '2021-03-17 19:07:11'),
(9, 'Akhil kansliwal', 'akhilkansliwal2010@gmail.com', '$2y$10$7ZzND2FGZ4n4R2JG6U06hOqZxl0Dahe0EyQq44pBcWiXB0E/JFh8S', '9587176033', 'near manoharpur gate shahpura', 'jaipur', 'Rajasthan', 303103, '2021-03-18 19:09:25'),
(15, 'Nikhil', '', '$2y$10$scgYQdq6NCRRlqozCPjq5O0mRErHxytRNMdGehhjaUODJinOByYLG', '', 'near manoharpur gate', 'Jaipur', 'Rajasthan', 303103, '2021-05-15 16:08:05'),
(19, 'Naman', '', '$2y$10$scgYQdq6NCRRlqozCPjq5O0mRErHxytRNMdGehhjaUODJinOByYLG', '1254125412', 'Near manoharpur gate', 'Jaipur', 'Rajasthan', 303103, '2021-05-15 19:47:44'),
(20, 'Mr. Nikhil kansliwal', 'nikhilkansliwal112011@gmail.com', '$2y$10$0yENehqXGAZQv01owtr2neQbyh7qhGuNU1s7Ehld8cADuaitNbTZq', '9521176040', 'Near manoharpur gate, ward no 10, shahpura', 'Jaipur', 'Rajasthan', 303103, '2021-05-17 21:31:24');

INSERT INTO orderdiscription (orderid, productno, pname, quantity, cgst, sgst, mrp, sellprice, purchaseprice, supplierid, paymentid) VALUES
(1, 23, '14521452145212', 12, 12, 12, 145, 145, 120, 1, 17),
(7, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 17),
(7, 12, 'Bikaji Bhujia 400 Gm ', 2, 5, 5, 120, 85, 76, 1, 17),
(7, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(7, 14, 'Basmati Rice 1kg', 1, 5, 5, 120, 90, 70, 1, 17),
(9, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 17),
(9, 12, 'Bikaji Bhujia 400 Gm ', 2, 5, 5, 120, 85, 76, 1, 17),
(9, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(9, 14, 'Basmati Rice 1kg', 1, 5, 5, 120, 90, 70, 1, 17),
(10, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 17),
(10, 12, 'Bikaji Bhujia 400 Gm ', 2, 5, 5, 120, 85, 76, 1, 17),
(10, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(10, 14, 'Basmati Rice 1kg', 1, 5, 5, 120, 90, 70, 1, 17),
(11, 11, 'Boroplus 200Gm', 5, 12, 12, 123, 120, 100, 1, 17),
(11, 12, 'Bikaji Bhujia 400 Gm ', 2, 5, 5, 120, 85, 76, 1, 17),
(11, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 3, 5, 5, 90, 70, 58, 1, 17),
(11, 14, 'Basmati Rice 1kg', 3, 5, 5, 120, 90, 70, 1, 17),
(12, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(12, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 90, 70, 1, 17),
(13, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 17),
(13, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(13, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 5, 5, 5, 90, 70, 58, 1, 17),
(13, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 90, 70, 1, 17),
(14, 11, 'Boroplus 200Gm', 5, 12, 12, 123, 120, 100, 1, 17),
(14, 12, 'Bikaji Bhujia 400 Gm ', 3, 5, 5, 120, 85, 76, 1, 17),
(15, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(15, 12, 'Bikaji Bhujia 400 Gm ', 3, 5, 5, 120, 85, 76, 1, 17),
(15, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(15, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 90, 70, 1, 17),
(16, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(16, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(16, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(17, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(17, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(17, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(18, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(18, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(18, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(19, 11, 'Boroplus 200Gm', 4, 12, 12, 123, 120, 100, 1, 17),
(19, 12, 'Bikaji Bhujia 400 Gm ', 6, 5, 5, 120, 85, 76, 1, 17),
(19, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 15, 5, 5, 90, 70, 58, 1, 17),
(20, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(20, 12, 'Bikaji Bhujia 400 Gm ', 3, 5, 5, 120, 85, 76, 1, 17),
(20, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 3, 5, 5, 90, 70, 58, 1, 17),
(21, 11, 'Boroplus 200Gm', 20, 12, 12, 123, 120, 100, 1, 17),
(21, 12, 'Bikaji Bhujia 400 Gm ', 23, 5, 5, 120, 85, 76, 1, 17),
(21, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 10, 5, 5, 90, 70, 58, 1, 17),
(22, 11, 'Boroplus 200Gm', 5, 12, 12, 123, 120, 100, 1, 17),
(22, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(22, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 3, 5, 5, 90, 70, 58, 1, 17),
(23, 11, 'Boroplus 200Gm', 14, 12, 12, 123, 120, 100, 1, 17),
(23, 12, 'Bikaji Bhujia 400 Gm ', 9, 5, 5, 120, 85, 76, 1, 17),
(23, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 5, 5, 5, 90, 70, 58, 1, 17),
(25, 14, 'Basmati Rice 1kg', 1, 5, 5, 120, 90, 70, 1, 17),
(29, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(29, 12, 'Bikaji Bhujia 400 Gm ', 1, 5, 5, 120, 85, 76, 1, 17),
(29, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(30, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(30, 12, 'Bikaji Bhujia 400 Gm ', 1, 5, 5, 120, 85, 76, 1, 17),
(30, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(31, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(31, 12, 'Bikaji Bhujia 400 Gm ', 1, 5, 5, 120, 85, 76, 1, 17),
(31, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(33, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(34, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(36, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(36, 12, 'Bikaji Bhujia 400 Gm ', 1, 5, 5, 120, 85, 76, 1, 17),
(36, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 1, 5, 5, 90, 70, 58, 1, 17),
(37, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 17),
(37, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(38, 11, 'Boroplus 200Gm', 6, 12, 12, 123, 120, 100, 1, 17),
(38, 12, 'Bikaji Bhujia 400 Gm ', 6, 5, 5, 120, 85, 76, 1, 17),
(38, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 7, 5, 5, 90, 70, 58, 1, 17),
(39, 11, 'Boroplus 200Gm', 3, 12, 12, 123, 120, 100, 1, 17),
(39, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(39, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 4, 5, 5, 90, 70, 58, 1, 17),
(40, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 17),
(41, 11, 'Boroplus 200Gm', 5, 12, 12, 123, 120, 100, 1, 17),
(41, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 16, 5, 5, 90, 70, 58, 1, 17),
(42, 11, 'Boroplus 200Gm', 12, 12, 12, 123, 120, 100, 1, 17),
(42, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 85, 76, 1, 17),
(43, 14, 'Basmati Rice 1kg', 6, 5, 5, 120, 90, 70, 1, 17),
(44, 13, 'Chana dal 1000 Gm HJBHJKSBAHBVHJ', 5, 5, 5, 90, 70, 58, 1, 17),
(44, 14, 'Basmati Rice 1kg', 6, 5, 5, 120, 90, 70, 1, 17),
(46, 13, 'Chana dal 1000 Gm', 3, 5, 5, 90, 70, 58, 1, 17),
(46, 14, 'Basmati Rice 1kg', 5, 5, 5, 120, 90, 70, 1, 17),
(47, 11, 'Boroplus 200Gm', 15, 12, 12, 123, 120, 100, 1, 17),
(47, 12, 'Bikaji Bhujia 400 Gm ', 21, 5, 5, 120, 85, 76, 1, 17),
(47, 13, 'Chana dal 1000 Gm', 8, 5, 5, 90, 70, 58, 1, 17),
(48, 13, 'Chana dal 1000 Gm', 2, 5, 5, 90, 70, 58, 1, 17),
(48, 14, 'Basmati Rice 1kg', 2, 5, 5, 120, 90, 70, 1, 17),
(49, 13, 'Chana dal 1000 Gm', 8, 5, 5, 90, 70, 58, 1, 17),
(49, 14, 'Basmati Rice 1kg', 21, 5, 5, 120, 90, 70, 1, 17),
(55, 11, 'Boroplus 200Gm', 25, 10, 10, 100, 125, 90, 1, 18),
(64, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 18),
(65, 11, 'Boroplus 200Gm', 1, 12, 12, 123, 120, 100, 1, 18),
(66, 11, 'Boroplus 200Gm', 4, 12, 12, 123, 120, 100, 1, 20),
(66, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 90, 76, 1, 20),
(66, 13, 'Chana dal 1000 Gm', 4, 5, 5, 90, 80, 68, 2, 19),
(66, 14, 'Basmati Rice 1kg', 7, 5, 5, 120, 100, 70, 2, 19),
(66, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 4, 5, 5, 145, 145, 120, 2, 19),
(66, 16, 'maggi 400gm', 4, 5, 5, 46, 46, 42, 1, 20),
(67, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, 20),
(67, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 90, 76, 1, 20),
(67, 13, 'Chana dal 1000 Gm', 2, 5, 5, 90, 70, 68, 2, 19),
(67, 14, 'Basmati Rice 1kg', 5, 5, 5, 120, 100, 70, 2, 19),
(67, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 5, 5, 5, 145, 145, 120, 2, 19),
(67, 16, 'maggi 400gm', 7, 5, 5, 46, 46, 42, 1, 20),
(69, 11, 'Boroplus 200Gm', 6, 12, 12, 123, 120, 100, 1, 22),
(69, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 90, 76, 1, 22),
(69, 13, 'Chana dal 1000 Gm', 3, 5, 5, 90, 80, 68, 2, 21),
(69, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 3, 5, 5, 145, 145, 120, 2, 21),
(69, 16, 'maggi 400gm', 3, 5, 5, 46, 46, 42, 1, 22),
(70, 13, 'Chana dal 1000 Gm', 6, 5, 5, 90, 80, 68, 2, 21),
(70, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 3, 5, 5, 145, 145, 120, 2, 21),
(70, 16, 'maggi 400gm', 3, 5, 5, 46, 46, 42, 1, 22),
(71, 11, 'Boroplus 200Gm', 12, 12, 12, 123, 120, 100, 1, 22),
(71, 12, 'Bikaji Bhujia 400 Gm ', 5, 5, 5, 120, 90, 76, 1, 22),
(71, 13, 'Chana dal 1000 Gm', 5, 5, 5, 90, 80, 68, 2, 21),
(71, 14, 'Basmati Rice 1kg', 10, 5, 5, 120, 100, 70, 2, 21),
(71, 16, 'maggi 400gm', 7, 5, 5, 46, 46, 42, 1, 22),
(72, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(72, 12, 'Bikaji Bhujia 400 Gm ', 6, 5, 5, 120, 90, 76, 1, 22),
(72, 13, 'Chana dal 1000 Gm', 5, 10, 10, 120, 100, 100, 2, 21),
(72, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(72, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 5, 5, 5, 145, 145, 120, 2, 21),
(72, 18, 'maggi 400gm', 6, 12, 12, 115, 110, 102, 1, 22),
(73, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(73, 12, 'Bikaji Bhujia 400 Gm ', 4, 5, 5, 120, 90, 76, 1, 22),
(73, 13, 'Chana dal 1000 Gm', 5, 10, 10, 120, 100, 100, 2, 21),
(73, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(73, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 5, 5, 5, 145, 145, 120, 2, 21),
(73, 18, 'maggi 400gm', 6, 12, 12, 115, 110, 102, 1, 22),
(74, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(74, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(74, 18, 'maggi 400gm', 6, 12, 12, 115, 110, 102, 1, 22),
(75, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(75, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(75, 18, 'maggi 400gm', 2, 12, 12, 115, 110, 102, 1, 22),
(76, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(76, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(77, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(77, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(78, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(78, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(79, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(79, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(80, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(80, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(81, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(81, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(82, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(82, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(83, 11, 'Boroplus 200Gm', 7, 12, 12, 123, 120, 100, 1, 22),
(83, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(84, 11, 'Boroplus 200Gm', 17, 12, 12, 123, 120, 100, 1, 22),
(84, 14, 'Basmati Rice 1kg', 4, 5, 5, 120, 100, 70, 2, 21),
(85, 11, 'Boroplus 200Gm', 2, 12, 12, 123, 120, 100, 1, NULL),
(85, 12, 'Bikaji Bhujia 400 Gm ', 3, 5, 5, 120, 90, 76, 1, NULL),
(85, 14, 'Basmati Rice 1kg', 3, 5, 5, 120, 100, 70, 2, NULL),
(85, 18, 'maggi 400gm', 4, 12, 12, 125, 120, 108, 1, NULL),
(86, 12, 'Bikaji Bhujia 400 Gm ', 2, 5, 5, 120, 90, 76, 1, NULL),
(86, 14, 'Basmati Rice 1kg', 10, 5, 5, 120, 100, 70, 2, NULL),
(86, 15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 3, 5, 5, 145, 145, 120, 2, NULL),
(86, 18, 'maggi 400gm', 2, 12, 12, 125, 120, 108, 1, NULL);

INSERT INTO orders (orderid, custid, orderdate, `status`, deliverydate, amount) VALUES
(1, 9, '2021-04-06 20:32:39', 'com', '2021-04-07', 0),
(2, 9, '2021-04-06 21:14:54', 'com', '2021-04-07', 0),
(3, 9, '2021-04-06 21:16:00', 'com', '2021-04-13', 0),
(5, 9, '2021-04-06 21:17:35', 'com', '2021-04-07', 0),
(6, 9, '2021-04-06 21:18:21', 'com', '2021-04-08', 0),
(7, 9, '2021-04-06 21:21:47', 'com', '2021-04-08', 0),
(9, 9, '2021-04-06 21:28:44', 'com', '2021-04-07', 0),
(10, 9, '2021-04-06 21:30:32', 'com', '2021-04-08', 0),
(11, 9, '2021-04-07 22:28:50', 'com', '2021-04-08', 0),
(12, 9, '2021-04-08 18:13:49', 'com', '2021-04-09', 0),
(13, 9, '2021-04-09 19:34:04', 'com', '2021-04-09', 0),
(14, 9, '2021-05-09 16:29:41', 'com', '2021-05-09', 0),
(15, 9, '2021-05-09 16:46:49', 'com', '2021-05-09', 0),
(16, 1, '2021-05-09 22:57:56', 'com', '2021-05-11', 0),
(17, 1, '2021-05-09 22:58:07', 'com', '2021-05-09', 0),
(18, 1, '2021-05-09 22:58:48', 'com', '2021-05-10', 0),
(19, 1, '2021-05-10 18:35:07', 'com', '2021-05-15', 0),
(20, 1, '2021-05-10 19:02:03', 'com', '2021-05-15', 0),
(21, 1, '2021-05-11 16:34:22', 'com', '2021-05-17', 0),
(22, 1, '2021-05-11 16:35:53', 'com', '2021-05-15', 0),
(23, 1, '2021-05-11 16:36:54', 'com', '2021-05-11', 0),
(24, 1, '2021-05-11 16:39:10', 'com', '2021-05-15', 0),
(25, 1, '2021-05-11 16:40:43', 'com', '2021-05-15', 0),
(29, 15, '2021-05-15 16:17:44', 'com', '2021-05-15', 0),
(30, 15, '2021-05-15 16:18:12', 'com', '2021-05-22', 0),
(31, 15, '2021-05-15 16:20:44', 'com', '2021-05-15', 0),
(33, 15, '2021-05-15 19:28:07', 'com', '2021-06-01', 0),
(34, 15, '2021-05-15 19:31:42', 'com', '2021-05-15', 0),
(36, 19, '2021-05-15 19:47:44', 'com', '2021-05-15', 0),
(37, 9, '2021-05-17 18:03:36', 'com', '2021-05-22', 0),
(38, 1, '2021-05-17 18:16:29', 'com', '2021-05-17', 0),
(39, 1, '2021-05-17 19:15:49', 'com', '2021-05-24', 0),
(40, 1, '2021-05-17 19:18:53', 'com', '2021-05-22', 0),
(41, 20, '2021-05-17 21:34:06', 'com', '2021-05-24', 0),
(42, 1, '2021-05-18 19:43:15', 'com', '2021-05-24', 0),
(43, 1, '2021-05-22 16:57:06', 'com', '2021-05-24', 0),
(44, 1, '2021-05-22 21:32:37', 'com', '2021-06-01', 0),
(45, 1, '2021-05-23 21:16:10', 'com', '2021-06-01', 0),
(46, 1, '2021-05-24 20:00:32', 'com', '2021-05-24', 0),
(47, 20, '2021-05-24 22:12:59', 'com', '2021-06-01', 0),
(48, 1, '2021-05-28 18:07:09', 'com', '2021-06-01', 0),
(49, 9, '2021-05-28 21:45:53', 'com', '2021-05-28', 0),
(50, 1, '2021-06-01 16:08:36', 'com', '2021-06-01', 0),
(51, 1, '2021-06-01 16:17:02', 'com', '2021-06-01', 0),
(52, 1, '2021-06-01 16:19:41', 'com', '2021-06-01', 0),
(53, 1, '2021-06-01 16:23:04', 'com', '2021-06-01', 0),
(54, 1, '2021-06-01 16:23:47', 'com', '2021-06-01', 0),
(55, 1, '2021-06-01 16:24:43', 'com', '2021-06-01', 0),
(56, 1, '2021-06-01 16:25:14', 'com', '2021-06-01', 0),
(57, 1, '2021-06-01 16:30:01', 'com', '2021-06-01', 0),
(58, 1, '2021-06-01 16:30:58', 'com', '2021-06-01', 0),
(59, 1, '2021-06-01 16:32:30', 'com', '2021-06-01', 0),
(60, 1, '2021-06-01 16:33:42', 'com', '2021-06-01', 0),
(61, 1, '2021-06-01 16:34:44', 'com', '2021-06-01', 0),
(62, 1, '2021-06-01 16:35:36', 'com', '2021-06-03', 0),
(63, 1, '2021-06-01 16:36:43', 'com', '2021-06-03', 0),
(64, 1, '2021-06-01 16:39:53', 'com', '2021-06-22', 0),
(65, 1, '2021-06-01 16:41:37', 'com', '2021-06-22', 0),
(66, 1, '2021-06-01 16:44:55', 'com', '2021-06-22', 0),
(67, 9, '2021-06-01 18:40:57', 'com', '2021-06-22', 0),
(68, 1, '2021-06-02 13:40:55', 'com', '2021-06-22', 0),
(69, 1, '2021-06-02 13:41:36', 'com', '2021-06-22', 0),
(70, 1, '2021-06-03 20:11:46', 'com', '2021-06-22', 0),
(71, 1, '2021-06-03 20:12:23', 'com', '2021-06-22', 0),
(72, 1, '2021-06-22 19:23:08', 'com', '2021-06-22', 3665),
(73, 1, '2021-06-22 19:23:14', 'com', '2021-06-22', 3485),
(74, 1, '2021-06-22 19:23:16', 'com', '2021-06-22', 1900),
(75, 1, '2021-06-22 19:23:16', 'com', '2021-06-22', 1460),
(76, 1, '2021-06-22 19:23:17', 'com', '2021-06-22', 1240),
(77, 1, '2021-06-22 19:23:17', 'com', '2021-06-22', 1240),
(78, 1, '2021-06-22 19:23:17', 'com', '2021-06-22', 1240),
(79, 1, '2021-06-22 19:23:17', 'com', '2021-06-22', 1240),
(80, 1, '2021-06-22 19:23:18', 'com', '2021-06-22', 1240),
(81, 1, '2021-06-22 19:23:18', 'com', '2021-06-22', 1240),
(82, 1, '2021-06-22 19:23:18', 'notcom', NULL, 1240),
(83, 1, '2021-06-22 19:23:21', 'notcom', NULL, 1240),
(84, 1, '2021-06-22 19:28:52', 'notcom', NULL, 2440),
(85, 1, '2021-06-22 21:59:20', 'notcom', NULL, 0),
(86, 1, '2021-06-23 19:22:21', 'notcom', NULL, 1855);

INSERT INTO payment (paymentid, supplierid, amount, `date`, paid, collected) VALUES
(17, 1, 34330, '2021-06-01 12:44:09', '2021-06-01 12:44:32', '2021-06-01 13:08:30'),
(18, 1, 2450, '2021-06-01 16:42:46', '2021-06-01 22:33:44', '2021-06-01 22:33:48'),
(19, 2, 2328, '2021-06-01 18:43:09', '2021-06-22 19:31:49', '2021-06-22 19:31:41'),
(20, 1, 1670, '2021-06-01 22:33:59', '2021-06-22 19:31:59', '2021-06-22 19:31:42'),
(21, 2, 8212, '2021-06-22 19:31:28', '2021-06-22 19:31:55', '2021-06-22 19:31:43'),
(22, 1, 15930, '2021-06-22 19:31:32', '2021-06-22 19:31:54', '2021-06-22 19:31:44');

INSERT INTO product (productno, productid, image, subcatid, available, purchaseprice, mrp, sellprice, offer, cgst, sgst, sold, supplierid) VALUES
(11, 'Boroplus 200Gm', 'Boroplus200Gm.jfif', 20, 755, 100, 123, 120, 'Buy 1 get 1 free', 12, 12, 146, 1),
(12, 'Bikaji Bhujia 400 Gm ', 'BikajiBhujia400Gm.jfif', 7, 5, 76, 120, 90, 'Get upto 20% Off', 5, 5, 34, 1),
(13, 'Chana dal 1000 Gm', 'Chanadal1000GmHJBHJKSBAHBVHJ.jfif', 38, 10, 100, 120, 100, '', 10, 10, 40, 2),
(14, 'Basmati Rice 1kg', 'BasmatiRice1kg.jfif', 4, 45, 70, 120, 100, '', 5, 5, 118, 2),
(15, 'sdfsdgdfhfdhfgjgf fgnjnfsshrhf frhtnjfgjserjhtjtsjreher erhhrh', 'sdfsdgdfhfdhfgjgffgnjnfsshrhffrhtnjfgjserjhtjtsjrehererhhrh.jfif', 4, 7, 120, 145, 145, 'dsgsd', 5, 5, 38, 2),
(18, 'maggi 400gm', 'maggi400gm.jfif', 8, 4, 108, 125, 120, '', 12, 12, 26, 1);

INSERT INTO subcategory (subcatid, `name`, catid, image) VALUES
(1, 'Fresh Fruits', 19, 'Fruits.jfif'),
(2, 'Organic Vegetables', 19, 'Vegetables.jfif'),
(3, 'Atta and more', 2, 'Atta.jfif'),
(4, 'Rice', 3, 'Rice.jfif'),
(6, 'Dry Fruits', 3, 'DryFruits.jfif'),
(7, 'Namkeens', 3, 'Namkeen.jfif'),
(8, 'Pasta and Noodles', 3, 'PastaAndNoodles.jfif'),
(9, 'Biscuits and Cookies', 3, 'BisckitsAndCookies.jfif'),
(10, 'Tea and Coffee', 4, 'TeaAndCoffee.jfif'),
(11, 'Cold Drinks', 4, 'ColdDrinks.jfif'),
(12, 'Health Drinks', 4, 'HealthDrinks.jfif'),
(13, 'Jucies', 4, 'Jucies.jfif'),
(14, 'Liquid Detergent', 2, 'LiquidDetergent.jfif'),
(15, 'Detergent Powder', 2, 'DetergentPowder.jfif'),
(16, 'Broom and Mops', 2, 'BroomAndMops.jfif'),
(18, 'Man Grooming Products', 6, 'ManGroomingProducts.jfif'),
(19, 'Female Beauty and Wellness', 6, 'FemaleBeautyAndWellness.jfif'),
(20, 'General Care ', 6, 'GeneralCare.jfif'),
(22, 'Dish wash', 2, 'Dishwash.jfif'),
(23, 'Body wash products', 2, 'Bodywashproducts.jfif'),
(24, 'Msale', 6, 'Msale.jfif'),
(25, 'Textbooks', 7, 'Textbooks.jfif'),
(26, 'Notebooks', 7, 'Notebooks.jfif'),
(27, 'Other Stationery ', 7, 'OtherStationery.jpg'),
(28, 'Books', 7, 'Books.jfif'),
(32, 'Sugar and Sweeteners', 3, 'SugarandSweeteners.jfif'),
(33, 'Sagahar', 2, 'Sagahar.jfif'),
(38, 'Dal and Pulse', 2, 'DalandPulse.jfif');

INSERT INTO supplier (supplierid, `name`, mobile, email, `password`) VALUES
(1, 'Nikhil kansliwal', '9461001760', 'nikhilkansliwal1101@gmail.com', '$2y$10$luWjP40.88rXC8sE.K5qYukCXikcYMR4DIHJXdXWHdFFGMXKw9pJq'),
(2, 'Akhil kansliwal', '9521176040', 'akhilkansliwal2010@gmail.com', '$2y$10$OKZvOdkH5gI5VmCKuAqweOl0j66LTCOgLi1lWgcR72pf8zZwMLiHa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
