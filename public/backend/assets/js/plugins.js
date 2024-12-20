/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Version: 2.2.0
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Common Plugins Js File
*/

//Common plugins
if(document.querySelectorAll("[toast-list]") || document.querySelectorAll('[data-choices]') || document.querySelectorAll("[data-provider]")){
  document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>");
  document.writeln("<script type='text/javascript' src='assets/libs/choices.js/@extends('layouts.master')'></script>");
  document.writeln("<script type='text/javascript' src='assets/libs/flatpickr/flatpickr.min.js'></script>");
}
