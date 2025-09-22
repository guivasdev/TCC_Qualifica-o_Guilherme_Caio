$(document).ready(function () {

  let isOpen = false;

  $('.menu-icon').click(function () {
    $('#sidebar').toggleClass('open');
    if (isOpen == false) {
      isOpen = true;
      $('.menu-icon').animate({ 'left': '0px', 'margin-left': -$('.menu-icon').width() + 240 },400);


    } else {
      isOpen = false;
      $('.menu-icon').animate({ 'left': '0px', 'margin-left': -$('.menu-icon').width() +21.5 });

    }







  });
});
