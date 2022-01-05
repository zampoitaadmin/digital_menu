bbAppServices.factory('categoryService', ['Restangular', 'userService', function(Restangular, userService) {

    function getAll(onSuccess, onError){
        Restangular.all('api/categories').customGET(appLanguage).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }
    function getAllOnlyByUser(onSuccess, onError){
        Restangular.all('api/categories-user').customGET(appLanguage).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function getUserSelectedCategories(onSuccess, onError){
        Restangular.all('api/user-selected-categories').customGET(appLanguage).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function getAllAllergies(onSuccess, onError){
        Restangular.all('api/all-allergies').customGET(appLanguage).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);

        });
    }

    function create(data, onSuccess, onError){
        Restangular.all('api/categories').post(data).then(function(response){

            onSuccess(response);

        }, function(response){

            onError(response);

        });
    }

    function remove(id, appLanguage, onSuccess, onError){
        Restangular.one('api/categories/'+id+'/'+appLanguage).remove().then(function(response){

            onSuccess(response);

        }, function(response){

            onError(response);

        });
    }


    function update(id, data, onSuccess, onError){
        Restangular.one("api/categories").customPUT(data, id).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }


    function updateUserCategoryOrder(data, onSuccess, onError){
        Restangular.all("api/categories/update-user-category-order").post(data).then(function(response) {
                onSuccess(response);
            }, function(response){
                onError(response);
            }
        );
    }


    function assignCategory(data, onSuccess, onError){
        Restangular.all('api/categories/assign').post(data).then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }
    /* OLD REF */
    function getById(bookId, onSuccess, onError){
        Restangular.one('api/books', bookId).get().then(function(response){
            onSuccess(response);
        }, function(response){
            onError(response);
        });
    }

    Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

    return {
        getAll: getAll,
        getAllOnlyByUser: getAllOnlyByUser,
        getUserSelectedCategories: getUserSelectedCategories,
        getById: getById,
        create: create,
        update: update,
        remove: remove,
        assignCategory: assignCategory,
        updateUserCategoryOrder: updateUserCategoryOrder,
        getAllAllergies: getAllAllergies
    }

}]);