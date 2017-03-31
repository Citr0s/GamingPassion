angular.module('gamingPassion').directive('postList', function() {

    return {
        scope: {
            category: "@"
        },
        templateUrl: 'js/templates/Post.html',
        controller: ['$scope', '$q', 'RetrievePostsService', 'RetrieveRatingsService', function PostController($scope, $q, RetrievePostsService, RetrieveRatingsService) {

            var postService = null;

            if($scope.category === undefined)
                postService = RetrievePostsService.getAll();
            else if($scope.category === 'archive')
                postService = RetrievePostsService.getArchived();
            else
                postService = RetrievePostsService.getForCategory($scope.category);

            postService.then(function(data){

                $scope.posts = data;

                var indexes = [];

                for(var key in data){
                    indexes.push(data[key].id)
                }

                getRatings(0, indexes[0], indexes, data.length);

                function getRatings(index, actualIndex, indexes, toDo){

                    if(index === toDo)
                        return;

                    RetrieveRatingsService.getAllFor(actualIndex).then(function(data){

                        $scope.posts[index].ratings = data;
                        ++index;
                        getRatings(index, indexes[index], indexes, toDo);
                    });
                }
            });
        }]
    };
});