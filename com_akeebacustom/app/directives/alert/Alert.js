export default function AkeebaAlert ($rootScope, $timeout) {
  // Runs during compile
  return {
    restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
    templateUrl: '/administrator/components/com_akeebacustom/app/directives/alert/template.ng.html',
    link: function($scope, iElm, iAttrs, controller) {
      // add ability to cancel $timeout by caching 
      // the promise returned by $timeout
      let autohide = {}
      // display alert when a broadcast is received
      $rootScope.$on('akeeba:alert', ( event, message ) => {
        $scope.exitAlert = message.exitAlert
        $scope.successAlert = message.successAlert
        $scope.alertMessage = message.alertMessage
        // cancel timeout whenever a new alert is broadcasted
        $timeout.cancel(autohide)
        // automatically hide our alerts
        if( message.exitAlert === false ) {
          autohide = $timeout(() => {
            $scope.exitAlert = true
          }, 5000)
        }
      })

    }
  }
}