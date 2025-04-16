
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css';

const initMap = async () => {
  const L = await import('leaflet');
  const { default: Geocoder } = await import('leaflet-control-geocoder');

  const markerIcon = L.divIcon({
    html: `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="25" height="41">
        <path fill="#387A00" d="M192 0C86.4 0 0 86.4 0 192c0 106.4 86.4 192 192 192s192-85.6 192-192C384 86.4 297.6 0 192 0zm0 256c-35.3 0-64-28.7-64-64s28.7-64 64-64 64 28.7 64 64-28.7 64-64 64z"/>
      </svg>
    `,
    className: 'custom-marker',
    iconSize: [25, 41],
    iconAnchor: [12, 41]
  });

  const map = L.map('map').setView([33.5138, 36.2765], 11); // Damascus coordinates

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19,
    minZoom: 3
  }).addTo(map);

  let marker = L.marker([33.5138, 36.2765], {
    draggable: true,
    icon: markerIcon
  }).addTo(map);

  const geocodeCache = new Map();

  const setLatLng = (lat, lng) => {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
  };

  const reverseGeocode = (lat, lon) => {
    const cacheKey = `${lat.toFixed(4)},${lon.toFixed(4)}`;

    if (geocodeCache.has(cacheKey)) {
      updateAddress(geocodeCache.get(cacheKey));
      return;
    }

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`)
      .then(res => res.json())
      .then(data => {
        const address = data.display_name || 'Unknown location';
        geocodeCache.set(cacheKey, address);
        updateAddress(address);
      })
      .catch(console.error);
  };

  const updateAddress = (address) => {
    const addrInput = document.getElementById('address');
    if (addrInput) addrInput.value = address;
  };

  let geocoderInitialized = false;

  const initGeocoder = () => {
    if (geocoderInitialized) return;

    const geocoder = L.Control.geocoder({
      defaultMarkGeocode: false,
      placeholder: 'Search location...',
      geocoder: L.Control.Geocoder.nominatim()
    })
    .on('markgeocode', function(e) {
      const latlng = e.geocode.center;
      map.setView(latlng, 13);
      marker.setLatLng(latlng);
      setLatLng(latlng.lat, latlng.lng);
      reverseGeocode(latlng.lat, latlng.lng);
    })
    .addTo(map);

    geocoderInitialized = true;
  };

  map.on('click', function(e) {
    if (!geocoderInitialized) initGeocoder();
    marker.setLatLng(e.latlng);
    setLatLng(e.latlng.lat, e.latlng.lng);
    reverseGeocode(e.latlng.lat, e.latlng.lng);
  });

  const lat = document.getElementById('latitude').value;
  const lon = document.getElementById('longitude').value;
  if (lat && lon) {
    const pos = [parseFloat(lat), parseFloat(lon)];
    marker.setLatLng(pos);
    map.setView(pos, 13);
    reverseGeocode(pos[0], pos[1]);
  }

  const loader = document.querySelector('#map .map-loader');
  if (loader) loader.style.display = 'none';
};

const mapElement = document.getElementById('map');
if (mapElement) {
  const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      initMap();
      observer.disconnect();
    }
  }, { threshold: 0.1, rootMargin: '200px' });

  observer.observe(mapElement);
}
