/**
* Paginate Module
*
* Description
*/
angular.module('PaginateService', [])

.service('Paginatr', ['', function(){
  var service = this;
  /**
   * Emulates pagination of an Array list
   * @param  {array} items Array to paginate
   * @param  {int} limit Number of items per page
   * @return {array}       Multidimensional Array of paginated items
   */
  service.paginate = function( items, limit ) {
    if( limit != 'all' ) {
      var parsedItem = [];
      var x = 0;
      angular.forEach( items , function( stuff, index ) {
        parsedItem[x] = parsedItem[x] || [];
        parsedItem[x].push( stuff );
        if( items.length > limit )
          if( (index + 1) % limit == 0 ) {
            x += 1;
          }
      })
      return parsedItem;
    } else {
      if( items.length == 0 )
        return items;
      else
        return [items];
    }
  }

  return service;
}])