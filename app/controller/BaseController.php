<?php
   class BaseController
   {
      public function __construct()
      {

      }

      public function loadView($main, $data = null)
      {
         include('view/partials/header.php');
         include($main);
         include('view/partials/footer.php');
      }
   }
