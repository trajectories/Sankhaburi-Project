<?php

// Database connection settings
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';
$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : 1;
// Pagination settings
$resultsPerPage = 10; // Number of results to display per page
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// SQL query to retrieve total number of rows
$sqlCount = "SELECT COUNT(*) as total FROM locations Where category_id='$categoryId'";
$countResult = $db->query($sqlCount);
$totalRows = $countResult->fetch_assoc()['total'];

// Calculate total pages
$totalPages = ceil($totalRows / $resultsPerPage);

// Calculate the starting row for the current page
$startRow = ($currentpage - 1) * $resultsPerPage;



// SQL query to retrieve limited rows for the current page
$sql = "SELECT id, name, location, open_time, close_time FROM locations Where category_id='$categoryId' LIMIT $startRow, $resultsPerPage";
$result = $db->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <title>Attraction Management</title>

</head>

<body>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header-table {
            background-color: #f3f4f6;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: left;
            text-align: left;
        }

        .header-table h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .header-table:after {
            content: "";
            display: block;
            width: 100%;
            height: 0.5rem;
            background-color: #93c5fd;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }
    </style>
    <div class="flex flex-col lg:flex-row h-screen bg-gray-100">
        <aside class="bg-white w-full lg:w-64 shadow-lg">
            <a href="manage.php?category_id=1">
                <div class="py-6 px-8 bg-white flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Management Page</h1>
                    <button id="menu-toggle" class="block lg:hidden">
                        <svg class="h-6 w-6 fill-current text-gray-700" viewBox="0 0 24 24">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </a>

            <nav id="menu" class="mt-4 lg:block">
                <?php
                $sqlCategory = "SELECT * FROM category WHERE category_id NOT IN ('5','7','8')";
                $resultCategory = $db->query($sqlCategory);
                while ($categoryRow = $resultCategory->fetch_assoc()) {
                ?>
                    <a href="manage.php?category_id=<?= $categoryRow['category_id'] ?>" class="flex items-center px-8 py-4 text-gray-700 hover:bg-gray-200">
                        <span class="text-lg"><?= $categoryRow['name'] ?></span>
                    </a>
                <?php } ?>
            </nav>
        </aside>
        <main class="flex-1 p-8 h-full">
            <div class="header-table mb-6 flex justify-between">
                <div>
                    <?php
                    $sqlCategory = "SELECT * FROM category WHERE category_id='$categoryId'";
                    $resultCategory = $db->query($sqlCategory);
                    $categoryRow = $resultCategory->fetch_assoc();
                    ?>
                    <h2 class="text-2xl font-bold text-gray-800"><?= $categoryRow['name'] ?></h2>
                    <div class="w-full bg-gray-200 h-0.5 mt-2"></div>
                </div>
            </div>
            <?php if ($categoryId == "6") {
                echo '<a href="add_category.php" class="flex justify-end">';
            } elseif ($categoryId == "9") {
                echo '<a href="add_user.php" class="flex justify-end">';
            } else {
                echo '<a href="add.php?category_id=' . $categoryId . '" class="flex justify-end">';
            } ?>
            <button class="px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-500">
                เพิ่มข้อมูล
            </button>
            </a>
            <div class="overflow-x-auto mt-5">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <?php if (($_GET['category_id']) == '6') {
                            echo '<tr>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Name</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Category_id</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Actions</th>
                        </tr>';
                        } elseif (($_GET['category_id']) == '9') {
                            echo '<tr>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Username</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Email</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Actions</th>
                        </tr>';
                        } else {
                            echo '<tr>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Name</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Location</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Open Time</th>
                            <th class="px-6 py-4 border-b border-gray-300 font-bold">Actions</th>
                        </tr>';
                        }
                        ?>

                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">' . $row["name"] . '</td>
                                    <td class="px-6 py-4 whitespace-nowrap">' . $row["location"] . '</td>';
                                if ($row['close_time'] == "") {
                                    echo '<td class="px-6 py-4 whitespace-nowrap">' . $row["open_time"] . '</td>';
                                } else {
                                    echo '<td class="px-6 py-4 whitespace-nowrap">' . $row["open_time"] . ' น. - ' . $row["close_time"] . ' น.</td>';
                                }
                                echo '<td class="px-6 py-4 whitespace-nowrap">
                                        <div class="bordered-buttons text-2xl text-center">
                                            <a href="view.php?id=' . $row["id"] . '"><i class="icon-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                        } elseif (($_GET['category_id']) == '6') {
                            $sqlCategory2 = "SELECT * FROM category";
                            $resultCategory2 = $db->query($sqlCategory2);
                            while ($categoryRow2 = $resultCategory2->fetch_assoc()) {
                                echo '<tr>
                                    <td class="px-6 py-4 whitespace-nowrap">' . $categoryRow2["name"] . '</td>
                                    <td class="px-6 py-4 whitespace-nowrap">' . $categoryRow2["category_id"] . '</td>';
                                echo '<td class="px-6 py-4 whitespace-nowrap">
                                        <div class="bordered-buttons text-2xl text-center">
                                            <a href="view_category.php?id=' . $categoryRow2["id"] . '"><i class="icon-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                        } elseif (($_GET['category_id']) == '9') {
                            $sqlUser = "SELECT * FROM user";
                            $resultUser = $db->query($sqlUser);
                            while ($userRow = $resultUser->fetch_assoc()) {
                                echo '<tr>
                                    <td class="px-6 py-4 whitespace-nowrap">' . $userRow["username"] . '</td>
                                    <td class="px-6 py-4 whitespace-nowrap">' . $userRow["email"] . '</td>';

                                echo '<td class="px-6 py-4 whitespace-nowrap">
                                        <div class="bordered-buttons text-2xl text-center">
                                            <a href="view_user.php?id=' . $userRow["id"] . '"><i class="icon-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center" colspan="5">ไม่มีข้อมูล</td>
                            </tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="flex justify-center items-center mt-4">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <?php if ($currentpage > 1) : ?>
                        <a href="?page=<?php echo $currentpage - 1; ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <!-- Previous button -->
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9.707 5.293a1 1 0 010 1.414L7.414 9H17a1 1 0 010 2H7.414l2.293 2.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $currentpage == $i ? 'text-blue-500' : 'text-gray-700'; ?> hover:bg-gray-50">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentpage < $totalPages) : ?>
                        <a href="?page=<?php echo $currentpage + 1; ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <!-- Next button -->
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.293 14.707a1 1 0 010-1.414L12.586 11H3a1 1 0 010-2h9.586l-2.293-2.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </main>
    </div>
    
</body>

</html>