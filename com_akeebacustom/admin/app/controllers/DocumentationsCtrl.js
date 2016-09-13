import $ from 'jquery'
import angular from 'angular'

export default class DocumentationsCtrl {

  constructor( $rootScope, $scope, $http ) {
    let _ctrl = this
    _ctrl.http = $http
    _ctrl.scope = $scope
    _ctrl.rootScope = $rootScope

    $('#akeebaApplications').on('ready, app:change', ( event, data ) => {
      _ctrl.getDocumentations( data.itemId )
    })
  }

  getDocumentations ( itemId ) {
    let _ctrl = this
    _ctrl.documentations = []
    if( ! isNaN( itemId ) ) {
      _ctrl.http.post('/leidos/custom/services/extras/documentation', { itemId: itemId })
      // load documentations
      .then(( promise ) => {
        angular.forEach(promise.data, ( data ) => {
          _ctrl.documentations.push({
            link: data.documentation_link,
            text: data.documentation_text
          })
        })
      })
    }
    _ctrl.scope.$apply();
  }

  saveDocumentations ( $event ) {
    let _ctrl = this
    let itemId = parseInt( $('#akeebaApplications').val() )
    if( ! isNaN( itemId ) ) {
      let data = {
        itemId: itemId,
        links: _ctrl.documentations
      }
      _ctrl.http.post('/leidos/custom/services/extras/documentation', data)
      .then(
        (res)=> { // success
          console.log(res);
          _ctrl.rootScope.$broadcast('akeeba:alert', {
            alertMessage: 'Documentations are saved..',
            successAlert: true,
            exitAlert: false
          })
        },
        (err)=> { // failed
          console.log(err);
          _ctrl.rootScope.$broadcast('akeeba:alert', {
            alertMessage: 'One or more Documentations are not saved. Please review your inputs..',
            successAlert: false,
            exitAlert: false
          })
        }
      )
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
      alert('Maximum number of Documentaions(8) is reached.')
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