-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2024 lúc 04:14 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_website_hhmusic`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin_logs`
--

CREATE TABLE `tbl_admin_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `actions` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin_logs`
--

INSERT INTO `tbl_admin_logs` (`id`, `admin_id`, `actions`, `details`, `created_at`) VALUES
(1, 1, 'Thêm thể loại', 'Thêm thể loại \'nhạc xịn pro\'', '2024-08-14'),
(2, 2, 'Thêm thể loại', 'Thêm thể loại \'nhạc không xịn\'', '2024-08-14'),
(3, 2, 'Xóa thể loại', 'Xóa thể loại \'nhac-chay\'', '2024-08-14'),
(4, 2, 'Xóa thể loại', 'Xóa thể loại \'nhạc không xịn\'', '2024-08-14'),
(5, 2, 'Xóa thể loại', 'Xóa thể loại \'nhạc hay\'', '2024-08-15'),
(6, 2, 'Xóa thể loại', 'Xóa thể loại \'nhạc pro\'', '2024-08-15'),
(7, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc xịn\'', '2024-08-15'),
(8, 1, 'Xóa thể loại', 'Xóa thể loại \'Sale 50%\'', '2024-08-15'),
(9, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc xịn pro\'', '2024-08-15'),
(10, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc hay abc\'', '2024-08-15'),
(11, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-08-15'),
(12, 1, 'Xóa thể loại', 'Xóa thể loại \'About\'', '2024-08-15'),
(13, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc huyền thoại\'', '2024-08-15'),
(14, 1, 'Thêm thể loại', 'Thêm thể loại \'nhạc xịn\'', '2024-08-15'),
(15, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc xịn\'', '2024-08-15'),
(16, 1, 'Thêm thể loại', 'Thêm thể loại \'nhạc đG\'', '2024-08-15'),
(17, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc đG\'', '2024-08-15'),
(18, 1, 'Thêm thể loại', 'Thêm thể loại \'nhac xóa\'', '2024-08-15'),
(19, 1, 'Xóa thể loại', 'Xóa thể loại \'nhac xóa\'', '2024-08-15'),
(20, 1, 'Thêm thể loại', 'Thêm thể loại \'nhạc xóa\'', '2024-08-15'),
(21, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc xóa\'', '2024-08-15'),
(22, 1, 'Thêm thể loại', 'Thêm thể loại \'nhạc xóa\'', '2024-08-15'),
(23, 1, 'Xóa thể loại', 'Xóa thể loại \'nhạc xóa\'', '2024-08-15'),
(24, 2, 'Thêm thể loại', 'Thêm thể loại \'nhạc xóa\'', '2024-08-15'),
(25, 2, 'Xóa thể loại', 'Xóa thể loại \'nhạc xóa\'', '2024-08-15'),
(26, 1, 'Sửa thể loại', 'Sửa thể loại \'Nhạc Rap\'', '2024-08-15'),
(27, 1, 'Thêm bài hát', 'Thêm bài hát \'Một Triệu Like\'', '2024-08-15'),
(28, 1, 'Sửa bài hát', 'Sửa bài hát \'Nợ nhau một lời\'', '2024-08-15'),
(29, 1, 'Xóa bài hát', 'Xóa bài hát \'Nợ nhau một lời\'', '2024-08-15'),
(30, 1, 'Xóa thể loại', 'Xóa thể loại \'my Playlist 2\'', '2024-08-16'),
(31, 1, 'Xóa thể loại', 'Xóa thể loại \'my Playlist 5\'', '2024-08-16'),
(32, 1, 'Xóa thể loại', 'Xóa thể loại \'my Playlist\'', '2024-08-16'),
(33, 1, 'Thêm người dùng', 'Thêm người dùng \'Minh Vương\'', '2024-08-16'),
(36, 1, 'Sửa thông tin người dùng', 'Sửa thông tin người dùng \'Sơn Tùng Mabc\'', '2024-08-16'),
(37, 1, 'Sửa thông tin người dùng', 'Sửa thông tin người dùng \'Sơn Tùng MTP\'', '2024-08-16'),
(38, 1, 'Sửa thông tin người dùng', 'Sửa thông tin người dùng \'văn huy\'', '2024-08-16'),
(39, 1, 'Thêm người dùng', 'Thêm người dùng \'Nguyễn Văn Anh\'', '2024-08-16'),
(40, 1, 'Thêm người dùng', 'Thêm người dùng \'Nguyễn Khánh Hà\'', '2024-08-16'),
(41, 1, 'Thêm Playlist', 'Thêm Playlist \'Nhạc Cổ Điển\'', '2024-08-16'),
(42, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc Chế Doraemon\'', '2024-08-16'),
(43, 1, 'Thêm thể loại', 'Thêm thể loại \'Hết Nhạc Con Về\'', '2024-08-16'),
(44, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc Cháy\'', '2024-08-16'),
(45, 1, 'Thêm thể loại', 'Thêm thể loại \'Hết Nhạc Con Về\'', '2024-08-16'),
(46, 1, 'Thêm Playlist', 'Thêm Playlist \'Hết nhạc con về\'', '2024-08-16'),
(47, 1, 'Thêm Playlist', 'Thêm Playlist \'Hết nhạc con về\'', '2024-08-16'),
(48, 1, 'Thêm Playlist', 'Thêm Playlist \'Nhạc cháy bay phòng\'', '2024-08-16'),
(49, 1, 'Sửa Playlist', 'Sửa Playlist \'Hết nhạc con về\'', '2024-08-16'),
(50, 1, 'Sửa Playlist', 'Sửa Playlist \'Hết nhạc con về\'', '2024-08-16'),
(51, 1, 'Thêm album', 'Thêm album \'Album 1\'', '2024-08-16'),
(52, 1, 'Thêm album', 'Thêm album \'Album 2\'', '2024-08-17'),
(53, 1, 'Thêm người dùng', 'Thêm người dùng \'Vũ Thị Tình\'', '2024-08-18'),
(54, 1, 'Thêm người dùng', 'Thêm người dùng \'Nguyễn Xuân Hiến\'', '2024-08-18'),
(55, 1, 'Thêm album', 'Thêm album \'Album 3\'', '2024-08-18'),
(56, 1, 'Sửa Album', 'Sửa Album \'Album 3\'', '2024-08-18'),
(57, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-08-18'),
(58, 1, 'Xóa album', 'Xóa album \'Album 2\'', '2024-08-18'),
(59, 1, 'Sửa Album', 'Sửa Album \'Album 1\'', '2024-08-18'),
(60, 1, 'Sửa Album', 'Sửa Album \'Album 1\'', '2024-08-18'),
(61, 1, 'Xóa album', 'Xóa album \'Album 1\'', '2024-08-18'),
(62, 1, 'Thêm banner', 'Thêm banner \'Banner Google\'', '2024-08-18'),
(63, 1, 'Thêm banner', 'Thêm banner \'Banner Google\'', '2024-08-18'),
(64, 1, 'Xóa banner', 'Xóa banner \'Banner Google\'', '2024-08-18'),
(65, 1, 'Thêm banner', 'Thêm banner \'Banner Google\'', '2024-08-18'),
(66, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner Google\'', '2024-08-18'),
(67, 1, 'Thêm Playlist', 'Thêm Playlist \'Nhạc phòng Bar\'', '2024-08-18'),
(68, 1, 'Thêm album', 'Thêm album \'Album 3\'', '2024-08-18'),
(69, 1, 'Thêm album', 'Thêm album \'Album 2\'', '2024-08-18'),
(70, 1, 'Sửa bài hát', 'Sửa bài hát \'Trống Cơm\'', '2024-08-19'),
(71, 1, 'Sửa bài hát', 'Sửa bài hát \'Trống Cơm\'', '2024-08-19'),
(72, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc Phim\'', '2024-09-05'),
(73, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc phim\'', '2024-09-05'),
(74, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc remix\'', '2024-09-05'),
(75, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc EDM\'', '2024-09-05'),
(76, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc đỏ\'', '2024-09-05'),
(77, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc chờ\'', '2024-09-05'),
(78, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(79, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(80, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(81, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(82, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(83, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(84, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(85, 1, 'Xóa thể loại', 'Xóa thể loại \'\'', '2024-09-05'),
(86, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc Trịnh\'', '2024-09-05'),
(87, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc bolero\'', '2024-09-05'),
(88, 1, 'Thêm người dùng', 'Thêm người dùng \'Karik\'', '2024-09-05'),
(89, 1, 'Thêm người dùng', 'Thêm người dùng \'DatKaa\'', '2024-09-05'),
(90, 1, 'Thêm người dùng', 'Thêm người dùng \'Đen Vâu\'', '2024-09-05'),
(91, 1, 'Sửa bài hát', 'Sửa bài hát \'Trống Cơm\'', '2024-09-05'),
(92, 1, 'Sửa bài hát', 'Sửa bài hát \'Một Triệu Like\'', '2024-09-05'),
(93, 1, 'Thêm bài hát', 'Thêm bài hát \'Đưa Nhau Đi Trốn (Đen Vâu ft. Linh Cáo)\'', '2024-09-05'),
(94, 1, 'Thêm bài hát', 'Thêm bài hát \'Bạn Đời (Karik ft. Gducky)\'', '2024-09-05'),
(95, 1, 'Thêm bài hát', 'Thêm bài hát \'Có sao cũng đành (DatKaa x Prod. QT Beatz)\'', '2024-09-05'),
(96, 1, 'Thêm bài hát', 'Thêm bài hát \'Lối Nhỏ (Đen Vâu ft. Phương Anh Đào)\'', '2024-09-05'),
(97, 1, 'Thêm bài hát', 'Thêm bài hát \'Lạc trôi\'', '2024-09-05'),
(98, 1, 'Thêm bài hát', 'Thêm bài hát \'Nơi này có anh\'', '2024-09-05'),
(99, 1, 'Thêm người dùng', 'Thêm người dùng \'Phan Mạnh Quỳnh\'', '2024-09-05'),
(100, 1, 'Thêm người dùng', 'Thêm người dùng \'Justatee\'', '2024-09-05'),
(101, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc balad\'', '2024-09-05'),
(102, 1, 'Thêm bài hát', 'Thêm bài hát \'Nhạt (Phan Mạnh Quỳnh)\'', '2024-09-05'),
(103, 1, 'Thêm bài hát', 'Thêm bài hát \'Thằng điên (Justatee ft Phương Ly)\'', '2024-09-05'),
(104, 1, 'Xóa thể loại', 'Xóa thể loại \'Nhạc Cổ Điển\'', '2024-09-05'),
(105, 1, 'Xóa thể loại', 'Xóa thể loại \'Hết nhạc con về\'', '2024-09-05'),
(106, 1, 'Xóa thể loại', 'Xóa thể loại \'Nhạc cháy bay phòng\'', '2024-09-05'),
(107, 1, 'Xóa thể loại', 'Xóa thể loại \'Nhạc phòng Bar\'', '2024-09-05'),
(108, 1, 'Thêm Playlist', 'Thêm Playlist \'Chill cùng Đen\'', '2024-09-05'),
(109, 1, 'Thêm Playlist', 'Thêm Playlist \'Balad cực chill\'', '2024-09-05'),
(110, 1, 'Thêm bài hát', 'Thêm bài hát \'Bài này chill phết\'', '2024-09-06'),
(111, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-06'),
(112, 1, 'Xóa album', 'Xóa album \'Album 3\'', '2024-09-06'),
(113, 1, 'Xóa album', 'Xóa album \'Album 3\'', '2024-09-06'),
(114, 1, 'Thêm album', 'Thêm album \'Cực chill cùng Đen\'', '2024-09-06'),
(115, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-06'),
(116, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-06'),
(117, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-06'),
(118, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-06'),
(119, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-06'),
(120, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-06'),
(121, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-06'),
(122, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-06'),
(123, 1, 'Sửa thông tin người dùng', 'Sửa thông tin người dùng \'Admin Huyến\'', '2024-09-07'),
(124, 1, 'Thêm thể loại', 'Thêm thể loại \'Nhạc Âu - Mỹ\'', '2024-09-10'),
(125, 1, 'Sửa bài hát', 'Sửa bài hát \'Nơi này có anh\'', '2024-09-10'),
(126, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-10'),
(127, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-10'),
(128, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-10'),
(129, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-10'),
(130, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đe\'', '2024-09-10'),
(131, 1, 'Sửa Album', 'Sửa Album \'Cực chill cùng Đen\'', '2024-09-10'),
(132, 1, 'Sửa Album', 'Sửa Album \'Album 2\'', '2024-09-10'),
(133, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner Google\'', '2024-09-12'),
(134, 1, 'Thêm banner', 'Thêm banner \'Banner2\'', '2024-09-12'),
(135, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner Google\'', '2024-09-12'),
(136, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner2\'', '2024-09-12'),
(137, 1, 'Sửa thông tin người dùng', 'Sửa thông tin người dùng \'Admin Huyến\'', '2024-09-12'),
(138, 1, 'Thêm banner', 'Thêm banner \'banner test\'', '2024-09-13'),
(139, 1, 'Xóa banner', 'Xóa banner \'banner test\'', '2024-09-13'),
(140, 1, 'Thêm banner', 'Thêm banner \'banner test\'', '2024-09-13'),
(141, 1, 'Thêm banner', 'Thêm banner \'banner test\'', '2024-09-13'),
(142, 1, 'Thêm banner', 'Thêm banner \'banner test\'', '2024-09-13'),
(143, 1, 'Thêm banner', 'Thêm banner \'Banner2\'', '2024-09-13'),
(144, 1, 'Xóa banner', 'Xóa banner \'banner test\'', '2024-09-13'),
(145, 1, 'Xóa banner', 'Xóa banner \'banner test\'', '2024-09-13'),
(146, 1, 'Xóa banner', 'Xóa banner \'banner test\'', '2024-09-13'),
(147, 1, 'Xóa banner', 'Xóa banner \'Banner2\'', '2024-09-13'),
(148, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner2\'', '2024-09-13'),
(149, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner Google\'', '2024-09-13'),
(150, 1, 'Thêm banner', 'Thêm banner \'banner test\'', '2024-09-13'),
(151, 1, 'Cập nhật banner', 'Cập nhật banner \'banner test\'', '2024-09-13'),
(152, 1, 'Cập nhật banner', 'Cập nhật banner \'banner test\'', '2024-09-13'),
(153, 1, 'Cập nhật banner', 'Cập nhật banner \'banner test\'', '2024-09-13'),
(154, 1, 'Thêm thể loại', 'Thêm thể loại \'\'', '2024-09-13'),
(155, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner Google\'', '2024-09-13'),
(156, 1, 'Cập nhật banner', 'Cập nhật banner \'Banner2\'', '2024-09-13'),
(157, 1, 'Sửa bài hát', 'Sửa bài hát \'Bạn Đời (Karik ft. Gducky)\'', '2024-09-14'),
(158, 1, 'Thêm banner', 'Thêm banner \'banner test 2\'', '2024-09-15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_album`
--

CREATE TABLE `tbl_album` (
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_image` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `privacy` varchar(10) DEFAULT 'public',
  `album_slug` varchar(255) NOT NULL,
  `listen_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_album`
--

INSERT INTO `tbl_album` (`album_id`, `user_id`, `album_name`, `album_image`, `description`, `privacy`, `album_slug`, `listen_count`) VALUES
(10, 18, 'Cực chill cùng Đen', 'bài này chill phết.jpg', '', 'public', 'cuc-chill-cung-den-18', 0),
(13, 1, 'Vui vẻ mỗi ngàt', 'album vui vẻ mỗi ngày.png', '', 'public', 'vui-ve-moi-ngat-1', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_album_song`
--

CREATE TABLE `tbl_album_song` (
  `album_song_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_album_song`
--

INSERT INTO `tbl_album_song` (`album_song_id`, `album_id`, `song_id`) VALUES
(6, 10, 5),
(7, 10, 6),
(8, 10, 9),
(9, 10, 14),
(10, 13, 16);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `banner_id` int(11) NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `pathway` varchar(255) NOT NULL,
  `display` varchar(10) NOT NULL DEFAULT 'hidden'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_banner`
--

INSERT INTO `tbl_banner` (`banner_id`, `banner_name`, `banner_image`, `pathway`, `display`) VALUES
(3, 'Banner Google', 'banner.jpg', 'https://www.google.com/', 'show'),
(4, 'Banner2', 'banner2.png', 'http://localhost/webmusic/index.php', 'show'),
(10, 'banner test', 'chup-anh-di-bien.jpg', 'https://www.google.com/', 'hidden'),
(11, 'banner test 2', 'quản lý bài hát.drawio.png', 'https://www.google.com/', 'hidden');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `slug`) VALUES
(1, 'Nhạc trẻ', 'nhac-tre'),
(2, 'Nhạc vàng', 'nhac-vang'),
(3, 'Nhạc phim', 'nhac-phim'),
(4, 'Nhạc remix', 'nhac-remix'),
(5, 'Nhạc Rap', 'nhac-rap'),
(6, 'Nhạc EDM', 'nhac-edm'),
(7, 'Nhạc đỏ', 'nhac-do'),
(8, 'Nhạc balad', 'nhac-balad'),
(14, 'Nhạc Âu - Mỹ', 'nhac-au-my'),
(15, 'Nhạc bolero', 'nhac-bolero');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_favorite`
--

CREATE TABLE `tbl_favorite` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_favorite`
--

INSERT INTO `tbl_favorite` (`favorite_id`, `user_id`, `song_id`) VALUES
(18, 1, 16),
(23, 1, 5),
(24, 1, 7),
(25, 14, 5),
(26, 14, 6),
(28, 1, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_follow`
--

CREATE TABLE `tbl_follow` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_follow`
--

INSERT INTO `tbl_follow` (`follow_id`, `follower_id`, `following_id`) VALUES
(1, 15, 4),
(2, 11, 10),
(6, 16, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_playlist`
--

CREATE TABLE `tbl_playlist` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug_playlist` varchar(255) NOT NULL,
  `listen_count` int(11) DEFAULT 0,
  `privacy` varchar(10) NOT NULL DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_playlist`
--

INSERT INTO `tbl_playlist` (`playlist_id`, `playlist_name`, `user_id`, `slug_playlist`, `listen_count`, `privacy`) VALUES
(11, 'Chill cùng Đen', 18, 'chill-cung-den-18', 0, 'public'),
(12, 'Balad cực chill', 1, 'balad-cuc-chill-1', 0, 'public'),
(14, 'Nhạc truyền cảm hứng', 1, 'nhac-truyen-cam-hung-1', 0, 'public');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_playlist_song`
--

CREATE TABLE `tbl_playlist_song` (
  `playlist_song_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_playlist_song`
--

INSERT INTO `tbl_playlist_song` (`playlist_song_id`, `playlist_id`, `song_id`) VALUES
(20, 11, 5),
(21, 11, 9),
(22, 11, 6),
(23, 12, 13),
(24, 12, 8),
(25, 12, 7),
(28, 12, 11),
(32, 12, 10),
(33, 12, 14),
(36, 12, 16),
(37, 12, 15),
(38, 14, 5),
(39, 14, 16),
(40, 14, 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_song`
--

CREATE TABLE `tbl_song` (
  `song_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `song_image` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `listen_count` int(11) DEFAULT 0,
  `lyrics` varchar(5000) DEFAULT NULL,
  `privacy` varchar(10) DEFAULT 'public',
  `create_at` date DEFAULT current_timestamp(),
  `slug_song` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_song`
--

INSERT INTO `tbl_song` (`song_id`, `user_id`, `category_id`, `song_name`, `song_image`, `file_path`, `listen_count`, `lyrics`, `privacy`, `create_at`, `slug_song`) VALUES
(5, 18, 5, 'Một Triệu Like', 'den-vau-ra-mv-mot-trieu-like-1579485105.jpg', 'Một Triệu Like.mp3', 6, '', 'public', '2024-08-15', 'mot-trieu-like-18'),
(6, 18, 5, 'Đưa Nhau Đi Trốn (Đen Vâu ft. Linh Cáo)', 'Đưa nhau đi trốn.png', 'Đen - Đưa Nhau Đi Trốn ft. Linh Cáo [M-V].mp3', 2, '', 'public', '2024-09-05', 'dua-nhau-di-tron-den-vau-ft-linh-cao-18'),
(7, 16, 5, 'Bạn Đời (Karik ft. Gducky)', 'bạn đời.jpg', 'KARIK - BẠN ĐỜI (FT. GDUCKY) - OFFICIAL MUSIC VIDEO.mp3', 8, '', 'public', '2024-09-05', 'ban-doi-karik-ft-gducky-16'),
(8, 17, 8, 'Có sao cũng đành (DatKaa x Prod. QT Beatz)', 'có sao cũng đành.jpg', 'Có Sao Cũng Đành - DatKaa x Prod. QT Beatz [Official Music Video].mp3', 3, '', 'public', '2024-09-05', 'co-sao-cung-danh-datkaa-x-prod-qt-beatz-17'),
(9, 18, 5, 'Lối Nhỏ (Đen Vâu ft. Phương Anh Đào)', 'Lối nhỏ.jpg', 'Đen - Lối Nhỏ ft. Phương Anh Đào (M-V).mp3', 2, '', 'public', '2024-09-05', 'loi-nho-den-vau-ft-phuong-anh-dao-18'),
(10, 7, 1, 'Lạc trôi', 'lạc trôi.jpg', 'Lạc trôi.mp3', 1, '', 'public', '2024-09-05', 'lac-troi-7'),
(11, 7, 8, 'Nơi này có anh', 'Nơi_này_có_anh_-_Single_Cover.jpg', 'NƠI NÀY CÓ ANH - OFFICIAL MUSIC VIDEO - SƠN TÙNG M-TP.mp3', 2, '', 'public', '2024-09-05', 'noi-nay-co-anh-7'),
(12, 19, 1, 'Nhạt (Phan Mạnh Quỳnh)', 'nhạt.jpg', 'NHẠT - PHAN MẠNH QUỲNH [OFFICIAL MUSIC VIDEO].mp3', 2, '', 'public', '2024-09-05', 'nhat-phan-manh-quynh-19'),
(13, 20, 8, 'Thằng điên (Justatee ft Phương Ly)', 'thằng điên.jpg', 'THẰNG ĐIÊN - JUSTATEE x PHƯƠNG LY - OFFICIAL MV.mp3', 0, '', 'public', '2024-09-05', 'thang-dien-justatee-ft-phuong-ly-20'),
(14, 18, 5, 'Bài này chill phết', 'bài này chill phết.jpg', 'Đen ft. MIN - Bài Này Chill Phết (M-V).mp3', 4, '', 'public', '2024-09-06', 'bai-nay-chill-phet-18'),
(15, 1, 6, 'Túy âm', 'album vui vẻ mỗi ngày.png', 'Túy Âm - Xesi x Masew x Nhatnguyen.mp3', 1, '', 'public', '2024-09-11', 'tuy-am-1'),
(16, 1, 14, 'Let her go', 'let her go.jpg', 'Passenger - Let Her Go (Official Video).mp3', 3, '', 'public', '2024-09-11', 'let-her-go-1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `userimage` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `fullName`, `email`, `password`, `description`, `userimage`, `slug`, `role`) VALUES
(1, 'Admin Huyến', 'adminhuyen@gmail.com', 'huyen12345', 'admin Xuân Huyến', 'chup-anh-di-bien.jpg', 'admin-huyen', 'admin'),
(2, 'Admin Hoàng', 'adminhoang@gmail.com', 'hoang12345', 'admin Duy Hoàng', NULL, 'admin-hoang', 'admin'),
(3, 'văn huy', 'vanhuy@gmail.com', 'huy12345', '', NULL, 'van-huy', 'user'),
(4, 'ngoc Lâm', 'ngoclam@gmail.com', 'lam12345', '', NULL, 'ngoc-lam', 'user'),
(5, 'Duy Hải', 'duyhai@gmail.com', 'hai12345', 'Hải idol', NULL, 'duy-hai', 'user'),
(7, 'Sơn Tùng MTP', 'songtungmtp@gmail.com', '', 'Hãy trao cho anh', 'sơn tùng mtp.jpg', 'son-tung-mtp', 'user'),
(8, 'Du Thiên Offical', 'duthien@gmail.com', 'thien12345', 'Lệ cay', NULL, 'du-thien-offical', 'user'),
(10, 'Nguyễn Văn Anh', 'anh@gmail.com', 'anh12345', 'Văn Anh', NULL, 'nguyen-van-anh', 'user'),
(11, 'Nguyễn Khánh Hà', 'khanhha@gmail.com', 'khanhha12345', 'Khánh Hà', NULL, 'nguyen-khanh-ha', 'user'),
(12, 'Vũ Thị Tình', 'vuthitinh@gmail.com', 'tinh12345', 'Vũ Thị Tình', NULL, 'vu-thi-tinh', 'user'),
(13, 'Nguyễn Xuân Hiến', 'xuanhien@gmail.com', 'hien12345', '', NULL, 'nguyen-xuan-hien', 'user'),
(14, 'Nguyễn Xuân Huyến', 'goat2625@gmail.com', 'huyen12345', 'xuân huyến', NULL, 'nguyen-xuan-huyen', 'user'),
(15, 'Mai Hương', 'maihuong@gmail.com', 'huong12345', NULL, NULL, 'mai-huong', 'user'),
(16, 'Karik', 'karik@gmail.com', 'karik12345', '', 'karik.png', 'karik', 'user'),
(17, 'DatKaa', 'datkaa@gmail.com', 'datkaa12345', '', 'datkaa.png', 'datkaa', 'user'),
(18, 'Đen Vâu', 'denvau@gmail.com', 'denvau12345', '', 'den-vau_TICF.jpg', 'den-vau', 'user'),
(19, 'Phan Mạnh Quỳnh', 'quynh@gmail.com', 'quynh12345', '', 'Phan_Mạnh_Quỳnh.jpg', 'phan-manh-quynh', 'user'),
(20, 'Justatee', 'justatee@gmail.com', 'justatee12345', '', 'jusatee.jpg', 'justatee', 'user'),
(21, 'Nguyễn Xuân Huyến', 'fgh@gmail.com', '123', NULL, NULL, 'nguyen-xuan-huyen', 'user'),
(24, 'Nguyễn Thị Phương', 'phuong@gmail.com', 'phương12345', NULL, NULL, 'nguyen-thi-phuong', 'user'),
(25, 'Doãn Chí Bình', 'binh@gmail.com', 'binh12345', NULL, NULL, 'doan-chi-binh', 'user'),
(27, 'Trần Quý', 'quy@gmail.com', 'quy12345', NULL, NULL, 'tran-quy', 'user'),
(28, 'Nguyễn Xuân Huyến', 'gmailtest@gmail.com', 'NguyenXuanHuyen107@', NULL, NULL, 'nguyen-xuan-huyen', 'user'),
(29, 'Nguyễn Xuân Huyến', 'goat262565@gmail.com', 'NguyenXuanHuyen107@', NULL, NULL, 'nguyen-xuan-huyen', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin_logs`
--
ALTER TABLE `tbl_admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_album`
--
ALTER TABLE `tbl_album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_album_song`
--
ALTER TABLE `tbl_album_song`
  ADD PRIMARY KEY (`album_song_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Chỉ mục cho bảng `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_follow`
--
ALTER TABLE `tbl_follow`
  ADD PRIMARY KEY (`follow_id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Chỉ mục cho bảng `tbl_playlist`
--
ALTER TABLE `tbl_playlist`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_playlist_song`
--
ALTER TABLE `tbl_playlist_song`
  ADD PRIMARY KEY (`playlist_song_id`),
  ADD KEY `playlist_id` (`playlist_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Chỉ mục cho bảng `tbl_song`
--
ALTER TABLE `tbl_song`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin_logs`
--
ALTER TABLE `tbl_admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT cho bảng `tbl_album`
--
ALTER TABLE `tbl_album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_album_song`
--
ALTER TABLE `tbl_album_song`
  MODIFY `album_song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tbl_follow`
--
ALTER TABLE `tbl_follow`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_playlist`
--
ALTER TABLE `tbl_playlist`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `tbl_playlist_song`
--
ALTER TABLE `tbl_playlist_song`
  MODIFY `playlist_song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `tbl_song`
--
ALTER TABLE `tbl_song`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_admin_logs`
--
ALTER TABLE `tbl_admin_logs`
  ADD CONSTRAINT `tbl_admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_album`
--
ALTER TABLE `tbl_album`
  ADD CONSTRAINT `tbl_album_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_album_song`
--
ALTER TABLE `tbl_album_song`
  ADD CONSTRAINT `tbl_album_song_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `tbl_album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_album_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `tbl_song` (`song_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  ADD CONSTRAINT `tbl_favorite_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `tbl_song` (`song_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_favorite_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_follow`
--
ALTER TABLE `tbl_follow`
  ADD CONSTRAINT `tbl_follow_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_follow_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_playlist`
--
ALTER TABLE `tbl_playlist`
  ADD CONSTRAINT `tbl_playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_playlist_song`
--
ALTER TABLE `tbl_playlist_song`
  ADD CONSTRAINT `tbl_playlist_song_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `tbl_playlist` (`playlist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_playlist_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `tbl_song` (`song_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_song`
--
ALTER TABLE `tbl_song`
  ADD CONSTRAINT `tbl_song_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_song_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
