<?php
include('../db/connect.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  	<form method="post">
    	<h6 class="m-0 font-weight-bold text-primary">Hóa đơn <input style="width: 250px; height: 40px; border-radius: 20px; border: #ccc;padding-left: 20px;" type="text" placeholder="Search..." name="searchdata"><button style="width: 42px; height: 40px; border-radius: 20px; border: #ccc;" type="text" placeholder="Search..." name="search"><i class="fas fa-search"></i></button> </h6>
	</form>
	<br/>
	<div class="card-header py-3">
	<a href="excel_hoadon.php" class="btn btn-success" target="_blank">Xuất Excel</a>
	<a href="pdf_hoadon.php" class="btn btn-danger">Xuất PDF</a>
	</div>
  </div>
	<?php
		if(isset($_POST['search'])){
			$data = $_POST['searchdata'];
		}
	?>
  <div class="card-body">

    <div class="table-responsive">
        <?php
				$sql_hoadon = mysqli_query($con,"SELECT *, SUM(soluong * sanpham_giakhuyenmai) as 'tongtien' FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.mahang LIKE '%$data%' OR tbl_khachhang.name like '%$data%' AND tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id GROUP BY mahang"); 
		?> 

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Thứ tự</th>
			<th>Mã hàng</th>
			<th>Tên khách hàng</th>
			<th>Số điện thoại</th>
			<th>Địa chỉ</th>
			<th>Tổng hóa đơn</th>
			<th>Thời gian</th>
			<th>Thao tác</th>
          </tr>
          </thead>
          <tbody>
          <?php
					$i = 0;
					while($row_hoadon = mysqli_fetch_array($sql_hoadon)){ 
						$i++;
					?> 
					<tr>	
                        <td><?php echo $i; ?></td>
						<td><?php echo $row_hoadon['mahang']; ?></td>
						<td><?php echo $row_hoadon['name']; ?></td>
						<td><?php echo $row_hoadon['phone']; ?></td>
						<td><?php echo $row_hoadon['address']; ?></td>
						<td><?php echo number_format($row_hoadon['tongtien']).'vnđ'; ?></td>
						<td><?php echo $row_hoadon['ngaythang'] ?></td>
						<td><a href="in_hoadon.php?mahang=<?php echo $row_hoadon['mahang'] ?>" class="btn btn-warning">In hóa đơn</a></td>
					</tr>
					 <?php
					} 
					?> 
        </tbody>
      </table>
    </div>
</div>
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>