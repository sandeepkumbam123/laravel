jQuery(document).ready(function($){
  $('[data-toggle="tooltip"]').tooltip({
    container: 'body'
  });
	$(document).on("mouseover", "[data-toggle='tooltip']", function(e){
		$("this").tooltip('show');
	});
  var equalHeights = function(parent, child) {
    child = (typeof child == "undefined") ? ".equal-heights" : child;
    var container = (typeof parent != "undefined") ? parent : '.equal-heights-container';
    $(container).each(function(){
      if($(this).is(":visible") && $(this).find(child).is(":visible")) {
        $(this).find(child).css('height', 'auto');
        $(this).find(child).equalHeights();
      }
    });
  };
  $(window).load(function(){
    if(typeof $.fn.equalHeights != 'undefined') {
      equalHeights('.equal-heights-container');
    }
  });
  $(window).resize(function(){
    if(typeof $.fn.equalHeights != 'undefined') {
      if(!$('.device-xs').is(":visible")) {
        equalHeights('.equal-heights-container');
      } else {
        $('.equal-heights-container').find(".equal-heights").css('height', 'auto');
      }
    }
  });
  $(document).on("click", ".toggle-question-panel", function(e){
  	$('.section-add-new-question').toggleClass('hidden');
  	$('.section-questions').toggleClass('hidden');
    equalHeights('.equal-heights-container');
  });
  $(document).on("focus", ".custom-select select", function(e){
  	$(this).closest('.custom-select').addClass('focus');
  });
  $(document).on("blur", ".custom-select select", function(e){
  	$(this).closest('.custom-select').removeClass('focus');
  });
  $(document).on("change", ".custom-file input[type='file']", function(e){
  	var file = $(this)[0].files[0];
    var container = $(this).closest('.custom-file');
    if(file && file.name) {
      container.find('.no-file').addClass('hidden');
      container.find('.selected-file').addClass('show');
      container.find('.selected-file p').html(file.name);
    } else {
      container.find('.no-file').removeClass('hidden');
      container.find('.selected-file').removeClass('show');
      container.find('.selected-file p').html('');
    }
  });
  
  $(document).on("change", ".custom-file-upload input[type='file']", function(e){
  	var file = $(this)[0].files[0];
    var container = $(this).closest('.custom-file-upload');
    if(file && file.name) {
      container.find('div').html(file.name);
    } else {
      container.find('div').html('Select File');
    }
  });
  $(document).on("click", ".menu-toggle", function(e){
  	$("#primary-nav").toggleClass("show")
  });
  $(document).on("click", ".menu-close", function(e){
  	$("#primary-nav").removeClass("show")
  });
  $(document).on("focus", ".search-questions input[name='search']", function(e){
  	$(".search-questions").addClass("show");
  });
  $(document).on("click", "body", function(e){
  	if(!$(e.target).closest('.search-questions').length) {
      $(".search-questions").removeClass("show");
    }
  });
  $(document).on("click", ".add-more-question", function(e){
  	var clonedHtml = $(".clone-questionnaire").html();
    $(".add-cloned-questions").append(clonedHtml);
  });
  $(document).on("click", ".remove-cloned", function(e){
  	$(this).closest('.cloned-wrapper').remove();
  });
  
  if($('.custom_select2').length && typeof $.fn.select2 != 'undefined') {
    $('.custom_select2').select2();
  }
  
  if($('.datePicker').length && typeof $.fn.datepicker != 'undefined') {
    $('.datePicker').datepicker({
      autoclose: true
    });
  }
  
  $(document).on("click", ".add-more-clone", function(e){
    var cloneElement = $(this).data('element');
    var cloneContainer = $(this).data('container');
  	var clonedHtml = $(cloneElement).clone().removeAttr('id').val('');
    if(clonedHtml.hasClass('clone-list')) {
      clonedHtml = clonedHtml.html();
    }
    var count = $(cloneContainer).find('.clone-block').length;
    $(cloneContainer).append('<div class="clone-block clone-block-'+count+'"><button type="button" class="btn-orange btn-mini remove-global-cloned nb-icon-cross">Remove</button></div>');
    $(cloneContainer+' .clone-block-'+count).append(clonedHtml);
  });
  
  $(document).on("click", ".remove-global-cloned", function(e){
  	$(this).closest('.clone-block').remove();
  });
  
  $(document).on("click", ".save-locationData", function(e){
  	var collegeName = $("#m_college_name").val();
  	var locationName = $("#m_location_name").val();
  	var locationHead = $("#location_head").val();
    $('.college_branches_list').append('<tr><td>'+collegeName+'</td><td>'+locationName+'</td><td>'+locationHead+'</td><td><a href="#" class="nb-icon-delete">Delete</a></td></tr>');
    $("#location-modal").modal('hide');
    $("#m_college_name").val('');
    $("#m_location_name").val('');
    $("#location_head").val('');
  });
  
});