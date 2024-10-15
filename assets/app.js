import './styles/app.css';

import { createApp } from 'vue';
import BidCalculation from './components/BidCalculation.vue';

const app = createApp({});
app.component('bid-calculation', BidCalculation);
app.mount('#vue-app');