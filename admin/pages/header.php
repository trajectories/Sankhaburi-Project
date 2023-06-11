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

    .h-full {
        height: 300vh;
    }
</style>
<div class="flex flex-col lg:flex-row h-screen bg-gray-100 h-full">
    <aside class="bg-white w-full lg:w-64 shadow-lg">
        <a href="manage.php?category_id=1">
            <div class="py-6 px-8 bg-white flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Management Page</h1>
        </a>
        <button id="menu-toggle" class="block lg:hidden">
            <svg class="h-6 w-6 fill-current text-gray-700" viewBox="0 0 24 24">
                <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
</div>


<nav id="menu" class="mt-4 lg:block">
    <?php
    $sqlCategory = "SELECT * FROM category";
    $resultCategory = $db->query($sqlCategory);
    while ($categoryRow = $resultCategory->fetch_assoc()) {
    ?>
        <a href="manage.php?category_id=<?= $categoryRow['category_id'] ?>" class="flex items-center px-8 py-4 text-gray-700 hover:bg-gray-200">
            <span class="text-lg"><?= $categoryRow['name'] ?></span>
        </a>
    <?php }
    ?>
</nav>
</aside>
<script>
    const menuToggle = document.querySelector('#menu-toggle');
    const menu = document.querySelector('#menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    })
</script>