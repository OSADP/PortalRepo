export default class DocumentationsCtrl {

  constructor( $rootScope, $scope, $http ) {
    let _ctrl = this
    _ctrl.$http = $http
    _ctrl.$scope = $scope
    _ctrl.$rootScope = $rootScope

    _ctrl.$rootScope.$on('item:change', (event, itemId) => {
      _ctrl.activeItemId = itemId
      _ctrl.getDocumentations( itemId )
    })
  }

  getDocumentations ( itemId ) {
    let _ctrl = this
    _ctrl.documentations = []
    if( ! isNaN( parseInt(itemId) )  ) {
      _ctrl.$http.post('/leidos/custom/services/extras/documentation', { itemId: itemId })
      // load documentations
      .then( promise => {
        angular.forEach(promise.data, data => {
          _ctrl.documentations.push({
            link: data.documentation_link,
            text: data.documentation_text
          })
        })
      })
    } else {
      _ctrl.documentations = []
    }
  }

  saveDocumentations ( $event ) {
    let _ctrl = this
    if( ! isNaN( parseInt(this.activeItemId) ) ) {
      let data = {
        itemId: this.activeItemId,
        links: _ctrl.documentations
      }
      _ctrl.$http.post('/leidos/custom/services/extras/documentation', data)
      .then(
        res => { // success
          _ctrl.$rootScope.$broadcast('akeeba:alert', {
            alertMessage: 'Documentations are saved..',
            successAlert: true,
            exitAlert: false
          })
        },
        err => { // failed
          _ctrl.$rootScope.$broadcast('akeeba:alert', {
            alertMessage: 'One or more Documentations are not saved. Please review your inputs..',
            successAlert: false,
            exitAlert: false
          })
        }
      )
    } else {
      _ctrl.$rootScope.$broadcast('akeeba:alert', {
        alertMessage: 'No Akeeba Items selected..',
        successAlert: false,
        exitAlert: false
      })
    }
  }

  addDocumentation () {
    let _ctrl = this
    if( _ctrl.documentations.length < 8 )
      _ctrl.documentations.push({
        documentation_link: '',
        documentation_text: ''
      })
    else 
      _ctrl.$rootScope.$broadcast('akeeba:alert', {
        alertMessage: 'Maximum number of Documentaions(8) is reached.',
        successAlert: false,
        exitAlert: false
      })
  }

  removeDocumentation ( $event, id, hashKey ) {
    let _ctrl = this

    angular.forEach(_ctrl.documentations, ( documentation, index ) => {
      if( id && documentation.id == id ) {
        _ctrl.documentations.splice( index, 1 );
      } else if( documentation.$$hashKey == hashKey ) {
        _ctrl.documentations.splice( index, 1 );
      }
    })
  }

}