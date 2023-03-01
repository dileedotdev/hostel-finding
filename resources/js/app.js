import './bootstrap';
import { useGoogleMaps } from './use-google-maps';
import { createHtmlMapMarker } from './create-html-map-marker';
import { executeRecaptchaV3 } from './execute-recaptcha-v3';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import Focus from '@alpinejs/focus';
import Chart from 'chart.js/auto';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm';
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm';

Alpine.plugin(mask);
Alpine.plugin(NotificationsAlpinePlugin);
Alpine.plugin(Focus);
Alpine.plugin(FormsAlpinePlugin);
window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;
window.Alpine = Alpine;
window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;
window.Chart = Chart;
window.executeRecaptchaV3 = executeRecaptchaV3;

Alpine.start();
