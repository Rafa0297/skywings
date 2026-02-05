// /**
//  * SkyWings - Gestión Dinámica de la Interfaz
//  */
// // BUSCADOR DINÁMICO DE VUELOS (SOLO EN PÁGINA DE VUELOS)
// document.addEventListener('DOMContentLoaded', function () {
//   const searchInput = document.getElementById('search')
//   const resultsDiv = document.getElementById('flight-results')

//   // Solo ejecutamos si estamos en la página que tiene el buscador
//   if (searchInput && resultsDiv) {
//     function loadFlights(query = '') {
//       // CAMBIO CLAVE: Ahora apuntamos a la ruta del Router, no al archivo .php
//       fetch('/api/search-flights?search=' + encodeURIComponent(query))
//         .then((response) => {
//           if (!response.ok) throw new Error('Error en la red')
//           return response.text()
//         })
//         .then((data) => {
//           resultsDiv.innerHTML = data
//         })
//         .catch((error) => console.error('Error cargando vuelos:', error))
//     }

//     // Cargar inicial
//     loadFlights()

//     // Búsqueda en tiempo real
//     searchInput.addEventListener('keyup', function () {
//       loadFlights(this.value)
//     })
//   }
// })
