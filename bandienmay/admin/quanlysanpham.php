<?php
include('../db/connect.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
$sotin1trang = 5;
$trang = $_GET['trang'];
?>
<?php
	if(isset($_POST['themsanpham'])){
		$tensanpham = $_POST['tensanpham'];
		$hinhanh = $_FILES['hinhanh']['name'];
		
		$soluong = $_POST['soluong'];
		$gia = $_POST['giasanpham'];
		$giakhuyenmai = $_POST['giakhuyenmai'];
		$danhmuc = $_POST['danhmuc'];
		$chitiet = $_POST['chitiet'];
		$mota = $_POST['mota'];
		$path = '../uploads/';
		
		$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
		$sql_insert_product = mysqli_query($con,"INSERT INTO tbl_sanpham(sanpham_name,sanpham_chitiet,sanpham_mota,sanpham_gia,sanpham_giakhuyenmai,sanpham_soluong,sanpham_image,category_id) values ('$tensanpham','$chitiet','$mota','$gia','$giakhuyenmai','$soluong','$hinhanh','$danhmuc')");
		move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
	}elseif(isset($_POST['capnhatsanpham'])) {
		$id_update = $_POST['id_update'];
		$tensanpham = $_POST['tensanpham'];
		$hinhanh = $_FILES['hinhanh']['name'];
		$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
		$soluong = $_POST['soluong'];
		$gia = $_POST['giasanpham'];
		$giakhuyenmai = $_POST['giakhuyenmai'];
		$danhmuc = $_POST['danhmuc'];
		$chitiet = $_POST['chitiet'];
		$mota = $_POST['mota'];
		$path = '../uploads/';
		if($hinhanh==''){
			$sql_update_image = "UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_chitiet='$chitiet',sanpham_mota='$mota',sanpham_gia='$gia',sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',category_id='$danhmuc' WHERE sanpham_id='$id_update'";
		}else{
			move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
			$sql_update_image = "UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_chitiet='$chitiet',sanpham_mota='$mota',sanpham_gia='$gia',sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',sanpham_image='$hinhanh',category_id='$danhmuc' WHERE sanpham_id='$id_update'";
		}
		mysqli_query($con,$sql_update_image);
	}
	
?> 
<?php
	if(isset($_GET['xoa'])){
		$id= $_GET['xoa'];
		$sql_xoa = mysqli_query($con,"DELETE FROM tbl_sanpham WHERE sanpham_id='$id'");
	} 
?>




<div class="container-fluid">
<div class="table-responsive">
<table class="table table-bordered" width="100%" cellspacing="0">
      <form method="post">
	<h6 class="m-0 font-weight-bold text-primary">Li???t k?? s???n ph???m <input style="width: 250px; height: 40px; border-radius: 20px; border: #ccc;padding-left: 20px;" type="text" placeholder="Search..." name="searchdata"><button style="width: 42px; height: 40px; border-radius: 20px; border: #ccc;" type="text" placeholder="Search..." name="search"><i class="fas fa-search"></i></button> </h6>
	</form>
	<?php
		if(isset($_POST['search'])){
			$data = $_POST['searchdata'];
		}
	?>
	<br>
<?php
				$from = ($trang - 1) * $sotin1trang;
				$sql_select_sp = mysqli_query($con,"SELECT * FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.sanpham_name LIKE '%$data%' AND tbl_sanpham.category_id=tbl_category.category_id ORDER BY tbl_sanpham.sanpham_id DESC limit $from,$sotin1trang"); 
				
				
				?> 


        <thead>
            <tr>
                <th>Th??? t???</th>
				<th>T??n s???n ph???m</th>
				<th>H??nh ???nh</th>
				<th>S??? l?????ng</th>
				<th>Danh m???c</th>
				<th>Gi?? s???n ph???m</th>
				<th>Gi?? khuy???n m??i</th>
				<th>Qu???n l??</th>
			</tr>
        </thead>
        <tbody>
  <?php
					$i = 0;
					while($row_sp = mysqli_fetch_array($sql_select_sp)){ 
						$i++;
					?> 
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row_sp['sanpham_name'] ?></td>
						<td><img src="../uploads/<?php echo $row_sp['sanpham_image'] ?>" height="100" width="auto"></td>
						<td><?php echo $row_sp['sanpham_soluong'] ?></td>
						<td><?php echo $row_sp['category_name'] ?></td>
						<td><?php echo number_format($row_sp['sanpham_gia']).'vn??' ?></td>
						<td><?php echo number_format($row_sp['sanpham_giakhuyenmai']).'vn??' ?></td>
						<td><a href="?trang=<?php echo $_GET['trang']; ?>&xoa=<?php echo $row_sp['sanpham_id'] ?>">X??a</a> || <a href="quanlysanpham.php?trang=<?php echo $_GET['trang']; ?>&quanly=capnhat&capnhat_id=<?php echo $row_sp['sanpham_id'] ?>">C???p nh???t</a></td>
					</tr>
				<?php
					} 
					?> 
        </tbody>
      </table>
			<div id="phantrang">
			<?php
				$x = mysqli_query($con,"SELECT * FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.category_id=tbl_category.category_id ORDER BY tbl_sanpham.sanpham_id DESC");
				$tongostin = mysqli_num_rows($x);
				$sotrang = ceil($tongostin/$sotin1trang);
				for($t = 1 ; $t <= $sotrang;$t++){
					echo "<a href='quanlysanpham.php?trang=$t'>Trang $t </a>";
				}
			?>
			</div>
    </div>
	<br/>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h4 class="m-0 font-weight-bold text-primary">Danh m???c s???n ph???m</h4>
    <div class="card-body">
    <?php
			if(isset($_GET['quanly'])=='capnhat'){
				$id_capnhat = $_GET['capnhat_id'];
				$sql_capnhat = mysqli_query($con,"SELECT * FROM tbl_sanpham WHERE sanpham_id='$id_capnhat'");
				$row_capnhat = mysqli_fetch_array($sql_capnhat);
				$id_category_1 = $row_capnhat['category_id'];
				?>
				<div class="col-md-4">
				<h4>C???p nh???t s???n ph???m</h4>
				
				<form action="" method="POST" enctype="multipart/form-data">
					<label>T??n s???n ph???m</label>
					<input type="text" class="form-control" name="tensanpham" value="<?php echo $row_capnhat['sanpham_name'] ?>"><br>
					<input type="hidden" class="form-control" name="id_update" value="<?php echo $row_capnhat['sanpham_id'] ?>">
					<label>H??nh ???nh</label>
					<input type="file" class="form-control" name="hinhanh"><br>
					<img src="../uploads/<?php echo $row_capnhat['sanpham_image'] ?>" height="80" width="auto"><br>
					<label>Gi??</label>
					<input type="text" class="form-control" name="giasanpham" value="<?php echo $row_capnhat['sanpham_gia'] ?>"><br>
					<label>Gi?? khuy???n m??i</label>
					<input type="text" class="form-control" name="giakhuyenmai" value="<?php echo $row_capnhat['sanpham_giakhuyenmai'] ?>"><br>
					<label>S??? l?????ng</label>
					<input type="text" class="form-control" name="soluong" value="<?php echo $row_capnhat['sanpham_soluong'] ?>"><br>
					<label>M?? t???</label>
					<textarea class="form-control" rows="10" name="mota"><?php echo $row_capnhat['sanpham_mota'] ?></textarea><br>
					<label>Chi ti???t</label>
					<textarea class="form-control" rows="10" name="chitiet"><?php echo $row_capnhat['sanpham_chitiet'] ?></textarea><br>
					<label>Danh m???c</label>
					<?php
					$sql_danhmuc = mysqli_query($con,"SELECT * FROM tbl_category ORDER BY category_id DESC"); 
					?>
					<select name="danhmuc" class="form-control">
						<option value="0">-----Ch???n danh m???c-----</option>
						<?php
						while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){
							if($id_category_1==$row_danhmuc['category_id']){
						?>
						<option selected value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
						<?php 
							}else{
						?>
						<option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
						<?php
							}
						}
						?>
					</select><br>
					<input type="submit" name="capnhatsanpham" value="C???p nh???t s???n ph???m" class="btn btn-primary">
				</form>
				</div>
			<?php
			}else{
				?> 
				<div class="col-md-4">
				<h4>Th??m s???n ph???m</h4>
				
				<form action="" method="POST" enctype="multipart/form-data">
					<label>T??n s???n ph???m</label>
					<input type="text" class="form-control" name="tensanpham" placeholder="T??n s???n ph???m"><br>
					<label>H??nh ???nh</label>
					<input type="file" class="form-control" name="hinhanh"><br>
					<label>Gi??</label>
					<input type="text" class="form-control" name="giasanpham" placeholder="Gi?? s???n ph???m"><br>
					<label>Gi?? khuy???n m??i</label>
					<input type="text" class="form-control" name="giakhuyenmai" placeholder="Gi?? khuy???n m??i"><br>
					<label>S??? l?????ng</label>
					<input type="text" class="form-control" name="soluong" placeholder="S??? l?????ng"><br>
					<label>M?? t???</label>
					<textarea class="form-control" name="mota"></textarea><br>
					<label>Chi ti???t</label>
					<textarea class="form-control" name="chitiet"></textarea><br>
					<label>Danh m???c</label>
					<?php
					$sql_danhmuc = mysqli_query($con,"SELECT * FROM tbl_category ORDER BY category_id DESC"); 
					?>
					<select name="danhmuc" class="form-control">
						<option value="0">-----Ch???n danh m???c-----</option>
						<?php
						while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){
						?>
						<option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
						<?php 
						}
						?>
					</select><br>
					<input type="submit" name="themsanpham" value="Th??m s???n ph???m" class="btn btn-primary">
				</form>
				</div>
				<?php
			} 
			
				?>
  </div>


  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>