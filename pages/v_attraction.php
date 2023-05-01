<?php
$attraction = [
  'name' => 'The Amazing Attraction',
  'image' => 'https://via.placeholder.com/300x200',
  'description' => 'A short description of the amazing attraction.',
  'phone' => '123-456-7890',
  'location' => '123 Main St, Anytown, USA',
  'open_close' => '9:00 AM - 5:00 PM',
  'price_rate' => '$20 per person'
];

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
  <?php require_once 'header.html'; ?>
  <!-- Attraction card -->
  <div class="container bg-black mx-auto px-4 py-8 mt-3 rounded-lg">
    <div class="card-container bg-gray-800 grid grid-cols-1 gap-4 mt-5 rounded-lg">
      <div class="image-wrapper">
        <img src="https://via.placeholder.com/600x300" alt="Attraction Image" class="w-full h-48 sm:h-64 object-cover rounded-lg shadow-md">
      </div>
      <div class="info-wrapper bg-white p-4 shadow-md rounded-lg">
        <h3 class="text-xl font-bold mb-2">Attraction Name</h3>
        <p class="text-sm text-gray-600 mb-4">Opening Hours: 9am - 6pm</p>
        <p class="text-sm text-gray-600">Price Rate: $25 (Adults), $15 (Children)</p>
      </div>
      <div class="p-6">
        <h2 class="text-white text-2xl font-bold mb-2"><?php echo $attraction['name']; ?></h2>
        <p class="text-white mb-4"><?php echo $attraction['description']; ?></p>
        <p class="text-white mb-2">Phone: <?php echo $attraction['phone']; ?></p>
        <p class="text-white mb-4">Location: <?php echo $attraction['location']; ?></p>
      </div>
    </div>
    <div class="card-container bg-gray-800 grid grid-cols-1 gap-4 mt-5 rounded-lg">
      <div class="image-wrapper">
        <img src="https://via.placeholder.com/600x300" alt="Attraction Image" class="w-full h-48 sm:h-64 object-cover rounded-lg shadow-md">
      </div>
      <div class="info-wrapper bg-white p-4 shadow-md rounded-lg">
        <h3 class="text-xl font-bold mb-2">Attraction Name</h3>
        <p class="text-sm text-gray-600 mb-4">Opening Hours: 9am - 6pm</p>
        <p class="text-sm text-gray-600">Price Rate: $25 (Adults), $15 (Children)</p>
      </div>
      <div class="p-6">
        <h2 class="text-white text-2xl font-bold mb-2"><?php echo $attraction['name']; ?></h2>
        <p class="text-white mb-4"><?php echo $attraction['description']; ?></p>
        <p class="text-white mb-2">Phone: <?php echo $attraction['phone']; ?></p>
        <p class="text-white mb-4">Location: <?php echo $attraction['location']; ?></p>
      </div>
    </div>
  </div>
</body>

</html>