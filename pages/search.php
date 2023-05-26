<?php
include '../admin/db/db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM locations WHERE name like '%$search%'";
$result = mysqli_query($db, $sql);

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
  
  <!-- Attraction card -->

  <div class="container bg-black mx-auto px-4 py-8 rounded-lg">
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <a href="v_full.php?id=<?= $row['id'] ?>" class="card-container bg-gray-800 grid grid-cols-1 gap-4 mt-8 rounded-lg">
          <div class="image-wrapper">
            <img src="../admin/uploads/<?php echo $row['img_1'] ?>" alt="Attraction Image" class="w-full h-48 sm:h-64 object-cover rounded-lg shadow-md">
          </div>
          <div class="info-wrapper bg-white p-4 shadow-md rounded-lg">
            <h3 class="text-xl font-bold mb-2">Attraction Name</h3>
            <p class="text-sm text-gray-600 mb-4">Opening Hours: 9am - 6pm</p>
            <p class="text-sm text-gray-600">Price Rate: $25 (Adults), $15 (Children)</p>
          </div>
          <div class="p-6">
            <h2 class="text-white text-2xl font-bold mb-2"><?php echo $row['name']; ?></h2>
            <p class="text-white mb-4"><?php echo $row['short_description']; ?></p>
            <p class="text-white mb-2">Phone: <?php echo $row['tel']; ?></p>
            <p class="text-white mb-4">Location: <?php echo $row['location']; ?></p>
          </div>
        </a>
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