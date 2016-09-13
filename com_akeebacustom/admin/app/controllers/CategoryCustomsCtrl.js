export default class CategoryCustomsCtrl {
  constructor( $rootScope, $scope, $http, service ) {
    let _ctrl = this

    this.scope = $scope
    this.http = $http
    this.rootScope = $rootScope

    service.getAllCategories().then(function(promise) {
      _ctrl.categories =  promise.data ? promise.data : []
    })

    return this
  }

  changeActive( $event ) {
    let _ctrl = this

    _ctrl.categories.forEach(function(category) {
      if( category.id == _ctrl.select ) {
        _ctrl.active = category
      } else if( _ctrl.select === 'all' ) {
        _ctrl.active = undefined
      }
    })

    _ctrl.rootScope.$broadcast('category:change', _ctrl.active)

    return this
  }

  saveCategoryInfo( $event ) {
    let _ctrl = this

    if( _ctrl.select !== 'all' ) {
      _ctrl.http.post('/leidos/custom/services/extras/category', {
      categoryId: _ctrl.active.id,
      iconUrl: _ctrl.active.icon_url
      })
      .then(function( promise ) {
        if( promise.data.trim() == '1' ) {
          _ctrl.rootScope.$broadcast('akeeba:alert', {
            alertMessage: 'Category icon saved...',
            successAlert: true,
            exitAlert: false
          })
        }
      })
    }
  }
}