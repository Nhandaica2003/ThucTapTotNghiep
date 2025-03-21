<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý điểm ngoại khóa</title>
    <link rel="stylesheet" href="../css/DangKi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <ul class="menu">
                <div style="display: flex;align-items: center;">
                    <img src="../images/logo.jpg" alt="DUE Logo" class="logo" style="background-image: ;">
                    <span>Quản Lý Điểm Ngoại Khoá</span>
                </div>
                <div class="divider"></div>
                
                
                <li class=""><a href="#"><i class="fas fa-calendar-alt"></i>  Quản lý học kỳ</a></li>
                <li><a href="#"><i class="fas fa-chart-line"></i>   Quản lý danh mục điểm</a></li>
                <li><a href="#"><i class="fas fa-list"></i>
                    Hoạt động ngoại khóa</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i>
                </i>
                    Danh sách điểm</a></li>
                <li><a href="#"><i class="fas fa-chart-pie"></i>
                    Thống kê</a></li>
                <li>
                    <div class="menu-item has-submenu">
                        <a href="#"><i class="fas fa-user"></i> Quản Lý Tài Khoản</a>     
                        <div class="submenu">
                            <div class="submenu-item">Danh Sách Tài Khoản</div>
                            <div class="submenu-item">Tạo Tài Khoản</div>
                        </div>
                    </div>
                </li>
                    
                    
                </li>
            </ul>
        </aside>
        <main class="content">
            <header class="header">
                <div class="header-left">
                    <label for="hoc-ky">Học kỳ:</label>
                    <select id="hoc-ky">
                        <option value="1">Học kỳ 1</option>
                        <option value="2">Học kỳ 2</option>
                    </select>
                    <label for="nam-hoc">Năm học:</label>
                    <input type="date" id="nam-hoc">
                </div>
                <div class="header-right">
                    <button class="icon-button"><i class="fas fa-bell"></i></button>
                    <button class="icon-button"><i class="fas fa-user-cog"></i></button>
                    <button class="user-button">Admin <i class="fas fa-chevron-down"></i></button>
                </div>
            </header>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên học kỳ</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Số hoạt động</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Học kỳ 1</td>
                            <td>1-1-2021</td>
                            <td>5-5-2021</td>
                            <td>10</td>
                            <td>
                                <button class="icon-button"><i class="fas fa-edit"></i></button>
                                <button class="icon-button"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="add-button">Thêm học kỳ +</button>
        </main>
    </div>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>