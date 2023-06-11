<?php
include '../admin/db/db.php';

// การค้นหาข้อมูล
//รับค่าจากฟอร์ม search แบบ $_GET มาเก็บไว้ในตัวแปร $search ถ้าไม่มีค่าให้เก็บค่าว่าง 
$search = isset($_GET['search']) ? $_GET['search'] : '';
// เอาค่า search มาหาใน database
$sql = "SELECT * FROM locations WHERE name like '%$search%'";
$result = $db->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chai Nat Province</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <style>
    @media screen and (min-width: 640px) {
      .card-container {
        grid-template-columns: 2fr 1fr;
      }
    }
  </style>
</head>

<body class="bg-black">
  <?php require_once 'header.php'; ?>
  <div class="w-full h-1 bg-white mt-4"></div>

  <!-- Attraction card -->
  <div class="container bg-black mx-auto px-4 py-8 rounded-lg">
    <?php
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
      <div class="card-container bg-gray-800 grid grid-cols-1 gap-4 mt-5 rounded-lg">
        <div class="p-6">
          <h2 class="text-white text-2xl font-bold mb-2">ไม่มีข้อมูล</h2>
        </div>
      </div>
    <?php } ?>
  </div>

</body>

</html>