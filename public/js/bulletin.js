$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  //いいねボタンを押す
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
      //ajaxが成功した場合
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
      //ajaxが失敗した場合
    }).fail(function (res) {
      console.log('fail');
    });
  });

  //いいねボタンを解除
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  //編集モーダル
  $('.edit-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title'); //属性のpost_titleを取得
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title); //属性のpost_titleの値をclass="modal-inner-title input"で表示
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});

//投稿ページのカテゴリー検索スライド
$(function () {
  $('.category_conditions').click(function () {
    $(this).find('.category_conditions_inner').slideToggle();
  });
});

//掲示板のスライドの矢印
$(function () {
  $('.arrow-icon').click(function () {
    // クリックされた矢印要素が down クラスを持っているかどうかを確認
    var isDown = $(this).hasClass('down');

    // すべての矢印要素から down クラスを削除
    $('.arrow-icon').removeClass('down');

    // クリックされた矢印要素に down クラスを追加（もしくは削除）
    if (!isDown) {
      $(this).addClass('down');
    }
  });
});
