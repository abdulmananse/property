const getStarted = document.getElementById('get_started');
const backgroundImage = document.getElementById('backgroundHomePage');
const welcome = document.getElementById('homeMobile');


getStarted.addEventListener('click', function() {
    console.log('applayBtn')
    backgroundImage.classList.add('removeImage');
    welcome.classList.add('fullHeight');

});