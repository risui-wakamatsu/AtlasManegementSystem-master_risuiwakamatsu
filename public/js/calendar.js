$(function () {
  $('.open-modal').on('click', function () { //キャンセルボタンを押すとモーダルの内容が表示される
    $('.modal').fadeIn();
    var delete_date = $(this).attr('delete_date'); //CalendarViewのキャンセルボタンを記述しているところの属性から受け取る
    var delete_part = $(this).attr('delete_part');//CalendarViewのキャンセルボタンを記述しているところの属性から受け取る
    $('.modal_delete_date p').text("予約日：" + delete_date); //受け取った値をbladeのmodal_delete_dateクラス内のpタグに反映させるようにする
    $('.modal_delete_part p').text("時間：" + delete_part); //受け取った値をbladeのmodal_delete_partクラス内のpタグに反映させるようにする
    return false;
  });
  $('.js-modal-close').on('click', function () { //閉じるボタンを押すとモーダルを閉じる
    $('.modal').fadeOut();
  });

});
