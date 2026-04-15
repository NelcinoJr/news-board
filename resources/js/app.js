import './bootstrap';
import { createApp } from 'vue';
import NewsBoard from './components/NewsBoard.vue';

const app = createApp({});

app.component('news-board', NewsBoard);

app.mount('#app');
