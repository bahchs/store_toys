-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 28, 2024 lúc 04:41 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `storetoy`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(25) NOT NULL,
  `brand_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_img`) VALUES
(1, 'Lego', 'Assets/image/lego2.png'),
(2, 'Ania', 'Assets/image/ania.png'),
(3, 'Rubik', 'Assets/image/rubik.png'),
(4, 'Dream Girl', 'Assets/image/dreamgirl.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(20, 2, 1, 3),
(25, 2, 15, 2),
(28, 1, 1, 2),
(29, 1, 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Lego'),
(2, 'Đồ chơi trí tuệ'),
(3, 'Thế giới động vật'),
(4, 'Búp bê');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_money` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_money`, `order_date`, `note`) VALUES
(2, 2, 1700000, '2023-12-01', 'giao nhanh'),
(3, 1, 60000, '2024-04-04', 'a'),
(4, 1, 60000, '2024-04-03', 'a'),
(5, 1, 310000, '2024-04-24', 'aa'),
(6, 1, 310000, '2024-04-18', 'bcd'),
(7, 1, 310000, '2024-04-11', 'ooo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `total_price`) VALUES
(1, 2, 1, 2, 120000),
(2, 2, 5, 1, 50000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `product_img` varchar(50) NOT NULL,
  `product_sex` varchar(11) NOT NULL,
  `product_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_img`, `product_sex`, `product_price`) VALUES
(1, 3, 2, 'Chim cánh cụt', 'Assets/image/canhcut.png', 'Unisex', 60000),
(2, 1, 1, 'Cảnh sát lego', 'Assets/image/canhsatlego.jpg', 'Nam', 250000),
(3, 3, 2, 'Báo săn mồi', 'Assets/image/conbao.png', 'Unisex', 50000),
(4, 1, 1, 'Con quay ninja-go', 'Assets/image/conquayninja.jpg', 'Nam', 80000),
(5, 3, 2, 'Con voi', 'Assets/image/convoi.png', 'Unisex', 50000),
(6, 1, 1, 'Khỉ-lego', 'Assets/image/khilego.jpg', 'Nam', 150000),
(7, 1, 1, 'Rồng lửa ninjago', 'Assets/image/rongluaninja.png', 'Nam', 150000),
(8, 3, 2, 'Sử tử', 'Assets/image/sutu.png', 'Unisex', 50000),
(9, 1, 1, 'Xe tăng lego', 'Assets/image/xetanglego.jpg', 'Nam', 250000),
(10, 2, 3, 'Rubik 3x3', 'Assets/image/rubikgan.png', 'Unisex', 850000),
(11, 2, 3, 'Rubik 4x4', 'Assets/image/rubik4x4.png', 'Unisex', 80000),
(12, 2, 3, 'Rubik tam giác', 'Assets/image/rubiktamgiac.png', 'Unisex', 75000),
(13, 2, 3, 'Rubik Megaminx', 'Assets/image/rubikmeaminx.png', 'Unisex', 149000),
(14, 4, 4, 'Búp bê gia đình', 'Assets/image/bupbegiadinh.png', 'Nữ', 320000),
(15, 4, 4, 'Búp bê công chúa', 'Assets/image/congchua.png', 'Nữ', 120000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `fullname` varchar(25) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sex` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fullname`, `phone`, `address`, `sex`, `email`, `role`) VALUES
(1, 'admin', '123456', 'Hải Lê', '0938413412', 'Triều Khúc, Hà Nội', 'Nam', 'haido123@gmail.com', 1),
(2, 'user', '567890', 'Báchh', '0984372445', 'Thanh Oai, Hà Nội', 'Nam', 'bach@gmail.com', 0),
(9, 'abcd', '123456', 'Thắng', '0938413538', 'Triều Khúc, Hà Nội', 'Nam', 'thang123@gmail.com', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
