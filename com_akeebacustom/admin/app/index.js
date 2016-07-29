require('./akeeba.custom.js');
require('./keyword.tagging.js');

(function() {
  var angular = require('angular')
  angular.module('AkeebaCustomModule', [])
  .service('CategoryService', ['$http', function($http){
    this.getAllCategories = function() {
      return $http.get('/leidos/custom/services/ars/categories')
        .then(function( promise ) {
          return promise
        })
    }
  }])
  .controller('CategoryCustomsCtrl', ['$scope', 'CategoryService', CategoryCustomsCtrl])


  function CategoryCustomsCtrl( $scope, service ) {
    const ctrl = this
    service.getAllCategories().then(function(promise) {
      ctrl.categories = promise.data ? promise.data : []
      console.log(promise.data);
    })

    ctrl.changeActive = function($event) {
      ctrl.categories.forEach(function(category) {
        if( category.id == ctrl.select ) {
          ctrl.active = category
        } else if( ctrl.select === 'all' ) {
          ctrl.active = undefined
        }
      })
    }
  }
})()