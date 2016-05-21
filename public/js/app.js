var app = angular.module("app", []);

app.controller('RecipeController', ['$scope','$http', function($scope, $http) {
    $scope.http = $http;
    $scope.ingredients = "";
    $scope.findSecondary = function () {
        $('#continue').prop('disabled',true);
        $scope.http.post(window.location.pathname +'findSecondary', {ingredients: $scope.ingredients}).success(function (data) {
            if(data['error']){
                notificar(datas['message']);
            }else {
                $scope.secondary = data.secondary;//así enviamos los posts a la vista
                $('#choose-principal-ingredients').hide();
                $('#select-principal-ingredients').hide();
                $('#tags').hide();
                $('#button').empty();
                $('#count-results').show();
                $('#choose-secondary-ingredients').show();
                $('#select-secondary-ingredients').show();
                $('#buttonFindSuggestions').show();
                $('#empezar').show();
                $('#o').show();
                $('.select2-selection').css('border-width', 1);
                $('.select2-selection').css('border-color', 'rgb(255,035,001)');
                notificar("Se han encontrado " + data['num_recipes'] + " recetas con estos ingredientes principales." +
                    " Índicanos algunos ingredientes adicionales para saber si puedes cocinarlas");
            }

        });
    }
}]);
