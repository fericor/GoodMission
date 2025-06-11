    </div>

    <!-- Funciones de la aplicación -->
    <script src="assets/js/funciones.js"></script>
    <script>
        // Inicialización global para uso en eventos inline como onclick="app.handleStarClick(this)"
        const app = new Site();

        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById('noti-btn');
            const dropdown = document.getElementById('noti-dropdown');
            const list = document.getElementById('noti-list');

            btn.addEventListener('click', () => {
                dropdown.classList.toggle('hidden');

                // Cargar notificaciones vía AJAX solo si está visible
                if (!dropdown.classList.contains('hidden')) {
                    fetch('modulos/notificaciones/notificaciones_ajax.php')
                        .then(res => res.text())
                        .then(html => {
                            list.innerHTML = html;
                        });
                }
            });

            // Cerrar al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!document.getElementById('noti-container').contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        document.addEventListener("click", (e) => {
            if (e.target.closest('.noti-item')) {
                const item = e.target.closest('.noti-item');
                const id = item.dataset.id;

                fetch('modulos/notificaciones/marcar_leida.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(res => res.text())
                .then(resp => {
                    if (resp.trim() === 'ok') {
                        item.classList.add('bg-gray-100', 'text-gray-400'); // estilo de leída
                        item.classList.remove('hover:bg-gray-50');
                    }
                });
            }
        });

        function actualizarContador() {
            fetch('modulos/notificaciones/contador_notificaciones.php')
                .then(res => res.text())
                .then(html => {
                    document.querySelector('#noti-btn span')?.remove();
                    if (parseInt(html) > 0) {
                        const span = document.createElement('span');
                        span.className = "absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center";
                        span.textContent = html;
                        document.getElementById('noti-btn').appendChild(span);
                    }
                });
        }


    </script>
</body>
</html>