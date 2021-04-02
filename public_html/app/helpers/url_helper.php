<?php
// ------------------------------ REDIRECT USER -------------------------------------------
function redirect($page)
  {
      header('location:'.URLROOT.'/'.$page);
      die();
  }


  


