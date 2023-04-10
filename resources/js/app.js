import './bootstrap';

import Alpine from 'alpinejs';
import autoAnimate from '@formkit/auto-animate';
import collapse from '@alpinejs/collapse'
import persist from '@alpinejs/persist'

Alpine.directive('animate', el => {
  autoAnimate(el);
})

 
Alpine.plugin(persist)
 
Alpine.plugin(collapse)
window.Alpine = Alpine;

Alpine.start();
