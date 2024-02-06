$(function () {
  $('#open-modal').on('click', function () { //キャンセルボタンを押すとモーダルの内容が表示される
    $('.modal').fadeIn();
  });
  $('.js-modal-close').on('click', function () { //閉じるボタンを押すとモーダルを閉じる
    $('.modal').fadeOut();
  });

});
