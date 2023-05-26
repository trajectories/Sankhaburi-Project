<?php
include '../admin/db/db.php';

$attraction_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve attraction details from the database based on the ID
$sql = "SELECT * FROM locations WHERE id = '$attraction_id'";
$result = mysqli_query($db, $sql);

// Check if the attraction exists
if (mysqli_num_rows($result) > 0) {
    $attraction = mysqli_fetch_assoc($result);
} else {
    $attraction = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attraction Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>

<body class="bg-black">
    <?php require_once 'header.php'; ?>
    <div class="w-full h-1 bg-white mt-4"></div>
    <div class="container mx-auto px-4 py-8">
        <?php if ($attraction) : ?>
            <div class="bg-white p-4 rounded-lg">
                <h2 class="text-2xl font-bold mb-4"><?= $attraction['name'] ?></h2>
                <div class="flex items-center justify-center image-wrapper">
                    <img src="../admin/uploads/<?php echo $attraction['img_1'] ?>" alt="Attraction Image" class="w-auto h-auto object-cover rounded-lg shadow-md">
                </div>
                <p class="mt-5">&emsp;&emsp;&emsp;&emsp;<?= $attraction['description'] ?></p>
            </div>
            <div class="bg-blue-400 p-4 rounded-lg mt-4 flex flex-col">
                <p class="text-white mb-2">เวลาเปิด-ปิด:
                    <?php
                    if ($attraction['open_time'] == "") {
                        echo '-';
                    }
                    if ($attraction['open_time'] == "เปิดตลอด 24 ชั่วโมง") {
                        echo 'เปิดตลอด 24 ชั่วโมง';
                    } else {
                        echo $attraction['open_time'] . ' น.'; ?> - <?php echo $attraction['close_time'] . ' น.';
                                                            }

                                                                ?>
                </p>
                <p class="text-white mb-2">เบอร์โทรติดต่อ: <?php echo $attraction['tel']; ?></p>
                <p class="text-white">สถานที่ตั้ง: <?php echo $attraction['location']; ?></p>
                <form action="map.php" method="get" class="mt-2">
                    <input hidden name="map" value="<?= $attraction['map'] ?>">
                    <button type="submit">
                        <i class="fas fa-map-marker-alt fa-2xl"></i>
                    </button>
                </form>
            </div>
        <?php else : ?>
            <div class="bg-white p-4 rounded-lg">
                <h2 class="text-2xl font-bold">Attraction not found</h2>
                <p>Sorry, the attraction you are looking for could not be found.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>