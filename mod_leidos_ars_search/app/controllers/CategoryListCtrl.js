'use strict';
/**
*  Akeeba Category List Controller
*
* Description
* This generates the category list based on data
* from ARS.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('CategoryListCtrl', ['$rootScope', '$scope', '$timeout', '$http', '$location', 'AkeebaService', CategoryListCtrl])

function CategoryListCtrl ( $rootScope, $scope, $timeout, $http, $location, AkeebaService ) {
  $scope.categories = [];
  // populate our category list with items from the ARS database
  AkeebaService.getAllCategories()
  .then( function( data ) {
    $scope.categories = data;
    // create All Applications category as it's not part of the
    // Akeeba Release System database
    if( $scope.categories.length > 0 ) {
      $scope.currentCategory = {
        title: 'All Active Releases',
        id: 'all',
        icon_url: '/modules/mod_leidos_ars_search/images/osadp-logo-blue.png',
        icon_url_alt: '/modules/mod_leidos_ars_search/images/osadp-logo-white.png'
      }
      // unshift() adds object to the beginning of the array
      $scope.categories.unshift( $scope.currentCategory );
    }
    // grab current category id from the url path to select
    // current category on page load/refresh
    setActiveOnLoad( $scope.categories );
    // this is our event for changing active/current category
    $scope.categoryChange = function() {
      $scope.currentCategory.active = false;
      $scope.currentCategory = this.category;
      $scope.currentCategory.active = true;
    }
    // this will show how many applications are under each category
    // TODO: This should probably be part of the data from the category
    // web service.
    AkeebaService.getAllItems()
    .then( function( _items ) {
      // var _items = promise.data;
      angular.forEach( $scope.categories, function( category ) {
        category.items = [];
        if( category.id == 'all' ) category.items = _items;
        angular.forEach( _items, function( item ) {
          // NEW 02-21-2016
          // @author Robert Roth
          // @desc Multicategory implementation for counting items in badge
          angular.forEach( item.category_ids, function( category_id ) {
            if( category_id == category.id ) {
              category.items.push( item );
            }
          })
        })
      });
    });

    // show the list and get active category item
    $rootScope.$on('application:hidden', function() {
      $scope.hideView = false;
      setActiveOnLoad( $scope.categories );
    })

  });
  // hide category list, it's outside the category scope
  // to enable it on reload when in an application page
  $rootScope.$on('application:visible', function() {
    $scope.hideView = true;
  })

  /**
   * Since categories have a different controller,
   * this enables us to change the active category
   * @param {array} categories Akeeba Categories
   */
  function setActiveOnLoad( categories ) {
    angular.forEach( categories, function( category ) {
      category.active = false;
      if( category.id == $location.path().split("/")[1] ) {
        $scope.currentCategory = category;
        $scope.currentCategory.active = true;
      }
    })
  }
}