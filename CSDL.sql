-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th3 07, 2021 lúc 04:16 AM
-- Phiên bản máy phục vụ: 8.0.18
-- Phiên bản PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_super` int(11) NOT NULL DEFAULT '0',
  `birth` date NOT NULL DEFAULT '2021-01-22',
  `ngay_tao_tai_khoan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '""',
  `photo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image.jpg',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `is_super`, `birth`, `ngay_tao_tai_khoan`, `phone`, `address`, `photo`, `is_lock`, `is_delete`) VALUES
(1, 'binhbuivan', 'binhb479@gmail.com', '$2a$12$g8Bdco8AKMRVpjXMqrf4eeAw2QYM0xQVpjqSCJR2UMDOwWtIRupU6', 0, '2011-01-19', '2021-02-23 08:22:18', '0832672005', 'Trường Đại học Công nghệ Đông Á', 'image.jpg', 0, 0),
(2, 'khoithongminh', 'khoithongminh@gmail.com', '$2y$10$fGlVBNDjsGrEqDmO.A/kwul96sTXvTpew4fCvyyv4NDRPUYvhnCdK', 0, '2011-01-02', '2021-02-23 08:40:51', '0905305928', '38 đường 101', 'beed13602b9b0e6ecb5b568ff5058f07.jpg', 0, 0),
(3, 'kk', 'kk@gmail.com', '$2y$10$WvzmFR8DijPQ36F/d4SXfu/bXhKZnprnMKpju6oONfqIEw/zvTxjK', 0, '2021-01-22', '2021-02-27 15:28:29', '0123456789', '38 đường 102', 'c7e1249ffc03eb9ded908c236bd1996d.jpg', 0, 0),
(4, 'kkk', 'kkk@gmail.com', '$2y$10$xWUDeQQELEboXBShpPyL1u94JfAPl5a60wG.VuQNWQp0BMHTs1C2a', 0, '2021-01-22', '2021-02-27 16:04:37', '0', '\"\"', 'image.jpg', 0, 0),
(5, 'kkkk', 'kkkk@gmail.com', '$2y$10$9KyJCZ6jDH3rrTvE6qNXxe78s1YXIeq67hl94ptUJg8/Hi68WITuy', 0, '2021-01-22', '2021-02-27 16:24:27', '0', '\"\"', 'image.jpg', 0, 0),
(6, 'sa', 'sa@gmail.com', '$2y$10$LrfwRL3MmAnQ7wiyP2z2dep4VTjhC/K4vTE8EzEdBhwQoEBe81Nq2', 0, '2021-01-01', '2021-02-27 16:54:55', '0909374062', 'dfwefwe', 'undefined', 0, 0),
(7, 'sb', 'sb@gmail.com', '$2y$10$FRUYsAblBRbjH60NZDf6ZeEVvjwqrjFXUvx.RUFpIh9EADLHr7wRS', 0, '2021-01-22', '2021-02-27 17:03:09', '025345', 'rêggerg', '5a4b25aaed25c2ee1b74de72dc03c14e.jpg', 0, 0),
(8, 'a', 'a@gmail.com', '123456', 0, '2011-01-02', '2021-02-27 19:04:36', '01234567894', '38 đường 101', '04ecb1fa28506ccb6f72b12c0245ddbc.jpg', 0, 0),
(9, 'admin', 'admin@gmail.com', '$2y$10$cqQ62EO9nEqd7rNz0vJKl.hckDx/nAxQx7xp8Q5HH3wUEU/BGV4z.', 0, '2021-01-22', '2021-03-05 18:50:22', '0909374065', 'Sa Đéc, Long An', 'f4b9ec30ad9f68f89b29639786cb62ef.jpg', 0, 0),
(10, 'khương', 'khuong@gmail.com', '$2y$10$HIk2rBXuAodUKQ9utpD97eoNeY1/8Nv6a.zaWrQ4L.W/JqYavjzSi', 0, '2021-01-22', '2021-03-07 10:57:39', '0', '\"\"', 'image.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluanadmins`
--

