
/**
*  View Controller
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
//
.controller('ViewCtrl', ['$rootScope', '$scope', ViewCtrl])

function ViewCtrl ( $rootScope, $scope ) {
	$rootScope.$on('application:visible', function() {
		$scope.width = 'col-xs-12';
	})
	$rootScope.$on('application:hidden', function() {
		$scope.width = 'col-xs-12 col-md-8';
	})
}