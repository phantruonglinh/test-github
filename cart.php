<htm>
    <head>
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
        <style>
            body{
    font-family: arial;
}
*{
    box-sizing: border-box;
}
.container{
    width: 1450px;
    margin: 0 auto;
    border: 5px solid #99FFCC;
    padding: 15px;

    height:auto;
}

#form-button{
    text-align: right;
    margin-top: 15px;
}
.product-price{
    color: red;
    font-weight: bold;
}
.product-img{
    padding: 5px;
    border: 1px solid #99FFCC;
    margin-bottom: 5px;
}

h1{
    text-align: left;
    margin-top: 0;
}
table{
    border-collapse: collapse;
    width: 1400px;
}
table, th, td {
    border: 1px solid #99FFCC;
}
table .product-img img{
    max-width: 100px;
}
table .product-name{
    width: 350px;
    padding-left: 20px;
    text-align: center;
}
table .product-img{
    width: 120px;
    text-align: center;
}
table .product-number{
    width: 50px;
    text-align: center;
}
table .product-price{
    width: 100px;
    text-align: center;
}
table .product-quantity input{
    width: 40px;
    text-align: center;
}
table .product-quantity{
    width: 60px;
    text-align: center;
}
table .total-money{
    width: 100px;
    text-align: center;
}
.product-delete{
    width: 100px;
    text-align: center;
}
#cart-form label{
    width: 100px;
    display: inline-block;
    margin-top: 15px;
}
#cart-form textarea{
    margin-top: 15px;
}
#cart-form input{
    line-height: 30px;
    height: 30px;
}
input[name="update_click"]{
    background: white;
    border: 1px solid #99FFCC;
}

input[type=text]{
    border: 1px solid #99FFCC;
}
.row-total{
    background: #eee;
    color: #000;
}
hr{
    background: #99FFCC;
}
        </style>
    </head>
    <body>
        
            <?php
                
                session_start();
        
                //nếu có tồn tại session thì moi thực hiện 
                if(!empty($_SESSION['txtTK'])){ 
            $connect=mysqli_connect("localhost","root","","ThoiTrang") or die("Lỗi kết nối");
            mysqli_query($connect,"set names 'utf8'");
            $sql="select * from giohang where UserName= '".$_SESSION['txtTK']."' ";
            $result = mysqli_query($connect, $sql) or die ("không thực hiện được câu lệnh 2");
            ?>
                <div class="container">
                
                <a class="fa fa-home" href="index.php">Trang chủ</a>
                <h1>Giỏ hàng</h1>
                
                <form id="cart-form" action="cart.php?action=submit" method="POST">
                    <table>
                        <tr class="row-total">
                            <th class="product-number">STT</th>
                            <th class="product-name">Tên sản phẩm</th>
                            <th class="product-img">Ảnh sản phẩm</th>
                            <th class="product-price">Đơn giá</th>
                            <th class="product-quantity">Số lượng</th>
                            <th class="total-money">Thành tiền</th>
                            <th class="product-delete">Xóa</th>
                        </tr>
                        <?php
                             $tendn=$_SESSION['txtTK'];
                            
                            $total = 0;
                            $num = 1;
                            while($row=mysqli_fetch_array($result)) {
                                if(!empty($_POST)){
                                    //$row[MaSP];
                                    $sl=$_POST[$row['MaSP']];
                                    $sql2="select * from sanpham where MaSP='".$row['MaSP']."'";
                                    $result2 = mysqli_query($connect, $sql2) or die ("không thực hiện được câu lệnh 2");
                                    $row2 = mysqli_fetch_array($result2);
                                    $thanhtien=0;
                                    $thanhtien = $sl *$row2['DonGia'];
                                    $sql3="update giohang set SoLuong='".$sl."' , ThanhTien='".$thanhtien."'  where MaSP='".$row['MaSP']."' and UserName ='".$_SESSION['txtTK']."'";
                                    $result3 = mysqli_query($connect, $sql3) or die ("không thực hiện được câu lệnh 2");
                                    header('location:cart.php');
                                }
                                //$ma =$kq['MaSP'];
                    $sql2 = "select * from sanpham where MaSP='".$row['MaSP']."'";
                    $result2 = mysqli_query($connect, $sql2) or die ("không thực hiện được câu lệnh 2");
                    $row2 = mysqli_fetch_array($result2);
                    $total =$total + $row['ThanhTien'];
                   ?>
                                    <td class="product-number"><?=$num?></td>
                                    <td class="product-name"><?=$row2['TenSP']?></td>
                                    <td class="product-img"><img src="<?=$row2['Anh']?>" /></td>
                                    <td class="product-price"><?= number_format($row2['DonGia'], 0, ",", ".") ?></td>
                                    <td class="product-quantity"><input type="text" value="<?=$row['SoLuong']?>" name="<?=$row['MaSP']?>" /></td>
                                    <td class="total-money"><?= number_format($row['ThanhTien'], 0, ",", ".") ?></td>
                                    <td class="product-delete"><a href="delete.php?id=<?=$row2['MaSP']?>">Xóa</a></td>
                                </tr>
                                <?php
                                
                                $num++;                               
                            }
                            ?>
                            <tr class="row-total">
                            <td class="product-name" colspan="5">Tổng tiền</td>
                        <td class="product-money" colspan="2"><?php echo number_format($total); $_SESSION['tong']=$total;?></td>
                            </tr>
                </table>
                <div id="form-button">
                        <input type="submit" name="update_click" value="Cập nhật" /> 
                </div>
                </form>
                <hr>
                <form action="order.php" method="POST">
                    
                <div class="h1"><div class="h2"><label>Người nhận:</label></div><div class="h3"><input type="text" name="name" ></div></div>
                <div class="h1"><div class="h2"><label>Điện thoại:</label></div><div class="h3"><input type="text" name="phone" ></div></div>
                <div class="h1"><div class="h2"><label>Địa chỉ:</label></div><div class="h3"><input type="text" name="address"></div></div>
                
                <input type="submit" name="dathang" value="Đặt hàng" />
                </form>
                
                
             
        </div>
            <?php }
            else{
                echo header('location:login.php') ;
            } 
            ?>
            </div>
            
    </body>
</htm>