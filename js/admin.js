/**
 * File admin-template-options.js.
 *
 * Handle template options show/hide.
 *
 * Author: Diego Versiani
 * Contact: http://diegoversiani.me
 */

(function(){
  
  'use strict';

  // Initialize EventListeners
  window.addEventListener("DOMContentLoaded", init);


  var dropdown,
      templateOptions;


  function init() {
    dropdown = document.querySelector('.content-block-templates');
    templateOptions = document.querySelectorAll('.content-block-template-options');

    dropdown.addEventListener( 'change', changeTemplate );

    showTemplateOptions( dropdown.value );
  };





  function changeTemplate( e ) {
    showTemplateOptions( e.target.value );
  };





  function showTemplateOptions( template ) {
    var options_container = document.querySelector( '.' + template + '-options' );

    hideAllTemplateOptions();

    if (options_container) {
      options_container.classList.add( 'content-block-template-options--open' );
    }
  };





  function hideAllTemplateOptions() {
    for (var i = 0; i < templateOptions.length; i++) {
      templateOptions[i].classList.remove( 'content-block-template-options--open' );
    }
  }



})();
