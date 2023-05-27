<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Chai Nat Province</title>
  <!-- เรียกใช้ cdn ของ tailwind css -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900 font-sans">
  <!-- Header -->
  <header class="header px-4 sm:px-8 py-4 sm:py-6 bg-gray-900 text-white flex flex-col sm:flex-row justify-between items-center w-full">
    <a href="#">
      <h1 class="heading text-4xl font-semibold mb-2 sm:mb-0">เที่ยวชัยนาท</h1>
    </a>
    <form class="search-form flex items-center w-full sm:w-auto" action="search.php" method="get">
      <input type="text" name="search" placeholder="Search..." class="p-2 bg-white text-black rounded-lg mr-2 w-full sm:w-48 md:w-1/2 lg:w-48" />
      <button type="submit" class="p-2 bg-gray-700 text-white rounded-lg mr-2 w-full sm:w-auto mt-2 sm:mt-0">Search</button>
    </form>
  </header>
  <!-- Content -->
  <div class="container mx-auto flex rounded-lg mt-3">
    <!-- Left column -->
    <div class="column w-full sm:w-1/2 md:w-1/3 lg:w-1/4 mx-0.5 bg-green-300 text-black rounded-lg shadow-lg">
      <div class="w-full bg-gray-600 text-4xl p-4">
        <h1 class="text-center">อำเภอสรรคบุรี</h1>
      </div>
      <div class="row flex flex-col space-y-4 mt-6 items-center">
        <?php
        // ดึงข้อมูล ชื่อประเภท กับ หมายเลขไอดีประเภท จากตาราง category มาใช้เป็นปุ่มประเภทสถานที่
        include '../admin/db/db.php';
        $sqlCategory = "SELECT * FROM category WHERE category_id NOT IN (5,6,7,8,9)";
        $resultCategory = $db->query($sqlCategory);
        $categoryRow = $resultCategory->fetch_assoc();
        foreach ($resultCategory as $categoryRow) {
        ?>
          <div class="card bg-blue-500 text-white w-32 sm:w-40 md:w-48 h-12 p-2 rounded-lg flex items-center justify-center font-bold text-md text-center">
            <!-- ลิ้งค์ปุ่มเวลากดแล้วจะส่งข้อมูล category_id ผ่าน Url หรือเรียกว่า GET -->
            <a href="v_attraction.php?category_id=<?= $categoryRow['category_id'] ?>" class="text-white hover:text-blue-300">
              <?= $categoryRow['name'] ?>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
    <!-- Middle column -->
    <div class="column flex-1 sm:w-1/2 md:w-1/3 lg:w-1/4 mx-0.5 p-8 bg-white text-black rounded-lg shadow-lg">
      <img src="https://png.pngtree.com/png-clipart/20220303/original/pngtree-action-cartoon-cute-godzilla-character-avatar-png-image_7400326.png" alt="Image description" class="w-full h-auto mb-4 rounded-lg" />
      <h2 class="text-2xl mb-2">Image Title</h2>
      <p class="text-base mb-4">Image description or caption goes here.</p>
    </div>
    <!-- Right column -->
    <div class="column flex-1 sm:w-1/2 md:w-1/3 lg:w-1/4 mx-0.5 p-8 bg-white text-black rounded-lg shadow-lg">
      <img src="https://png.pngtree.com/png-clipart/20210314/original/pngtree-cute-cartoon-characters-png-image_6103978.jpg" alt="Image description" class="w-full h-auto mb-4 rounded-lg" />
      <h2 class="text-2xl mb-2">Image Title</h2>
      <p class="text-base mb-4">Image description or caption goes here.</p>
    </div>

  </div>
</body>

</html>