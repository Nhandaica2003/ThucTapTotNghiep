<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoạt động ngoại khóa</title>
    <link rel="stylesheet" href="../css/HoatDong.css">
</head>
<body>
    <div class="container">
        <!-- Menu bên trái -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="DUE Logo">
            </div>
            <h2>QUẢN LÝ ĐIỂM NGOẠI KHÓA</h2>
            <ul>
                <li> Hoạt động ngoại khóa</li>
                <li> Danh sách điểm</li>
                <li> Quản lý tài khoản</li>
                <li> Danh sách tài khoản</li>
                <li> Tạo tài khoản</li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="main-content">
            <h1>Hoạt động ngoại khóa</h1>
            <div class="filter-bar">
                <label for="nam-hoc">Năm học:</label>
                <select id="nam-hoc">
                    <option>2021-2022</option>
                    <option>2022-2023</option>
                    <option>2023-2024</option>
                </select>

                <label for="ky-hoc">Kỳ học:</label>
                <select id="ky-hoc">
                    <option>I</option>
                    <option>II</option>
                </select>

                <label for="bo-phan">Bộ phận:</label>
                <select id="bo-phan">
                    <option>Ngành Kế toán</option>
                    <option>Ngành Quản trị</option>
                    <option>Ngành Tài chính</option>
                </select>

                <label for="muc">Mục:</label>
                <select id="muc">
                    <option>Tất cả</option>
                    <option>Hoạt động tình nguyện</option>
                    <option>Hoạt động thể thao</option>
                </select>
            </div>

            <!-- Bảng danh sách hoạt động -->
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thời gian tổ chức</th>
                        <th>Địa điểm tổ chức</th>
                        <th>Chủ đề và nội dung</th>
                        <th>Số lượng SV</th>
                        <th>Điểm đánh giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tháng 3/2023</td>
                        <td>Trường ĐH Kinh tế</td>
                        <td>Hoạt động tình nguyện Mùa hè xanh</td>
                        <td>150</td>
                        <td>10</td>
                        <td><button class="view-btn">Duyệt</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tháng 3/2023</td>
                        <td>Trường ĐH Kinh tế</td>
                        <td>Ngày hội việc làm</td>
                        <td>120</td>
                        <td>8</td>
                        <td><button class="view-btn">Duyệt</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
