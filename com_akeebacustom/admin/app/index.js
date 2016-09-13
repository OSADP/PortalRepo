import angular from 'angular'

import CategoryCustomsCtrl from './controllers/CategoryCustomsCtrl'
import ItemCustomsCtrl from './controllers/ItemCustomsCtrl'
import ParseButtonCtrl from './controllers/ParseButtonCtrl'
import DocumentationsCtrl from './controllers/DocumentationsCtrl'

import AkeebaAlert from './directives/alert/Alert'

require('./akeeba.custom.js');

angular.module('AkeebaCustomModule', [])
.service('CategoryService', ['$http', function($http){
  this.getAllCategories = function() {
    return $http.get('/leidos/custom/services/ars/categories')
      .then(function( promise ) {
        return promise
      })
  }
}])
// keyword parser
.controller('ParseButton', ['$http', '$q', ParseButtonCtrl])
// Category Custom Information Controller
.controller('CategoryCustomsCtrl', ['$rootScope', '$scope', '$http', 'CategoryService', CategoryCustomsCtrl])
//
.controller('ItemCustomsCtrl', ['$rootScope', '$scope', '$http', ItemCustomsCtrl])
// 
.controller('DocumentationsCtrl', ['$rootScope', '$scope', '$http', DocumentationsCtrl])
//
.directive('akeebaAlert', ['$rootScope', '$timeout', AkeebaAlert]);