<?php
    $HTML_TABS = '<button data-categoria="*" class="categoria-tab px-4 py-0 rounded-full border border-green-500 bg-green-50 text-green-600 font-medium text-xs flex-shrink-0 flex items-center"> Todo </button>';

    $query = "SELECT DISTINCT(categoria) FROM retos ORDER BY categoria ASC";
    $result = mysqli_query($conn, $query);

    while($reto = mysqli_fetch_assoc($result)) {
        $categoria = htmlspecialchars($reto['categoria']);
        $HTML_TABS .= '<button data-categoria="'.$categoria.'" class="categoria-tab px-4 py-0 rounded-full border border-gray-300 text-gray-600 font-medium text-xs flex-shrink-0 flex items-center"> '.htmlspecialchars($reto['categoria']).' </button>';
    }
?>

<div class="m-1">
    <div class="flex overflow-x-auto whitespace-nowrap scrollbar-hide space-x-2 py-1">
        <!-- Categorías inactivas -->
        <?php echo $HTML_TABS; ?>
    </div>
</div>

<!-- Opcional: CSS para ocultar la scrollbar (añadir a tu CSS) -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .categoria-tab {
        transition: background-color 0.3s, color 0.3s;
    }

    .categoria-tab.active {
        border-color: #22c55e; /* green-500 */
        background-color: #ecfdf5; /* green-50 */
        color: #16a34a; /* green-600 */
    }

    .categoria-tab:not(.active) {
        border-color: #d1d5db; /* gray-300 */
        background-color: white;
        color: #4b5563; /* gray-600 */
    }
</style>
