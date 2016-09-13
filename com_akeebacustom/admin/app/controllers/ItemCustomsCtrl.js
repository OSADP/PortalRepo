export default class ItemCustomsCtrl {
  constructor( $rootScope, $scope, $http ) {
    let _ctrl = this

    this.scope = $scope
    this.http = $http
    this.rootScope = $rootScope

    this.rootScope.$on('category:change', (event, category) => {
      _ctrl.getItemsByCategory( category.id )
      .then(( promise ) => {
        _ctrl.loadItemCustoms( promise.data )
      })
    })

    return this
  }

  loadItemCustoms( data ) {

  }

  getAllItems() {
    return this.http.get('/leidos/custom/services/ars/items')
  }

  getItemsByCategory( categoryId ) {
    return this.http.get('/leidos/custom/services/ars/items/category/' + categoryId)
  }

  loadItems() {
    let _ctrl = this
  }
}