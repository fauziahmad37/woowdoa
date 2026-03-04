import './bootstrap';
import '../css/custom.css';

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

import Alpine from 'alpinejs';
import { createIcons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

window.L = L;

import iconUrl from 'leaflet/dist/images/marker-icon.png';
import iconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png';
import shadowUrl from 'leaflet/dist/images/marker-shadow.png';

L.Icon.Default.mergeOptions({
    iconUrl,
    iconRetinaUrl,
    shadowUrl,
});

window.addEventListener('load', () => {
    createIcons();
});
