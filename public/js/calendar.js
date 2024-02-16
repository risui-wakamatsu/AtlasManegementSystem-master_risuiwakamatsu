$(function () {
  $('.open-modal').on('click', function () { //キャンセルボタンを押すとモーダルの内容が表示される
    $('.modal').fadeIn();
    var delete_date = $(this).attr('delete_date'); //CalendarViewのキャンセルボタンを記述しているところの属性から受け取る
    var delete_part = $(this).attr('delete_part');//CalendarViewのキャンセルボタンを記述しているところの属性から受け取る
    var cancel_id = $(this).attr('cancel_id'); //CalendarViewのキャンセルボタンに記述した属性からidの取得
    $('.modal_delete_date p').text("予約日：" + delete_date); //受け取った値をbladeのmodal_delete_dateクラス内のpタグに反映させるようにする
    $('.modal_delete_part p').text("時間：" + delete_part); //受け取った値をbladeのmodal_delete_partクラス内のpタグに反映させるようにする
    $('.cancel_id_hidden').val(cancel_id); //上記で受け取ったcancel_idをbladeのcancel_id_hiddenへ受け渡しcontrollerへ送信
    //ここに記述する
    return false;
  });

  //キャンセルボタンが押された時の記述をする
  //$('.cancel_btn').on('click', function () {
  //var cancel_date = $(this).attr('cancel_date'); //キャンセルボタンを送信したときに属性の内容を受け取り、cancel_date変数に代入する
  //var cancel_part = $(this).attr('cancel_part');
  //$('.cancel_date_hidden').val(cancel_date); //上記の受け取った属性のデータをbladeのinputへ、今回はhiddenで隠しフィールドとする
  //$('.cancel_part_hidden').val(cancel_part);
  //return false;
  //});

  $('.js-modal-close').on('click', function () { //閉じるボタンを押すとモーダルを閉じる
    $('.modal').fadeOut();
    return false;
  });

});
