angular.module('gamingPassion').factory('RetrievePostsService', function($http) {

    var months = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var getAll = function() {

        return $http.get('api/posts').then(function(response) {

            var parsedResponse = response.data;

            for(var key in parsedResponse){
                var date = new Date(parsedResponse[key].createdAt * 1000);

                parsedResponse[key].formattedDate = date.getHours() + ':' + date.getMinutes() + ' on ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
            }

            return parsedResponse;
        });
    };

    var getForCategory = function(category) {

        return $http.get('api/posts/' + category).then(function(response) {

            var parsedResponse = response.data;

            for(var key in parsedResponse){
                var date = new Date(parsedResponse[key].createdAt * 1000);

                parsedResponse[key].formattedDate = date.getHours() + ':' + date.getMinutes() + ' on ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
            }

            return parsedResponse;
        });
    };

    var getArchived = function() {

        return $http.get('api/posts/archive').then(function(response) {

            var parsedResponse = response.data;

            for(var key in parsedResponse){
                var date = new Date(parsedResponse[key].createdAt * 1000);

                parsedResponse[key].formattedDate = date.getHours() + ':' + date.getMinutes() + ' on ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
            }

            return parsedResponse;
        });
    };

    return {
        getAll: getAll,
        getForCategory: getForCategory,
        getArchived: getArchived
    };
});