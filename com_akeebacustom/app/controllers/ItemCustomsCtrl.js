export default class ItemCustomsCtrl {
  constructor( $rootScope, $scope, $http ) {
    this.$scope = $scope
    this.$http = $http
    this.$rootScope = $rootScope

    this.getAllItems().then( promise => {
      this.loadItemCustoms( promise.data )
    })

    $rootScope.$on('category:change', (event, categoryId) => {
      this.getItemsByCategory( categoryId )
      .then( promise => {
        this.loadItemCustoms( promise.data )
      })
    })

    return this
  }

  loadItemCustoms( data ) {
    this.items = data;
    this.activeItem = data[0]
    this.changeActiveItem()
  }

  getAllItems() {
    return this.$http.get('/leidos/custom/services/ars/items')
  }

  getItemsByCategory( categoryId ) {
    if( categoryId === 'all' )
      return this.getAllItems()
    else
      return this.$http.get('/leidos/custom/services/ars/items/category/' + categoryId)
  }

  changeActiveItem() {
    this.$rootScope.$broadcast('item:change', ( this.activeItem ) ? this.activeItem.id : '')
  }

  saveItemCustoms() {
    this.activeItem.keywords = this.activeItem.keywords.split(', ').join()
    let { id, icon_url, short_description, discussion_url, issues_url, keywords } = this.activeItem
    let data = { itemId: id, iconUrl: icon_url, shortDescription: short_description, mainDiscussion: discussion_url, issuesDiscussion: issues_url, keywords }
    this.$http.post('/leidos/custom/services/extras/item', data)
    .then(
      res => { // success
        this.$rootScope.$broadcast('akeeba:alert', {
          alertMessage: 'Item Customizations are saved..',
          successAlert: true,
          exitAlert: false
        })
      })
  }
}