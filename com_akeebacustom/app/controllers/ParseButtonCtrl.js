


export default class ParseButtonCtrl {

  constructor( $http, $q ) {
    this.http = $http
    this.q = $q
  }

  parseKeywords() {
    let _ctrl = this
    let confirm = window.confirm('Parse ALL keywords for ALL applications?');

    if( confirm ) {
      let promises = [];
      // retrieve all item data
      _ctrl.http.get('/leidos/custom/services/ars/items')
      // then parse every item's keywords
      .then(function( promise ) {
        let items = promise.data;
        if( items == undefined ) return false;

        angular.forEach(items, function( item, index ) {
          let keywords = item.keywords.toLowerCase().trim().split(',');
          keywords = keywords.map(function( keyword ) {
            return keyword.trim();
          })
          item.keywords = keywords.join();
          let promise = _ctrl.http.post('/leidos/custom/services/extras/keywords', {
            itemId: item.id,
            keywords: item.keywords
          })
          promises.push( promise )
        })
        return _ctrl.q.all( promises )
      })
      // then alert the user after all items are parsed
      .then(function() {
        alert('Application Keyword Parsing Complete!');
      })

    }
  }

}