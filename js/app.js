angular.module('gamingPassion', []);

angular.module('gamingPassion')
.controller('PostController', ['$scope', function() {

}]);

angular.module('gamingPassion').directive('postList', function() {
    return {
        templateUrl: 'js/templates/post.html',
        controller: ['$scope', '$http', function PostController($scope, $http) {
            $scope.posts = [];
            var months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

                $http.get('api/posts').then(function(response) {
                    $scope.posts = response.data;

                    for(var key in $scope.posts){
                        var date = new Date($scope.posts[key].createdAt * 1000);

                        $scope.posts[key].formattedDate = date.getHours() + ':' + date.getMinutes() + ' on ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
                    }
                });
            }
        ]
    };
});
