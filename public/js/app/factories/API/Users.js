__Wooter.factory('Users', ['$http', function($http){
    
    var users = {};
    var $this = users;
    
    users.data;
    
    /*
     * Get user by id
     * @param id
     */
    
    users.getUserById = function(id) {
        var url = 'api/users/' + id;
        return $http.get(url)
                    .success(function(response){
                        $this.data = response.data;
               });
    };
    
    users.getUserActivities = function(id) {
        //
    };
    
    users.getUserNotifications = function() {
        //
    };
 
    return users;
     
}]);
