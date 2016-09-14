import angular from 'angular'

import CategoryCustomsCtrl from './controllers/CategoryCustomsCtrl'
import ItemCustomsCtrl from './controllers/ItemCustomsCtrl'
import ParseButtonCtrl from './controllers/ParseButtonCtrl'
import DocumentationsCtrl from './controllers/DocumentationsCtrl'

import AkeebaAlert from './directives/alert/Alert'

angular.module('AkeebaCustomModule', [])
// keyword parser
.controller('ParseButton', ['$http', '$q', ParseButtonCtrl])
// Category Custom Information Controller
.controller('CategoryCustomsCtrl', ['$rootScope', '$scope', '$http', CategoryCustomsCtrl])
//
.controller('ItemCustomsCtrl', ['$rootScope', '$scope', '$http', ItemCustomsCtrl])
// 
.controller('DocumentationsCtrl', ['$rootScope', '$scope', '$http', DocumentationsCtrl])
//
.directive('akeebaAlert', ['$rootScope', '$timeout', AkeebaAlert]);