<?php include_once 'control/db.php'; ?>
<?php include_once 'control/csrf.php'; ?>

<?php 
    // if (!isset($_SESSION['user_id'])) header("Location: login.php");
    $TITLE_PAG = "GoodMission:: Retos"; 
?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

    <div class="max-w-md mx-auto">
        <!-- BUSCADOR -->
        <div class="flex rounded-lg overflow-hidden shadow-md">
            <input type="search" id="busqueda" type="text" class="flex-grow px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="¿Qué necesitas encontrar?" />
        </div>
    </div>

    <!-- SCROLL CATEGORIAS -->
    <?php include_once 'includes/tabs.php'; ?>

    <!-- Contenedor para mostrar los retos -->
    <div id="retos-container" class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 px-2">
        <!-- Aquí se insertan los retos con AJAX -->
        <div id="retos-loader" class="w-full flex justify-center py-4">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-10 w-10"></div>
        </div>
    </div>

    <!-- Controles de paginación -->
    <div id="paginacion" class="flex justify-between px-2 mt-2 text-sm"></div>

    <script>
        // Esperar a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function () {
            const container   = document.getElementById('retos-container');
            const paginacion  = document.getElementById('paginacion');
            const searchInput = document.getElementById('busqueda');

            let categoria = '*';
            let pagina    = 1;
            let search    = '';

            function cargarRetos() {
                const contenedor = document.getElementById('retos-container');
                contenedor.innerHTML = `
                    <div id="retos-loader" class="w-full col-span-full flex justify-center py-4">
                        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-10 w-10"></div>
                    </div>`;

                const formData = new FormData();
                formData.append('categoria', categoria);
                formData.append('pagina', pagina);
                formData.append('busqueda', search);

                fetch('modulos/retos/cargar_retos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = data.html;
                    paginacion.innerHTML = `
                        <button ${pagina === 1 ? 'disabled' : ''} class="anterior text-blue-600">← Anterior</button>
                        <button ${data.ultima ? 'disabled' : ''} class="siguiente text-blue-600">Siguiente →</button>
                    `;
                });
            }

            // Click en categoría
            document.querySelectorAll('.categoria-tab').forEach(btn => {
                btn.addEventListener('click', () => {
                    categoria = btn.getAttribute('categoria-tab') === 'all' ? '' : btn.getAttribute('data-categoria');
                    pagina = 1;
                    cargarRetos();
                });
            });

            // Búsqueda por título o ubicación
            searchInput.addEventListener('input', () => {
                search = searchInput.value;
                pagina = 1;
                cargarRetos();
            });

            // Paginación
            paginacion.addEventListener('click', e => {
                if (e.target.classList.contains('anterior') && pagina > 1) {
                    pagina--;
                    cargarRetos();
                } else if (e.target.classList.contains('siguiente')) {
                    pagina++;
                    cargarRetos();
                }
            });

            // Cargar retos al inicio
            cargarRetos();
        });

    </script>

<?php include_once 'includes/menu.php'; ?>
<?php include_once 'includes/footer.php'; ?>
