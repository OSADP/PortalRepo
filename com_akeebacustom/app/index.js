import angular from 'angular'
import CategoryCustomsCtrl from './controllers/CategoryCustomsCtrl'
import ItemCustomsCtrl from './controllers/ItemCustomsCtrl'
import ParseButtonCtrl from './controllers/ParseButtonCtrl'
import DocumentationsCtrl from './controllers/DocumentationsCtrl'
import AkeebaAlert from './directives/alert/Alert'

angular.module('AkeebaCustomModule', [])
// keyword parser
.controller('ParseButton', ['$http', '$q', ParseButtonCtrl])
// Akeeba Categories controller
.controller('CategoryCustomsCtrl', ['$rootScope', '$scope', '$http', CategoryCustomsCtrl])
// Akeeba Items controller
.controller('ItemCustomsCtrl', ['$rootScope', '$scope', '$http', ItemCustomsCtrl])
// Akeeba Items custom Documentations controller
.controller('DocumentationsCtrl', ['$rootScope', '$scope', '$http', DocumentationsCtrl])
// custom alert directive
.directive('akeebaAlert', ['$rootScope', '$timeout', AkeebaAlert]);