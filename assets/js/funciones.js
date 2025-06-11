class Site {
    constructor() {
        this.initCategoriaTabs();
    }

    // ⭐ Valoración por estrellas
    handleStarClick(element) {
        const valor   = element.getAttribute('data-valor');
        const id_reto = element.getAttribute('data-reto');

        
        fetch('modulos/retos/valorar_retos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json' // Indicamos que queremos recibir JSON
            },
            body: `valor=${encodeURIComponent(valor)}&id_reto=${encodeURIComponent(id_reto)}`
        })
        .then(res => res.json()) // Parseamos la respuesta como JSON
        .then(data => {
            console.log(data);
            if (data.status === 'OK') { // Ahora verificamos una propiedad del objeto JSON
                location.reload();
            } else {
                window.location.href = 'login.php?error=1';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    initCategoriaTabs() {
        document.querySelectorAll('.categoria-tab').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.handleCategoriaTabClick(e.currentTarget);
            });
        });
    }

    handleCategoriaTabClick(button) {
        // Cambiar visualmente el activo
        document.querySelectorAll('.categoria-tab').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');

        const categoria = button.getAttribute('data-categoria');

        // Lógica para filtrar los retos
        document.querySelectorAll('.reto-card').forEach(card => {
            const cat = card.getAttribute('data-categoria');
            if (categoria === '*' || cat === categoria) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    

    
}