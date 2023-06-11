<?php
// import ไฟล์สำหรับใช้ database
include '../admin/db/db.php';

// ถ้ามีการส่งค่า category_id มาให้เก็บค่าไว้ในตัวแปร $category_id ถ้าไม่มีให้เก็บค่าว่างไว้
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';


// settings ปุ่มเปลี่ยนหน้า ให้แสดงหน้าละ 5
$results_per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// ดึงข้อมูลทั้งหมดของสถานที่ที่มี category_id ตามที่ส่งมา แล้วนำไป query/ค้นหาใน database
$sql = "SELECT * FROM locations WHERE category_id = '$category_id' LIMIT $offset, $results_per_page";
$result = $db->query($sql);

// Get total number of locations for pagination
$total_locations = mysqli_num_rows($db->query("SELECT * FROM locations WHERE category_id = '$category_id'"));
$total_pages = ceil($total_locations / $results_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chai Nat Province</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="../css/attraction.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <!-- ปรับหน้าเว็บตามขนาดหน้าจอ -->
  <style>
    @media screen and (min-width: 640px) {
      .card-container {
        grid-template-columns: 2fr 1fr;
      }
    }

    #map {
      margin-top: -50px;
      margin-left: 20px;
    }
  </style>


</head>

<body class="bg-black">
  <!-- ดึงไฟล์แถบเมนูมา -->
  <?php include 'header.php'; ?>

  <div class="w-full h-1 bg-white mt-4"></div>
  <!--card -->
  <div class="container bg-black mx-auto px-4 py-8 rounded-lg">
    <?php
    // ถ้ามีแถวข้อมูลให้ลูปข้อมูลแล้วแสดง
    if (mysqli_num_rows($result) > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
        <div v class="card-container bg-gray-800 grid grid-cols-1 gap-4 mt-8 rounded-lg p-4">
          <a href="v_full.php?id=<?= $row['id'] ?>" class="image-wrapper flex items-center justify-center w-1000">
            <img class="rounded-lg p-1 bg-black" src="../admin/uploads/<?php echo $row['img_1'] ?>" width="600" height="600">
          </a>
          <div class="info-wrapper bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-6xl font-bold mb-2 text-center p-2">เวลาเปิด-ปิด</h1>
            <h2 class="text-2xl text-gray-600 mb-4 text-center p-2">
              <!-- แสดงเวลาเปิด-ปิด -->
              <?php
              if ($row['open_time'] == "") {
                echo '-';
              }
              if ($row['open_time'] == "เปิดตลอด 24 ชั่วโมง") {
                echo 'เปิดตลอด 24 ชั่วโมง';
              } else {
                echo $row['open_time'] . ' น.'; ?> - <?php echo $row['close_time'] . ' น.';
                                                    } ?>
            </h2>
          </div>
          <div class="p-6 bg-blue-400 col-span-2 rounded-lg">
            <h2 class="text-2xl font-bold mb-2 text-black"><?php echo $row['name']; ?></h2>
            <p class="text-white mb-4"><?php echo $row['short_description']; ?></p>
            <p class="text-white mb-2">เบอร์โทรติดต่อ: <?php echo $row['tel']; ?></p>
            <p class="text-white mb-4">สถานที่ตั้ง: <?php echo $row['location']; ?>
              <a href="map.php?map=<?php echo $row['map']; ?>" class="ml-3 text-red-500">
                <i class="fas fa-map-marker-alt fa-2xl"></i>
              </a>
            </p>
            <a href="v_full.php?id=<?= $row['id'] ?>" class="flex justify-end">
              <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-500">
                อ่านต่อ
              </button>
            </a>
          </div>
        </div>

      <?php }
    } else { ?>
      <!-- ถ้าไม่มีข้อมูลก็จะแสดงข้อความแบบนี้ -->
      <div class="bg-white p-4 rounded-lg">
        <h2 class="text-2xl font-bold">Attraction not found</h2>
        <p>Sorry, the attraction you are looking for could not be found.</p>
      </div>
    <?php } ?>

    <!-- ปุ่มเลือกหน้า -->
    <div class="flex justify-center mt-8">
      <ul class="flex space-x-2">
        <?php if ($current_page > 1) : ?>
          <li><a href="?category_id=<?= $category_id ?>&page=<?= $current_page - 1 ?>" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700">Previous</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li>
            <a href="?category_id=<?= $category_id ?>&page=<?= $i ?>" class="px-4 py-2 rounded-lg <?php if ($i === $current_page) echo 'bg-gray-800 text-white';
                                                                                                  else echo 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> ?> text-white"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages) : ?>
          <li><a href="?category_id=<?= $category_id ?>&page=<?= $current_page + 1 ?>" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700">Next</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

</body>

</html>