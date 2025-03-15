<?php
include_once "./layout/master.php";
?>
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
        <table class="table">
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