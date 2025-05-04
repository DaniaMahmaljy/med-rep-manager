import 'leaflet/dist/leaflet.css';

let mapInitialized = false;

export function initRepresentativeMap() {
    const mapElement = document.getElementById('representativeMap');
    if (!mapElement || mapInitialized) return;

    mapElement.innerHTML = `
        <div class="map-loader d-flex justify-content-center align-items-center" style="height: 100%">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading map...</p>
            </div>
        </div>
    `;

    const lat = parseFloat(mapElement.dataset.lat);
    const lng = parseFloat(mapElement.dataset.lng);
    const address = mapElement.dataset.address;
    const isArabic = document.documentElement.lang === 'ar';

    if (!lat || !lng) {
        showMapError(mapElement, isArabic ? 'لا توجد إحداثيات متاحة' : 'No coordinates available');
        return;
    }

    import('leaflet').then(L => {
        try {
            const mapOptions = {
                zoomControl: false,
                fadeAnimation: true
            };

            if (isArabic) {
                mapOptions.rtl = true;
                const rtlCSS = document.createElement('link');
                rtlCSS.rel = 'stylesheet';
                rtlCSS.href = 'https://cdn.jsdelivr.net/npm/leaflet-rtl@1.0.0/dist/leaflet.rtl.css';
                document.head.appendChild(rtlCSS);
            }

            mapElement.innerHTML = '<div style="height: 100%; width: 100%;"></div>';

            const map = L.map(mapElement.firstChild, mapOptions).setView([lat, lng], 13);

            const attribution = isArabic
                ? 'خرائط &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                : 'Maps &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution,
                maxZoom: 19
            }).addTo(map);

            const icon = L.divIcon({
                html: `<div class="relative">
                         <svg viewBox="0 0 384 512" width="30" height="46">
                           <path fill="${isArabic ? '#4CAF50' : '#6C63FF'}" d="M192 0C86.4 0 0 86.4 0 192c0 106.4 86.4 192 192 192s192-85.6 192-192C384 86.4 297.6 0 192 0zm0 256c-35.3 0-64-28.7-64-64s28.7-64 64-64 64 28.7 64 64-28.7 64-64 64z"/>
                         </svg>
                         <div class="absolute inset-0 rounded-full bg-black opacity-10 blur-sm"></div>
                       </div>`,
                className: '',
                iconSize: [30, 46],
                iconAnchor: [15, 46]
            });

            const popupContent = isArabic
                ? `<div class="leaflet-popup-content p-1" style="direction: rtl; text-align: right; font-family: Tahoma, Arial;">
                     <strong>الموقع</strong><br>${address}
                   </div>`
                : `<div class="leaflet-popup-content p-1">
                     <strong>Location</strong><br>${address}
                   </div>`;

            L.marker([lat, lng], { icon })
                .addTo(map)
                .bindPopup(popupContent)
                .openPopup();

            L.control.zoom({
                position: isArabic ? 'topleft' : 'topright'
            }).addTo(map);

            mapInitialized = true;

        } catch (error) {
            console.error('Map init error:', error);
            showMapError(mapElement, isArabic ? 'فشل تحميل الخريطة' : 'Failed to load map');
        }
    }).catch(() => {
        showMapError(mapElement, isArabic ? 'فشل تحميل مكتبة الخرائط' : 'Map library failed to load');
    });

    function showMapError(element, message) {
        element.innerHTML = `
            <div class="map-error d-flex justify-content-center align-items-center" style="height: 100%">
                <div class="text-center">
                    <div class="alert alert-danger">
                        ${message}
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="window.initRepresentativeMap()">
                            ${isArabic ? 'إعادة المحاولة' : 'Retry'}
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}

const locationTab = document.getElementById('location-tab');
if (locationTab) {
    locationTab.addEventListener('shown.bs.tab', initRepresentativeMap);
}
