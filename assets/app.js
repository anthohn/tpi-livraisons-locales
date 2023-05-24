/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Initialize the Google Maps address search component
var autocomplete = new google.maps.places.Autocomplete(
    document.querySelector('.address-autocomplete'),
    { types: ['geocode'] }
);


// Listen for address select event and update form fields
autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    document.querySelector('#address_addCity').value = place.address_components[2].long_name;
    document.querySelector('#address_addPc').value = place.address_components[6].long_name;
    document.querySelector('#address_addCountry').value = place.address_components[5].long_name;
    document.querySelector('#address_addLatitude').value = place.geometry.location.lat();
    document.querySelector('#address_addLongitude').value = place.geometry.location.lng();
});
