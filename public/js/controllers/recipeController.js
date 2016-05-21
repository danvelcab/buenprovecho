app.controller("recipeController", function($scope,$http)
{
    $http.get(window.location.pathname+'/findSecondary').success(function(data)
    {
        $scope.datos = data.posts;//así enviamos los posts a la vista
    });
})
