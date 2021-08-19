require('./bootstrap');

require('alpinejs');

require('particles.js');

particlesJS.load('particles-js', 'js/particles.json', function() {
    console.log('callback - particles-js config loaded');
});
