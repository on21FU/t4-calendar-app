import './bootstrap';
import './calendar';

import Alpine from 'alpinejs';
import { test } from './calendar';
test();
console.log("hallo");

window.Alpine = Alpine;


Alpine.start();
