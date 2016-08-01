<script>
  // window.__internal = {
  //   userId: '<?php echo dechex( $user->id + 618 );?>',
  //   isGuest: function() {
  //     return <?php echo $user->guest;?> == 0;
  //   },
  //   getUserId: function() {
  //     return '<?php echo dechex( $user->id + 618 );?>'
  //   },
  //   getToken: function() {
  //     return '<?php echo JHtml::_('form.token'); ?>';
  //   }
  // }
  
  'use strict';

  angular.module('JoomlaAppValues', [])

  .value('JoomlaApp', {
    userId: '<?php echo dechex( $user->id + 618 );?>',
    isGuest: (<?php echo $user->guest;?> == 0),
    token: '<?php echo JHtml::_('form.token'); ?>'.split('"')[3]
  })
</script>