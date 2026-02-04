// Modal que muestra planificar vuelo

function planFlight(destination) {
    // Abrir modal
    document.getElementById("tripModal").style.display = "flex";

    // Personalizar título y campo oculto
    document.getElementById("modal-title").innerText =
      "Planifica tu viaje a " + destination;
    document.getElementById("modal-destination").value = destination;
}

function closeModal() {
    document.getElementById("tripModal").style.display = "none";
}

// Buscador dinamico de vuelos

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const resultsDiv = document.getElementById("flight-results");

    function loadFlights(query = "") {
        fetch("search_flights.php?search=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                resultsDiv.innerHTML = data;
            });
    }

    // Cargar todos los vuelos al inicio
    loadFlights();

    // Cada vez que escriba, buscar dinámicamente
    searchInput.addEventListener("keyup", function () {
        loadFlights(this.value);
    });
});
// Datos curiosos de cada destino
const destinationData = {
    paris: {
        title: "París",
        info: "📍 Curiosidad: La Torre Eiffel fue construida en 1889 como una estructura temporal para la Exposición Universal. Hoy es uno de los monumentos más visitados del mundo."
    },
    newyork: {
        title: "New York",
        info: "🏙️ Curiosidad: La Estatua de la Libertad fue un regalo de Francia en 1886. Además, Nueva York tiene más de 8.5 millones de habitantes de casi todos los países del mundo."
    },
    tokyo: {
        title: "Tokio",
        info: "🎌 Curiosidad: Tokio es la metrópolis más poblada del planeta y mezcla lo ultra moderno con templos tradicionales. Tiene más de 160.000 restaurantes."
    }
};

function openDestinationModal(destino) {
    const modal = document.getElementById("destinationModal");
    document.getElementById("destinationTitle").textContent = destinationData[destino].title;
    document.getElementById("destinationInfo").textContent = destinationData[destino].info;
    modal.style.display = "block";
}

function closeDestinationModal() {
    document.getElementById("destinationModal").style.display = "none";
}

// Cerrar modal si se hace clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById("destinationModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
