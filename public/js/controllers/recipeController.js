app.controller("recipeController", function($scope,$http)
{
    $http.get(window.location.pathname+'/findSecondary').success(function(data)
    {
        $scope.datos = data.posts;//as� enviamos los posts a la vista
    });
})
