<!-- header -->
<header class="bg-black shadow">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <nav class="flex justify-between items-center">
            <a href="v_home.php">
                <h1 class="text-5xl mt-5 font-semibold text-white">จังหวัดชัยนาท</h1>
            </a>
            <div class="flex mt-7">
                <form id="search-form" class="relative w-48" action="search.php" method="GET">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 absolute left-2.5 top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.818a1 1 0 01-1.414 1.414l-4.818-4.817A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <input type="text" name="search" placeholder="Search..." class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500" />
                    <button type="submit" class="hidden">Search</button>
                </form>
                <button id="burger-menu" class="block lg:hidden focus:outline-none">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>
        <nav class="mt-4 flex justify-end hidden lg:flex">
            <ul class="flex space-x-4">
                <!-- ดึงข้อมูลจาก table category มาใช้เป็นเมนู -->
                <?php
                $sqlCategory = "SELECT * FROM category WHERE category_id NOT IN (5,6,7,8,9)";
                $resultCategory = $db->query($sqlCategory);
                $categoryRow = $resultCategory->fetch_assoc();
                foreach ($resultCategory as $categoryRow) {
                ?>
                    <a href="v_attraction.php?category_id=<?= $categoryRow['category_id'] ?>" class="text-white hover:text-indigo-500
                <?php if ($category_id === $categoryRow['category_id']) echo ' border-b-2 border-white'; ?>">
                        <?= $categoryRow['name'] ?>
                    </a>
                <?php } ?>
            </ul>
        </nav>
        <!-- เพิ่ม div สำหรับ burger menu -->
        <div id="mobile-menu" class="hidden lg:hidden mt-3">
            <ul class="flex flex-col space-y-4">
                <?php
                $sqlCategory = "SELECT * FROM category WHERE category_id NOT IN (5,6,7,8,9)";
                $resultCategory = $db->query($sqlCategory);
                $categoryRow = $resultCategory->fetch_assoc();
                foreach ($resultCategory as $categoryRow) {
                ?>
                    <a href="v_attraction.php?category_id=<?= $categoryRow['category_id'] ?>" class="text-white hover:text-indigo-500
                <?php if ($category_id === $categoryRow['category_id']) echo ' border-b-2 border-white'; ?>">
                        <?= $categoryRow['name'] ?>
                    </a>
                <?php } ?>

            </ul>
        </div>
    </div>

</header>
<!-- เปิดปิด burger menu -->
<script>
    document.getElementById('burger-menu').addEventListener('click', function() {
        var mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
        }
    });
</script>