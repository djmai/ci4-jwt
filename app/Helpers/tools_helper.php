<?php

if(!function_exists('hashPass')){
  function hashPass($password){
    return password_hash($password, PASSWORD_DEFAULT);
  }
}

if(!function_exists('veriPass')){
  function veriPass($passPost, $passDB){
    return password_verify($passPost, $passDB);
  }
}