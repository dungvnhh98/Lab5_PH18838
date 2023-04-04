<?php
// ?res=theloai  --> danh sách thể loại
// ?res=theloai&id=xxx ==> xem chi tiết 1 thể loại
function listAll()
{
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `user`";
        // tạo đối tượng prepare chuẩn bị cho cú pháp thực thi truy vấn
        $stmt = $objConn->prepare($sql_str);
        // thực thi câu lệnh
        $stmt->execute();
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status' => 1,
            'msg' => 'Thành công',
            'data' => $danh_sach
        ];
        echo '<pre>';
        print_r($danh_sach);
        echo '</pre>';
        die(json_encode($dataRes));

    } catch (Exception $e) {
        die('Lỗi thực hiện truy vấn CSLD ' . $e->getMessage());
    }

}

function getid($id)
{
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `user` WHERE id = $id";
        // tạo đối tượng prepare chuẩn bị cho cú pháp thực thi truy vấn
        $stmt = $objConn->prepare($sql_str);
        // thực thi câu lệnh
        $stmt->execute();
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status' => 1,
            'msg' => 'Thành công',
            'data' => $danh_sach
        ];
        die(json_encode($dataRes));

    } catch (Exception $e) {
        die('Lỗi thực hiện truy vấn CSLD ' . $e->getMessage());
    }

}

function addUser()
{
    global $objConn;

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    if (empty($username)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập tên user'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "INSERT INTO `user`(`id`, `username`, `password`, `email`, `fullname`) VALUES ('','$username','$password','$email','$fullname')"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã thêm thành công'
            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}

function updateUser($_PUT)
{
    global $objConn;

    $id = $_PUT['id'];
    $pass = $_PUT['password'];
    $mail = $_PUT['email'];
    $fullname = $_PUT['fullname'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id user'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "UPDATE `user` SET `password`='$pass',`email`='$mail',`fullname`='$fullname' WHERE `id` ='$id'"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã sửa thành công'
            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}

function deleteUser($_DELETE)
{
    global $objConn;

    $id = $_DELETE['id'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id user'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "DELETE FROM `user` WHERE id = '$id'"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã xóa thành công'
            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}


//---- xử lý gọi hàm 

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    if (empty($_GET['id'])) // không có id là trang danh sách, có id là chi tiết
        listAll(); // gọi hàm listAll;
    else {
        getid($_GET['id']);
    }
}

if ($method == 'POST') { // đã là post thì chỉ thêm mới, muốn sửa thì dùng PUT
    addUser();
}
if ($method == 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    updateUser($_PUT);
}
if ($method == 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    deleteUser($_DELETE);
}
