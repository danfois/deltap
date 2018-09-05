var key = 'AIzaSyBzvS_c1V5lQH9KZWO8A5QihgEAcYQfC1A';

var url = 'http://maps.googleapis.com/maps/api/directions/json?origin=Sennori&destination=Sassari&key=' + key;

$.getJSON(url, function(data){
    console.log(data)
});
