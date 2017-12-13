<br><div style="text-align: left;padding-left: 150px;background-color: #EFF5FB;color: #0080FF  ">
<form class="timnhanh" method="GET" hidden="">
  <table style="border: none;">
    <tr>
      <td align="center" width="100"><img width="20" align="center" src="image/local1.png">Nơi Đi</td>
      <td align="center" width="100"><img width="20" align="center" src="image/local1.png">Nơi Đến</td>
      <td align="center" width="100"><img width="20" align="center" src="image/calendar.png">Ngày Đi</td>
      
    </tr>
    <tr>
      <td><select style="margin-left: 5px" name="noi-di">
        </select></td>
      <td><select style="margin-left: 5px " name="noi-den">
        </select></td>

      <td><input name="setTodaysDate" type="date" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
        echo date('Y-m-d'); ?>">
        </td> 
      <td><button name="btnSearch" style="color: white;padding:5px 20px;font-size: 20px;border-radius: 10px">Tìm Xe</button></td>
    </tr>
  </table>
</form>
<?php
print_r($_GET);
$ndi = $_GET["noi-di"];
$nde = $_GET["noi-den"];
$sql = "SELECT
chuyenxe.id,
chuyenxe.Giodi,
chuyenxe.Gioden,
chuyenxe.Diemdi,
chuyenxe.Diemden,
chuyenxe.Ngaydi,
chuyenxe.Ngayve,
chuyenxe.Giave,
chuyenxe.Chotrong,
chuyenxe.id_lotrinh,
chuyenxe.id_taixe,
chuyenxe.id_xe,
chuyenxe.id_vexe,
lotrinh.Diemdi,
lotrinh.Diemden
FROM
chuyenxe
INNER JOIN lotrinh ON chuyenxe.id_lotrinh = lotrinh.id
WHERE
lotrinh.Diemdi = '$ndi' AND
lotrinh.Diemden = '$nde'
";

echo $sql;
?>

<a class="tim" style="cursor: pointer;">Tìm Chuyến Xe Nhanh</a>
</div>
<br><div><a style="font-size: 25px">CHUYẾN XE HIỆN CÓ</a></div><br>
<?php
$i=0;
$ndi = $_GET["noi-di"];
$nde = $_GET["noi-den"];
//$stmt=$conn->prepare("SELECT * FROM chuyenxe ORDER BY id DESC");
$stmt=$conn->prepare("SELECT
chuyenxe.id as idchuyen,
chuyenxe.Giodi,
chuyenxe.Gioden,
chuyenxe.Diemdi,
chuyenxe.Diemden,
chuyenxe.Ngaydi,
chuyenxe.Ngayve,
chuyenxe.Giave,
chuyenxe.Chotrong,
chuyenxe.id_lotrinh,
chuyenxe.id_taixe,
chuyenxe.id_xe,
chuyenxe.id_vexe,
`xe`.Tenxe,
`xe`.Soluongghe
FROM
lotrinh
INNER JOIN chuyenxe ON chuyenxe.id_lotrinh = lotrinh.id
INNER JOIN `xe` ON chuyenxe.id_xe = `xe`.id
WHERE
lotrinh.Diemdi = '$ndi' AND
lotrinh.Diemden = '$nde'
");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table style="border: none;background: #045FB4;color: white;line-height: 50px;font-size: 13px;font-weight: bolder;">
  <tr>
    <td align="center" width="140px"><img width="20" src="image/xe.png"> HÃNG XE</td>
    <td align="center" width="120px"><img width="20" src="image/local2.png"> ĐIỂM ĐI</td>
    
    <td align="center" width="210px"><img width="20" src="image/local2.png"> ĐIỂM ĐẾN</td>
    <td align="center" width="120px"><img width="20" src="image/xe.png"> LOẠI XE</td>
    <td align="center" width="90px"><img width="20" src="image/xe.png"> NGÀY ĐI</td>
    <td align="center" width="120px"><img width="20" src="image/xe.png"> NGÀY VỀ</td>
    <td align="center" width="70px"><img width="20" src="image/money1.png"> GIÁ</td>
    <td align="center" width="100px"><img width="20" src="image/v.png"> SỐ LƯỢNG</td>
    <td align="center" width="75px"><img width="20" src="image/ticket.png"> ĐẶT VÉ</td>
  </tr>
</table>

<table style="border: none;"  >
<?php
foreach ($data as $key => $value) { ?>
	<form method="post" action="thanh-toan.php">
    <td align="center" width="150px"><?php echo $value['Tenxe']; ?> 
    <input type="text" name="idchuyen" value="<?php echo $value['idchuyen'] ?>">
    </td>
    <td align="center" width="120px"><?php echo $value['Giodi']; ?></td>
    
    <td align="center" width="210px"><?php echo $value['Gioden']; ?></td>
    <td align="center" width="100px" colspan="3"><?php echo $value['Soluongghe']." chỗ"; ?></td>
    <td align="center" width="110px"  rowspan="2"><?php echo date_format(date_create($value["Ngaydi"]),"d-m-Y"); ?></td>
    <td align="center" width="110px"  rowspan="2"><?php echo date_format(date_create($value["Ngayve"]),"d-m-Y"); ?></td>
    <td align="center" width="100px" rowspan="2"><?php echo number_format($value['Giave'],0,',','.')." VNĐ"; ?></td>
    
    <input type="text" name="idget" value="<?php echo $value['idchuyen']; ?>" hidden> 

    <td rowspan="2"><select name="slve" style="width: 50px;top:320px;right: 1200px;margin-left: auto;">
      <?php for ($i=1; $i <=$value['Chotrong'] ; $i++) 
      {?>
      <option><?php echo $i; ?></option>
        <?php 
        } ?> 
    </select></td>
      
    <?php if($value['Chotrong']>0)
    { ?>
    <td align="center" width="100px" rowspan="2"  ><a href="bovao.php?idsp=<?php echo $value['idchuyen']; ?>"><button type="button" name="btnCart" style="color: white;height: 30px;width: 100px;font-weight: bolder;margin-left: 20px;">THÊM</button></a><button type="submit" style="color: white;height: 30px;width: 100px;font-weight: bolder;margin-top: 5px;margin-left: 20px;">ĐẶT VÉ</button></td>
    <?php 
    }else
    {?>
    <td align="center" width="100px" rowspan="2"><button type="button" style="color: white;height: 30px;background: red;width: 100px;font-weight: bolder;margin-top: 5px;margin-left: 20px;">HẾT VÉ</button></td>
    <?php  
    } ?>
    </form>

  </tr>

  <tr>
    <td align="center" width="90px"><img width="15" src="image/star.png"><img width="15" src="image/star.png"><img width="15" src="image/star.png"><img width="15" src="image/star.png"><img width="15" src="image/star.png"></td>
    <td align="center" width="110px" ><?php echo $value['Diemdi']; ?></td>
    <td align="center" width="120px"><?php echo $value['Diemden']; ?></td>
    <td align="center" width="100px"> <img width="20" src="image/nuoc.png"><img width="20" src="image/banh.png"> <img width="20" src="image/wifi.png"></td>
  </tr>
	

  <?php 
}
?>
</table>
<br><br><br>
