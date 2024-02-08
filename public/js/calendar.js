$(function () {
  $('.open-modal').on('click', function () { //キャンセルボタンを押すとモーダルの内容が表示される
    $('.modal').fadeIn();
    var delete_date = $('.open-modal').attr('name'); //変数delete_date=class=open-modalの
    $('.modal_delete_date').val(delete_date);
  });
  $('.js-modal-close').on('click', function () { //閉じるボタンを押すとモーダルを閉じる
    $('.modal').fadeOut();
  });

});