DROP TABLE IF EXISTS `binhluanadmins`;
CREATE TABLE IF NOT EXISTS `binhluanadmins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `san_pham_id` int(10) UNSIGNED NOT NULL,
  `noi_dung_binh_luan` text COLLATE utf8_unicode_ci NOT NULL,
  `thoi_gian_binh_luan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `san_pham_id` (`san_pham_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluans`
--

DROP TABLE IF EXISTS `binhluans`;
CREATE TABLE IF NOT EXISTS `binhluans` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noi_dung_binh_luan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `san_pham_id` int(10) UNSIGNED NOT NULL,
  `thoi_gian_binh_luan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `binhluans_user_id_foreign` (`user_id`),
  KEY `san_pham_id` (`san_pham_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluans`
--

INSERT INTO `binhluans` (`id`, `noi_dung_binh_luan`, `user_id`, `san_pham_id`, `thoi_gian_binh_luan`, `created_at`, `updated_at`) VALUES
(5, 'cái này dở quá', 2, 23, '2021-03-03 11:10:04', NULL, NULL),
(6, 'are you sure ?', 2, 23, '2021-03-03 15:20:44', NULL, NULL),
(7, 'cai nay tot qua', 2, 23, '2021-03-03 15:27:17', NULL, NULL),
(8, 'cai nay hay qua', 2, 23, '2021-03-03 15:27:40', NULL, NULL),
(9, 'good job man ?', 2, 26, '2021-03-03 15:41:17', NULL, NULL),
(11, 'Dạ cho em hỏi cái này còn hàng không dzậy ?', 3, 23, '2021-03-04 16:19:26', NULL, NULL),
(12, 'Ok chất lượng tốt quá', 3, 24, '2021-03-04 16:19:47', NULL, NULL),
(13, 'Ok xài ngon đấy', 4, 24, '2021-03-04 17:13:22', NULL, NULL),
(14, 'ok =)))', 4, 26, '2021-03-04 17:15:08', NULL, NULL),
(15, 'Ok chất lượng tốt quá', 5, 22, '2021-03-04 17:23:53', NULL, NULL),
(16, 'Giao hàng như rùa =(((((', 5, 23, '2021-03-04 17:29:43', NULL, NULL),
(18, 'kaiba not ok ....', 6, 26, '2021-03-04 17:39:23', NULL, NULL),
(19, 'Tốt cái gì mà tốt', 6, 22, '2021-03-04 17:46:01', NULL, NULL),
(20, 'ok cái này xịn xò đây.', 6, 31, '2021-03-04 17:47:10', NULL, NULL),
(21, '5 sao', 6, 31, '2021-03-04 17:47:38', NULL, NULL),
(22, 'ok', 6, 23, '2021-03-04 17:49:26', NULL, NULL),
(23, 'hahahah', 6, 23, '2021-03-04 17:49:33', NULL, NULL),
(25, 'Good smartphone', 11, 26, '2021-03-07 09:28:28', NULL, NULL),
(26, 'Cái này xài tốt lắm!!!', 12, 23, '2021-03-07 10:52:04', NULL, NULL),
(27, 'Good điện thoại =)))', 12, 26, '2021-03-07 10:52:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadons`
--

DROP TABLE IF EXISTS `chitiethoadons`;
CREATE TABLE IF NOT EXISTS `chitiethoadons` (
  `hoa_don_id` int(10) UNSIGNED NOT NULL,
  `san_pham_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hoa_don_id`,`san_pham_id`),
  KEY `chitiethoadons_san_pham_id_foreign` (`san_pham_id`),
  KEY `chitiethoadons_hoa_don_id_foreign` (`hoa_don_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadons`
--

INSERT INTO `chitiethoadons` (`hoa_don_id`, `san_pham_id`, `so_luong`, `don_gia`, `created_at`, `updated_at`) VALUES
(7, 23, 1, 9000000, NULL, NULL),
(7, 38, 1, 15000000, NULL, NULL),
(7, 42, 1, 120000, NULL, NULL),
(8, 22, 4, 8000000, NULL, NULL),
(8, 23, 4, 9000000, NULL, NULL),
(9, 42, 1, 120000, NULL, NULL),
(9, 43, 1, 150000, NULL, NULL),
(9, 44, 1, 200000, NULL, NULL),
(10, 28, 1, 12500000, NULL, NULL),
(10, 29, 1, 10500000, NULL, NULL),
(11, 25, 1, 11000000, NULL, NULL),
(11, 26, 1, 12000000, NULL, NULL),
(11, 47, 1, 499998, NULL, NULL),
(12, 45, 1, 180000, NULL, NULL),
(12, 46, 1, 300000, NULL, NULL),
(13, 35, 1, 12000000, NULL, NULL),
(14, 43, 3, 150000, NULL, NULL),
(15, 34, 1, 800000, NULL, NULL),
(16, 27, 1, 14500000, NULL, NULL),
(17, 43, 1, 150000, NULL, NULL),
(17, 44, 2, 200000, NULL, NULL),
(18, 24, 1, 10000000, NULL, NULL),
(19, 25, 1, 11000000, NULL, NULL),
(19, 26, 1, 12000000, NULL, NULL),
(20, 25, 1, 11000000, NULL, NULL),
(21, 38, 1, 15000000, NULL, NULL),
(21, 39, 1, 11000000, NULL, NULL),
(22, 28, 2, 12500000, NULL, NULL),
(23, 31, 1, 5500000, NULL, NULL),
(24, 46, 1, 300000, NULL, NULL),
(25, 38, 1, 15000000, NULL, NULL),
(26, 44, 1, 200000, NULL, NULL),
(27, 32, 1, 1500000, NULL, NULL),
(28, 41, 1, 19000000, NULL, NULL),
(34, 28, 1, 12500000, NULL, NULL),
(34, 29, 3, 10500000, NULL, NULL),
(35, 23, 1, 9000000, NULL, NULL),
(37, 23, 1, 9000000, NULL, NULL),
(38, 28, 1, 12500000, NULL, NULL),
(38, 30, 1, 8500000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgias`
--

DROP TABLE IF EXISTS `danhgias`;
CREATE TABLE IF NOT EXISTS `danhgias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `san_pham_id` int(10) UNSIGNED NOT NULL,
  `muc_do_danh_gia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `san_pham_id` (`san_pham_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadons`
--

DROP TABLE IF EXISTS `hoadons`;
CREATE TABLE IF NOT EXISTS `hoadons` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `dia_chi_nhan_hang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_nguoi_nhan` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai_nhan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tinh_trang_thanh_toan` tinyint(4) NOT NULL DEFAULT '0',
  `phuong_thuc_thanh_toan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `ghi_chu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai_don_hang` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_confirm',
  `ngay_tao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadons`
--

INSERT INTO `hoadons` (`id`, `user_id`, `dia_chi_nhan_hang`, `ten_nguoi_nhan`, `so_dien_thoai_nhan`, `tinh_trang_thanh_toan`, `phuong_thuc_thanh_toan`, `ghi_chu`, `trang_thai_don_hang`, `ngay_tao`, `created_at`, `updated_at`) VALUES
(7, 2, '36 đường 102 phường Thạnh Mỹ Lợi quận 2', NULL, NULL, 1, 'cod', NULL, 'pending_confirm', '2021-03-01 16:47:45', NULL, NULL),
(8, 2, '36 đường 102 phường Thạnh Mỹ Lợi quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 11:32:24', NULL, NULL),
(9, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 1, 'cod', NULL, 'pending_confirm', '2021-03-04 16:22:17', NULL, NULL),
(10, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:02:56', NULL, NULL),
(11, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 1, 'cod', NULL, 'pending_confirm', '2021-03-04 17:03:28', NULL, NULL),
(12, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 1, 'cod', NULL, 'pending_confirm', '2021-03-04 17:04:22', NULL, NULL),
(13, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:04:53', NULL, NULL),
(14, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:05:41', NULL, NULL),
(15, 3, 'Phường Bình Trưng Tây quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:05:59', NULL, NULL),
(16, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:12:29', NULL, NULL),
(17, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:12:54', NULL, NULL),
(18, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:13:44', NULL, NULL),
(19, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:14:05', NULL, NULL),
(20, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:15:28', NULL, NULL),
(21, 4, 'Phường Thảo Điền Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:16:21', NULL, NULL),
(22, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:22:18', NULL, NULL),
(23, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:22:33', NULL, NULL),
(24, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:22:50', NULL, NULL),
(25, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:23:06', NULL, NULL),
(26, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:23:34', NULL, NULL),
(27, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:24:39', NULL, NULL),
(28, 5, 'Phường An Phú Quận 2', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-04 17:28:55', NULL, NULL),
(34, 11, 'Cà Mau', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-07 09:29:49', NULL, NULL),
(35, 11, 'Cà Mau', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-07 09:30:24', NULL, NULL),
(37, 12, 'Quận Nam Từ Liêm Hà Nội', NULL, NULL, 1, 'cod', NULL, 'pending_confirm', '2021-03-07 10:51:08', NULL, NULL),
(38, 12, 'Quận Nam Từ Liêm Hà Nội', NULL, NULL, 0, 'cod', NULL, 'pending_confirm', '2021-03-07 10:51:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanphams`
--

DROP TABLE IF EXISTS `loaisanphams`;
CREATE TABLE IF NOT EXISTS `loaisanphams` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_loai_san_pham` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `da_xoa` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanphams`
--

INSERT INTO `loaisanphams` (`id`, `ten_loai_san_pham`, `da_xoa`, `created_at`, `updated_at`) VALUES
(16, 'phone', 0, '2021-02-28 10:57:24', NULL),
(17, 'laptop', 0, '2021-02-28 10:57:37', NULL),
(18, 'mouse', 0, '2021-02-28 10:57:55', NULL),
(19, 'desktop', 0, '2021-02-28 10:58:06', NULL),
(20, 'watch', 0, '2021-02-28 10:59:01', NULL),
(24, 'game', 1, '2021-03-07 02:53:08', NULL),
(25, 'gaming', 1, '2021-03-07 02:53:19', NULL),
(26, 'game 234', 1, '2021-03-07 03:04:33', NULL),
(27, 'fwa', 1, '2021-03-07 03:15:10', NULL),
(28, 'Phụ kiện khác 123', 1, '2021-03-07 03:53:47', NULL),
-- =============================
-- Danh mục mới (da_xoa = 0)
-- =============================
(29, 'Linh kiện máy tính', 0, CURRENT_TIMESTAMP, NULL),
(30, 'Màn hình máy tính', 0, CURRENT_TIMESTAMP, NULL),
(31, 'Phụ kiện công nghệ', 0, CURRENT_TIMESTAMP, NULL),
(32, 'Phụ kiện điện thoại', 0, CURRENT_TIMESTAMP, NULL),
(33, 'Thiết bị mạng', 0, CURRENT_TIMESTAMP, NULL),
(34, 'Gaming Gear', 0, CURRENT_TIMESTAMP, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphams`
--

DROP TABLE IF EXISTS `sanphams`;
CREATE TABLE IF NOT EXISTS `sanphams` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_san_pham` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `loai_san_pham_id` int(10) UNSIGNED NOT NULL,
  `mo_ta_san_pham` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` int(11) NOT NULL,
  `hinh_anh` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `ngay_dang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `da_xoa` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sanphams_admin_id_foreign` (`admin_id`),
  KEY `loai_san_pham_id` (`loai_san_pham_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanphams`
--

INSERT INTO `sanphams` (`id`, `ten_san_pham`, `admin_id`, `loai_san_pham_id`, `mo_ta_san_pham`, `so_luong`, `don_gia`, `hinh_anh`, `ngay_dang`, `da_xoa`, `created_at`, `updated_at`) VALUES
(22, 'phone 1', 9, 16, 'phone 1 phone 1 phone 1 phone 1 phone 1 phone 1 phone 1', 22, 8000000, '443cb001c138b2561a0d90720d6ce111.jpg', '2021-02-28 18:15:34', 0, NULL, NULL),
(23, 'phone 2', 9, 16, 'phone 2 phone 2 phone 2 phone 2 phone 2 phone 2 phone 2', 13, 9000000, '51d92be1c60d1db1d2e5e7a07da55b26.jpg', '2021-02-28 18:16:13', 0, NULL, NULL),
(24, 'phone 3', 8, 16, 'phone 3 phone 3 phone 3 phone 3 phone 3 phone 3 phone 3', 5, 10000000, '950a4152c2b4aa3ad78bdd6b366cc179.jpg', '2021-02-28 18:17:06', 0, NULL, NULL),
(25, 'phone 4', 8, 16, 'phone 4 phone 4 phone 4 phone 4 phone 4 phone 4 phone 4', 5, 11000000, '3ad7c2ebb96fcba7cda0cf54a2e802f5.png', '2021-02-28 18:17:51', 0, NULL, NULL),
(26, 'phone 5', 8, 16, 'phone 5 phone 5 phone 5 phone 5 phone 5 phone 5 phone 5', 4, 12000000, '2b24d495052a8ce66358eb576b8912c8.jpg', '2021-02-28 18:18:40', 0, NULL, NULL),
(27, 'laptop 1', 8, 17, 'laptop 1 laptop 1 laptop 1 laptop 1 laptop 1 laptop 1 laptop 1', 5, 14500000, '1ecfb463472ec9115b10c292ef8bc986.jpg', '2021-02-28 18:24:16', 0, NULL, NULL),
(28, 'laptop 2', 8, 17, 'laptop 2 laptop 2 laptop 2 laptop 2 laptop 2 laptop 2 laptop 2', 6, 12500000, 'e1e32e235eee1f970470a3a6658dfdd5.jpg', '2021-02-28 18:25:07', 0, NULL, NULL),
(29, 'laptop 3', 8, 17, 'laptop 3 laptop 3 laptop 3 laptop 3 laptop 3 laptop 3 laptop 3', 4, 10500000, 'a516a87cfcaef229b342c437fe2b95f7.jpg', '2021-02-28 18:26:16', 0, NULL, NULL),
(30, 'laptop 4', 8, 17, 'laptop 4 laptop 4 laptop 4 laptop 4 laptop 4 laptop 4 laptop 4', 5, 8500000, '788d986905533aba051261497ecffcbb.jpg', '2021-02-28 18:27:01', 0, NULL, NULL),
(31, 'laptop 5', 8, 17, 'laptop 5 laptop 5 laptop 5 laptop 5 laptop 5 laptop 5 laptop 5', 3, 5500000, '16a5cdae362b8d27a1d8f8c7b78b4330.jpg', '2021-02-28 18:27:52', 0, NULL, NULL),
(32, 'watch 1', 8, 20, 'watch 1 watch 1 watch 1 watch 1 watch 1 watch 1 watch 1', 4, 1500000, '13fe9d84310e77f13a6d184dbf1232f3.jpg', '2021-02-28 18:29:18', 0, NULL, NULL),
(33, 'watch 2', 8, 20, 'watch 2 watch 2 watch 2 watch 2 watch 2 watch 2 watch 2', 5, 2300000, '3b5dca501ee1e6d8cd7b905f4e1bf723.jpg', '2021-02-28 18:30:07', 0, NULL, NULL),
(34, 'watch 3', 8, 20, 'watch 3 watch 3 watch 3 watch 3 watch 3 watch 3 watch 3', 12, 800000, '698d51a19d8a121ce581499d7b701668.jpg', '2021-02-28 18:30:52', 0, NULL, NULL),
(35, 'watch 4', 8, 20, 'watch 4 watch 4 watch 4 watch 4 watch 4 watch 4 watch 4', 3, 12000000, '996a7fa078cc36c46d02f9af3bef918b.jpg', '2021-02-28 18:32:34', 0, NULL, NULL),
(36, 'watch 5', 8, 20, 'watch 4 watch 4 watch 4 watch 4 watch 4 watch 4 watch 4', 1, 12000000, 'b6edc1cd1f36e45daf6d7824d7bb2283.jpg', '2021-02-28 18:33:15', 0, NULL, NULL),
(37, 'desktop 1', 8, 19, 'desktop 1 desktop 1 desktop 1 desktop 1 desktop 1 desktop 1 desktop 1', 3, 9500000, '1f4477bad7af3616c1f933a02bfabe4e.jpg', '2021-02-28 18:35:35', 0, NULL, NULL),
(38, 'desktop 2', 8, 19, 'desktop 2 desktop 2 desktop 2 desktop 2 desktop 2 desktop 2 desktop 2', 7, 15000000, '109a0ca3bc27f3e96597370d5c8cf03d.jpg', '2021-02-28 18:36:21', 0, NULL, NULL),
(39, 'desktop 3', 8, 19, 'desktop 3 desktop 3 desktop 3 desktop 3 desktop 3 desktop 3 desktop 3', 3, 11000000, '812b4ba287f5ee0bc9d43bbf5bbe87fb.jpg', '2021-02-28 18:36:59', 0, NULL, NULL),
(40, 'desktop 4', 8, 19, 'desktop 4 desktop 4 desktop 4 desktop 4 desktop 4 desktop 4 desktop 4', 9, 18000000, '35cf8659cfcb13224cbd47863a34fc58.png', '2021-02-28 18:37:42', 0, NULL, NULL),
(41, 'desktop 5', 8, 19, 'desktop 5 desktop 5 desktop 5 desktop 5 desktop 5 desktop 5 desktop 5', 11, 19000000, 'f61d6947467ccd3aa5af24db320235dd.jpg', '2021-02-28 18:39:46', 0, NULL, NULL),
(42, 'mouse 1', 8, 18, 'mouse 1 mouse 1 mouse 1 mouse 1 mouse 1 mouse 1 mouse 1', 22, 120000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', '2021-02-28 18:40:37', 0, NULL, NULL),
(43, 'mouse 2', 8, 18, 'mouse 2 mouse 2 mouse 2 mouse 2 mouse 2 mouse 2 mouse 2', 1, 150000, '82aa4b0af34c2313a562076992e50aa3.jpg', '2021-02-28 18:41:10', 0, NULL, NULL),
(44, 'mouse 3', 8, 18, 'mouse 3 mouse 3 mouse 3 mouse 3 mouse 3 mouse 3 mouse 3', 5, 200000, 'bac9162b47c56fc8a4d2a519803d51b3.jpg', '2021-02-28 18:41:44', 0, NULL, NULL),
(45, 'mouse 4', 8, 18, 'mouse 4 mouse 4 mouse 4 mouse 4 mouse 4 mouse 4 mouse 4', 8, 180000, 'd34ab169b70c9dcd35e62896010cd9ff.jpg', '2021-02-28 18:42:21', 0, NULL, NULL),
(46, 'mouse 5', 8, 18, 'mouse 5 mouse 5 mouse 5 mouse 5 mouse 5 mouse 5 mouse 5', 22, 300000, 'd1c38a09acc34845c6be3a127a5aacaf.jpg', '2021-02-28 18:43:05', 0, NULL, NULL),
(50, 'samsum4', 9, 17, 'dbdfgdfgdg', 4, 4, '', '2021-03-07 10:34:11', 1, NULL, NULL),
(51, 'samsum galaxy note 12i', 9, 16, 'galaxy galaxy', 7, 20, '82f2b308c3b01637c607ce05f52a2fed.jpg', '2021-03-07 10:54:48', 1, NULL, NULL);

-- Sản phẩm bổ sung cho các danh mục mới
INSERT INTO `sanphams` (`id`, `ten_san_pham`, `admin_id`, `loai_san_pham_id`, `mo_ta_san_pham`, `so_luong`, `don_gia`, `hinh_anh`, `ngay_dang`, `da_xoa`, `created_at`, `updated_at`) VALUES
(52, 'RAM DDR4 8GB 3200MHz', 9, 29, 'RAM DDR4 bus 3200 phù hợp máy văn phòng và gaming.', 50, 450000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(53, 'SSD SATA 512GB', 9, 29, 'SSD 512GB tăng tốc khởi động hệ điều hành.', 40, 690000, '443cb001c138b2561a0d90720d6ce111.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(54, 'Nguồn 650W 80 Plus', 9, 29, 'Nguồn máy tính ổn định cho cấu hình phổ thông.', 25, 950000, '1f4477bad7af3616c1f933a02bfabe4e.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(55, 'Màn hình 24 inch IPS 75Hz', 9, 30, 'Màn hình viền mỏng cho học tập và làm việc.', 20, 2790000, '35cf8659cfcb13224cbd47863a34fc58.png', CURRENT_TIMESTAMP, 0, NULL, NULL),
(56, 'Màn hình 27 inch 2K 75Hz', 9, 30, 'Hiển thị sắc nét, phù hợp thiết kế và giải trí.', 15, 4990000, '812b4ba287f5ee0bc9d43bbf5bbe87fb.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(57, 'Hub USB-C 6 in 1', 9, 31, 'Hub mở rộng cổng kết nối cho laptop hiện đại.', 35, 490000, '16a5cdae362b8d27a1d8f8c7b78b4330.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(58, 'Sạc nhanh GaN 65W', 9, 31, 'Củ sạc nhanh nhỏ gọn, hỗ trợ laptop và điện thoại.', 40, 590000, '698d51a19d8a121ce581499d7b701668.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(59, 'Cáp Type-C bọc dù 1m', 9, 32, 'Cáp bền, sạc ổn định cho điện thoại Android.', 80, 59000, '2b24d495052a8ce66358eb576b8912c8.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(60, 'Ốp lưng chống sốc', 9, 32, 'Bảo vệ thiết bị khỏi va đập và trầy xước.', 50, 79000, '091d584fced301b442654dd8c23b3fc9.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(61, 'Router WiFi 6 AX1800', 9, 33, 'Router chuẩn WiFi 6 cho gia đình và văn phòng nhỏ.', 18, 1290000, '788d986905533aba051261497ecffcbb.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(62, 'Switch 8 port Gigabit', 9, 33, 'Bộ chia mạng 8 cổng phù hợp cửa hàng và lớp học.', 25, 490000, '82aa4b0af34c2313a562076992e50aa3.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(63, 'Chuột gaming RGB', 9, 34, 'Chuột gaming DPI cao với đèn RGB.', 45, 199000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(64, 'Bàn phím cơ TKL', 9, 34, 'Bàn phím cơ gọn gàng cho góc máy chơi game.', 20, 690000, '82f2b308c3b01637c607ce05f52a2fed.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(65, 'Tai nghe gaming mic rời', 9, 34, 'Tai nghe chơi game âm thanh rõ, mic thoại tốt.', 22, 490000, '51d92be1c60d1db1d2e5e7a07da55b26.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(66, 'Tản nhiệt khí tower 120mm', 9, 29, 'Tản nhiệt cho CPU chạy êm và ổn định.', 28, 320000, '26408ffa703a72e8ac0117e74ad46f33.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(67, 'Mainboard B560 mATX', 9, 29, 'Bo mạch chủ mATX phù hợp nhu cầu học tập và làm việc.', 16, 1890000, '1ecfb463472ec9115b10c292ef8bc986.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(68, 'Màn hình 24 inch 144Hz Gaming', 9, 30, 'Tần số quét cao cho chơi game và giải trí.', 12, 3890000, '109a0ca3bc27f3e96597370d5c8cf03d.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(69, 'Màn hình 32 inch cong 2K', 9, 30, 'Màn hình cong cho góc nhìn rộng và làm việc đa nhiệm.', 8, 6290000, 'f61d6947467ccd3aa5af24db320235dd.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(70, 'Pin dự phòng 20000mAh', 9, 31, 'Dung lượng lớn, hỗ trợ sạc nhanh PD/QC.', 30, 520000, '13fe9d84310e77f13a6d184dbf1232f3.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(71, 'Đế kê laptop nhôm', 9, 31, 'Thiết kế gọn nhẹ, tản nhiệt tốt cho laptop.', 24, 250000, '698d51a19d8a121ce581499d7b701668.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(72, 'Kính cường lực full màn', 9, 32, 'Bảo vệ màn hình điện thoại khỏi trầy xước.', 60, 49000, '950a4152c2b4aa3ad78bdd6b366cc179.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(73, 'Tai nghe Bluetooth TWS', 9, 32, 'Tai nghe không dây gọn nhẹ, pin bền.', 35, 390000, '2b24d495052a8ce66358eb576b8912c8.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(74, 'Bộ kích sóng WiFi', 9, 33, 'Mở rộng vùng phủ sóng cho gia đình nhiều tầng.', 30, 350000, '3b5dca501ee1e6d8cd7b905f4e1bf723.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(75, 'Camera IP trong nhà', 9, 33, 'Giám sát từ xa qua điện thoại, hình ảnh rõ nét.', 14, 790000, '35cf8659cfcb13224cbd47863a34fc58.png', CURRENT_TIMESTAMP, 0, NULL, NULL),
(76, 'Bàn di chuột gaming size L', 9, 34, 'Pad chuột bề mặt mịn, di chuột chính xác.', 26, 149000, 'bac9162b47c56fc8a4d2a519803d51b3.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL),
(77, 'Ghế gaming công thái học', 9, 34, 'Thiết kế ngồi lâu thoải mái cho game thủ.', 6, 2890000, '996a7fa078cc36c46d02f9af3bef918b.jpg', CURRENT_TIMESTAMP, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth` date NOT NULL DEFAULT '2021-01-22',
  `ngay_tao_tai_khoan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image.jpg',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birth`, `ngay_tao_tai_khoan`, `phone`, `address`, `photo`, `is_lock`, `is_delete`) VALUES
(1, 'binhbuivan', 'binhb479@gmail.com', '$2a$12$g8Bdco8AKMRVpjXMqrf4eeAw2QYM0xQVpjqSCJR2UMDOwWtIRupU6', '2021-01-22', '2021-02-24 14:24:56', '0832672005', 'Trường Đại học Công nghệ Đông Á', 'image.jpg', 0, 0),
(2, 'john', 'john@gmail.com', '$2y$10$HdrTO4qiPCd2GRfqXhtFyezHGhnNoFBeGpIhXxO6tMGdyySuSMcGC', '2000-04-17', '2021-02-28 11:00:36', '0904123456', '36 đường 102 phường Thạnh Mỹ Lợi quận 2', '8f53295a73878494e9bc8dd6c3c7104f.jpg', 0, 0),
(3, 'Cuong Nguyen', 'cuong@gmail.com', '$2y$10$9Xbb0dH26P6.QySwplP1ZOi85JVev6ydRt43j7mv5ImTOX1OsHm7a', '2021-01-22', '2021-03-04 16:06:28', '0905124728', 'Phường Bình Trưng Tây quận 2', 'ccc0aa1b81bf81e16c676ddb977c5881.jpg', 0, 0),
(4, 'kaiba_seto', 'kaiba@yahoo.com', '$2y$10$brt.L2DjP2OLJUgnqfN/0u9uVilITWZBlCWGHQGsg5nUieAiLDakK', '2021-01-22', '2021-03-04 17:10:59', '0909123321', 'Phường Thảo Điền Quận 2', 'bac9162b47c56fc8a4d2a519803d51b3.jpg', 0, 0),
(5, 'pikachu', 'pk@gmail.com', '$2y$10$i7uaMzy0UzZPl2fLG9.xhO/XRjF5cLNcDUt1a2LIlnP81tqzoqhaW', '2021-01-22', '2021-03-04 17:18:14', '0905432123', 'Phường An Phú Quận 2', 'd67d8ab4f4c10bf22aa353e27879133c.png', 0, 0),
(6, 'naruto_kun', 'na@gmail.com', '$2y$10$0pjGDyUzvOA/YqFE9EJH5eT15pmDaZ3L9yIrPww123amx.zmaeuPe', '2011-01-04', '2021-03-04 17:32:41', '0909129921', 'Thành phố Đà Lạt, tỉnh Lâm Đồng', '605ff764c617d3cd28dbbdd72be8f9a2.png', 0, 0),
(7, 'yugi', 'yugi@yahoo.com', '$2y$10$QfSiH715QT/lUZdnY9byjuvwSFYwg/CfZJjrLDsa2ABAV.9IS6rV6', '2021-01-22', '2021-03-05 21:13:59', '0908123451', '', 'image.jpg', 0, 0),
(8, 'honda', 'honda@yahoo.com', '$2y$10$Wzqj1Qnyno56ghTw5rIpu.MP3uXgoRXHhR/NVQF.J1M7bmgsrcdPC', '2021-01-22', '2021-03-05 21:17:57', '0909217862', '', 'image.jpg', 0, 0),
(9, 'honda_2', 'honda_2@yahoo.com', '$2y$10$8/W1iN3mVo8bBuTrXwux4.fAZ0h85EjdfJjEbsUpvuF.H8kRtZr6O', '2021-01-22', '2021-03-05 21:18:26', '0909217526', '', 'image.jpg', 0, 0),
(10, 'Ngoc Nguyen', 'ngoc@gmail.com', '$2y$10$M5vHb44oUTfJI0JnrMt7ae.c16TF9ttE.dTHi1mxswvFqusSqoEBa', '2021-01-22', '2021-03-05 21:27:37', '0907124572', '', 'image.jpg', 0, 0),
(11, 'Nguyễn Thị Linh', 'nguyenthilinh@gmail.com', '$2y$10$/7AA3fgG/bp5oFTEtuBqDukr4KJSgO8eB0FNQr.z1wQ/ZpBUEf5gS', '2001-01-02', '2021-03-07 09:25:38', '0912567712', 'Cà Mau', '96b9bff013acedfb1d140579e2fbeb63.jpg', 0, 0),
(12, 'Nguyễn Trí Cường', 'nguyentricuong@gmail.com', '$2y$10$Wus23MoxhEDldgghAOlQjeGTOCoDqmdCohGFoegE/lcv9E3DiWyhq', '2021-01-22', '2021-03-07 10:47:44', '0908123321', 'Quận Nam Từ Liêm Hà Nội', 'beed13602b9b0e6ecb5b568ff5058f07.jpg', 0, 0);


-- ============================================================
-- BỔ SUNG THÊM SẢN PHẨM CHO CÁC DANH MỤC (khoảng 10 sản phẩm/danh mục)
-- ============================================================
INSERT INTO `sanphams` (`id`, `ten_san_pham`, `admin_id`, `loai_san_pham_id`, `mo_ta_san_pham`, `so_luong`, `don_gia`, `hinh_anh`, `ngay_dang`, `da_xoa`, `created_at`, `updated_at`) VALUES
(78, 'phone 6', 9, 16, 'Điện thoại pin khỏe, màn đẹp, phù hợp học tập và giải trí.', 9, 13500000, 'f4b9ec30ad9f68f89b29639786cb62ef.jpg', NOW(), 0, NULL, NULL),
(79, 'phone 7', 9, 16, 'Điện thoại camera sắc nét, sạc nhanh.', 12, 14900000, 'c06d06da9666a219db15cf575aff2824.jpg', NOW(), 0, NULL, NULL),
(80, 'phone 8', 9, 16, 'Điện thoại thiết kế cao cấp, hiệu năng ổn định.', 8, 15900000, 'f2217062e9a397a1dca429e7d70bc6ca.jpg', NOW(), 0, NULL, NULL),
(81, 'phone 9', 9, 16, 'Điện thoại màn hình lớn, loa kép.', 10, 16900000, '950a4152c2b4aa3ad78bdd6b366cc179.jpg', NOW(), 0, NULL, NULL),
(82, 'phone 10', 9, 16, 'Điện thoại hỗ trợ 5G, chụp ảnh đẹp.', 7, 17900000, '443cb001c138b2561a0d90720d6ce111.jpg', NOW(), 0, NULL, NULL),
(83, 'laptop 6', 9, 17, 'Laptop văn phòng mỏng nhẹ, pin tốt.', 7, 15500000, '1ecfb463472ec9115b10c292ef8bc986.jpg', NOW(), 0, NULL, NULL),
(84, 'laptop 7', 9, 17, 'Laptop học tập, bàn phím êm, SSD nhanh.', 8, 16500000, 'e1e32e235eee1f970470a3a6658dfdd5.jpg', NOW(), 0, NULL, NULL),
(85, 'laptop 8', 9, 17, 'Laptop đồ họa cơ bản, màn hình đẹp.', 6, 17900000, 'a516a87cfcaef229b342c437fe2b95f7.jpg', NOW(), 0, NULL, NULL),
(86, 'laptop 9', 9, 17, 'Laptop gaming hiệu năng cao.', 5, 19500000, '788d986905533aba051261497ecffcbb.jpg', NOW(), 0, NULL, NULL),
(87, 'laptop 10', 9, 17, 'Laptop doanh nhân bền bỉ, bảo mật tốt.', 4, 21900000, '16a5cdae362b8d27a1d8f8c7b78b4330.jpg', NOW(), 0, NULL, NULL),
(88, 'mouse 6', 9, 18, 'Chuột không dây độ chính xác cao.', 30, 220000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', NOW(), 0, NULL, NULL),
(89, 'mouse 7', 9, 18, 'Chuột gaming LED RGB.', 25, 260000, '82aa4b0af34c2313a562076992e50aa3.jpg', NOW(), 0, NULL, NULL),
(90, 'mouse 8', 9, 18, 'Chuột văn phòng yên tĩnh.', 35, 180000, 'bac9162b47c56fc8a4d2a519803d51b3.jpg', NOW(), 0, NULL, NULL),
(91, 'mouse 9', 9, 18, 'Chuột thiết kế công thái học.', 18, 310000, 'd34ab169b70c9dcd35e62896010cd9ff.jpg', NOW(), 0, NULL, NULL),
(92, 'mouse 10', 9, 18, 'Chuột dual mode bluetooth/2.4G.', 16, 350000, 'd1c38a09acc34845c6be3a127a5aacaf.jpg', NOW(), 0, NULL, NULL),
(93, 'desktop 6', 9, 19, 'Máy bộ cấu hình cân bằng cho văn phòng.', 6, 12500000, '1f4477bad7af3616c1f933a02bfabe4e.jpg', NOW(), 0, NULL, NULL),
(94, 'desktop 7', 9, 19, 'PC học tập và giải trí cơ bản.', 7, 13900000, '109a0ca3bc27f3e96597370d5c8cf03d.jpg', NOW(), 0, NULL, NULL),
(95, 'desktop 8', 9, 19, 'PC gaming tầm trung tối ưu FPS.', 4, 18900000, '812b4ba287f5ee0bc9d43bbf5bbe87fb.jpg', NOW(), 0, NULL, NULL),
(96, 'desktop 9', 9, 19, 'PC dựng video cơ bản.', 3, 21500000, '35cf8659cfcb13224cbd47863a34fc58.png', NOW(), 0, NULL, NULL),
(97, 'desktop 10', 9, 19, 'Workstation mini dành cho kỹ thuật.', 2, 24900000, 'f61d6947467ccd3aa5af24db320235dd.jpg', NOW(), 0, NULL, NULL),
(98, 'watch 6', 9, 20, 'Đồng hồ thông minh theo dõi sức khỏe.', 14, 1850000, '13fe9d84310e77f13a6d184dbf1232f3.jpg', NOW(), 0, NULL, NULL),
(99, 'watch 7', 9, 20, 'Đồng hồ thông minh hỗ trợ cuộc gọi.', 11, 2450000, '3b5dca501ee1e6d8cd7b905f4e1bf723.jpg', NOW(), 0, NULL, NULL),
(100, 'watch 8', 9, 20, 'Smartwatch chống nước, pin 7 ngày.', 10, 2890000, '698d51a19d8a121ce581499d7b701668.jpg', NOW(), 0, NULL, NULL),
(101, 'watch 9', 9, 20, 'Đồng hồ thể thao GPS.', 8, 3290000, '996a7fa078cc36c46d02f9af3bef918b.jpg', NOW(), 0, NULL, NULL),
(102, 'watch 10', 9, 20, 'Đồng hồ cao cấp cho dân văn phòng.', 5, 3990000, 'b6edc1cd1f36e45daf6d7824d7bb2283.jpg', NOW(), 0, NULL, NULL),
(103, 'Mainboard B760M WiFi', 9, 29, 'Bo mạch chủ hỗ trợ DDR5 và WiFi.', 14, 2890000, '26408ffa703a72e8ac0117e74ad46f33.jpg', NOW(), 0, NULL, NULL),
(104, 'Case Mid Tower kính cường lực', 9, 29, 'Case thoáng khí, hỗ trợ nhiều fan.', 16, 890000, '1f4477bad7af3616c1f933a02bfabe4e.jpg', NOW(), 0, NULL, NULL),
(105, 'Ổ cứng SSD NVMe 1TB', 9, 29, 'SSD NVMe tốc độ cao cho PC/Laptop.', 22, 1490000, '443cb001c138b2561a0d90720d6ce111.jpg', NOW(), 0, NULL, NULL),
(106, 'Card mạng WiFi PCIe', 9, 29, 'Card WiFi cho máy tính để bàn.', 18, 420000, '82aa4b0af34c2313a562076992e50aa3.jpg', NOW(), 0, NULL, NULL),
(107, 'Keo tản nhiệt cao cấp', 9, 29, 'Keo tản nhiệt dùng cho CPU/GPU.', 40, 120000, 'd34ab169b70c9dcd35e62896010cd9ff.jpg', NOW(), 0, NULL, NULL),
(108, 'Màn hình 22 inch Full HD', 9, 30, 'Màn hình phổ thông cho học tập.', 16, 2290000, '109a0ca3bc27f3e96597370d5c8cf03d.jpg', NOW(), 0, NULL, NULL),
(109, 'Màn hình 27 inch 100Hz', 9, 30, 'Màn hình văn phòng viền mỏng.', 12, 4190000, '812b4ba287f5ee0bc9d43bbf5bbe87fb.jpg', NOW(), 0, NULL, NULL),
(110, 'Màn hình 29 inch Ultrawide', 9, 30, 'Màn hình ultrawide làm việc đa nhiệm.', 7, 5590000, '35cf8659cfcb13224cbd47863a34fc58.png', NOW(), 0, NULL, NULL),
(111, 'Màn hình 32 inch cong', 9, 30, 'Màn hình cong xem phim, chơi game.', 6, 6490000, 'f61d6947467ccd3aa5af24db320235dd.jpg', NOW(), 0, NULL, NULL),
(112, 'Màn hình 27 inch 165Hz', 9, 30, 'Màn hình gaming phản hồi nhanh.', 5, 7290000, '996a7fa078cc36c46d02f9af3bef918b.jpg', NOW(), 0, NULL, NULL),
(113, 'Webcam Full HD', 9, 31, 'Webcam học online và họp trực tuyến.', 25, 390000, '16a5cdae362b8d27a1d8f8c7b78b4330.jpg', NOW(), 0, NULL, NULL),
(114, 'Đế kê laptop nhôm', 9, 31, 'Đế kê laptop tản nhiệt tốt.', 18, 290000, '698d51a19d8a121ce581499d7b701668.jpg', NOW(), 0, NULL, NULL),
(115, 'Ổ cắm điện thông minh', 9, 31, 'Ổ cắm điều khiển qua app.', 20, 350000, '13fe9d84310e77f13a6d184dbf1232f3.jpg', NOW(), 0, NULL, NULL),
(116, 'Loa bluetooth mini', 9, 31, 'Loa nhỏ gọn, âm thanh rõ.', 17, 450000, '3b5dca501ee1e6d8cd7b905f4e1bf723.jpg', NOW(), 0, NULL, NULL),
(117, 'Bộ chuyển HDMI sang VGA', 9, 31, 'Phụ kiện kết nối màn hình tiện lợi.', 28, 150000, '82f2b308c3b01637c607ce05f52a2fed.jpg', NOW(), 0, NULL, NULL),
(118, 'Cáp sạc Lightning 1m', 9, 32, 'Cáp Lightning chống đứt gãy.', 42, 79000, '2b24d495052a8ce66358eb576b8912c8.jpg', NOW(), 0, NULL, NULL),
(119, 'Củ sạc nhanh 20W', 9, 32, 'Sạc nhanh cho điện thoại.', 38, 190000, '950a4152c2b4aa3ad78bdd6b366cc179.jpg', NOW(), 0, NULL, NULL),
(120, 'Giá đỡ điện thoại', 9, 32, 'Giá đỡ để bàn chắc chắn.', 50, 89000, '091d584fced301b442654dd8c23b3fc9.jpg', NOW(), 0, NULL, NULL),
(121, 'Tai nghe bluetooth TWS', 9, 32, 'Tai nghe không dây nhỏ gọn.', 26, 490000, '51d92be1c60d1db1d2e5e7a07da55b26.jpg', NOW(), 0, NULL, NULL),
(122, 'Quạt tản nhiệt điện thoại', 9, 32, 'Giảm nhiệt khi chơi game.', 20, 210000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', NOW(), 0, NULL, NULL),
(123, 'Router băng tần kép AC1200', 9, 33, 'Router phủ sóng gia đình ổn định.', 15, 890000, '788d986905533aba051261497ecffcbb.jpg', NOW(), 0, NULL, NULL),
(124, 'Router mesh 2 pack', 9, 33, 'Mesh mở rộng vùng phủ WiFi.', 9, 2290000, '82aa4b0af34c2313a562076992e50aa3.jpg', NOW(), 0, NULL, NULL),
(125, 'Switch 16 port', 9, 33, 'Switch mạng cho văn phòng nhỏ.', 11, 1190000, '3b5dca501ee1e6d8cd7b905f4e1bf723.jpg', NOW(), 0, NULL, NULL),
(126, 'Camera IP Wifi', 9, 33, 'Camera giám sát kết nối wifi.', 14, 750000, '82f2b308c3b01637c607ce05f52a2fed.jpg', NOW(), 0, NULL, NULL),
(127, 'Dây mạng Cat6 20m', 9, 33, 'Dây mạng bọc chống nhiễu.', 30, 160000, 'd1c38a09acc34845c6be3a127a5aacaf.jpg', NOW(), 0, NULL, NULL),
(128, 'Bàn phím cơ fullsize RGB', 9, 34, 'Bàn phím cơ gaming fullsize.', 12, 890000, '82f2b308c3b01637c607ce05f52a2fed.jpg', NOW(), 0, NULL, NULL),
(129, 'Tai nghe gaming 7.1', 9, 34, 'Tai nghe chơi game âm thanh vòm.', 15, 690000, '51d92be1c60d1db1d2e5e7a07da55b26.jpg', NOW(), 0, NULL, NULL),
(130, 'Lót chuột size lớn', 9, 34, 'Mousepad khổ lớn cho góc gaming.', 22, 220000, '3e89ebdb49f712c7d90d1b39e348bbbf.jpg', NOW(), 0, NULL, NULL),
(131, 'Ghế gaming công thái học', 9, 34, 'Ghế gaming tựa lưng êm ái.', 6, 3490000, '35cf8659cfcb13224cbd47863a34fc58.png', NOW(), 0, NULL, NULL),
(132, 'Tay cầm chơi game bluetooth', 9, 34, 'Tay cầm chơi game cho PC/mobile.', 19, 590000, '698d51a19d8a121ce581499d7b701668.jpg', NOW(), 0, NULL, NULL);

ALTER TABLE `sanphams` AUTO_INCREMENT=133;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluanadmins`
--
ALTER TABLE `binhluanadmins`
  ADD CONSTRAINT `binhluanadmins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binhluanadmins_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binhluanadmins_ibfk_3` FOREIGN KEY (`san_pham_id`) REFERENCES `sanphams` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `binhluans`
--
ALTER TABLE `binhluans`
  ADD CONSTRAINT `binhluans_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `sanphams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitiethoadons`
--
ALTER TABLE `chitiethoadons`
  ADD CONSTRAINT `chitiethoadons_ibfk_1` FOREIGN KEY (`hoa_don_id`) REFERENCES `hoadons` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `danhgias`
--
ALTER TABLE `danhgias`
  ADD CONSTRAINT `danhgias_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `sanphams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `danhgias_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `hoadons`
--
ALTER TABLE `hoadons`
  ADD CONSTRAINT `hoadons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanphams`
--
ALTER TABLE `sanphams`
  ADD CONSTRAINT `sanphams_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sanphams_ibfk_2` FOREIGN KEY (`loai_san_pham_id`) REFERENCES `loaisanphams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
