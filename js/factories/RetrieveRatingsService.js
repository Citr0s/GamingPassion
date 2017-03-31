angular.module('gamingPassion').factory('RetrieveRatingsService', function($http) {

    var getAllFor = function(postId) {

        return $http.get('api/ratings/' + postId).then(function (response) {

            var parsedData = response.data;

            parsedData.average = response.data.average === null ? 0 : response.data.average;
            parsedData.count = response.data.ratings === null ? 0 : response.data.ratings.length;

            return parsedData;
        });
    };

    return { getAllFor: getAllFor };
});