// btn add playlist
document.querySelectorAll('.btn_menu').forEach(button => {
    button.addEventListener('click', function (event) {
        event.stopPropagation();
        document.querySelectorAll('.add-playlist').forEach(box => {
            if (box !== this.nextElementSibling) {
                box.style.display = 'none';
            }
        });

        const addPlaylist = this.nextElementSibling;
        if (addPlaylist.style.display === 'block') {
            addPlaylist.style.display = 'none';
        } else {
            addPlaylist.style.display = 'block';
        }
    });
});

// Đóng hộp khi nhấp ra ngoài nó
document.addEventListener('click', function (event) {
    if (!event.target.closest('.btn_menu') && !event.target.closest('.add-playlist')) {
        document.querySelectorAll('.add-playlist').forEach(box => {
            box.style.display = 'none';
        });
    }
});
// thêm vào playlist
$(document).on('click', '.add-to-playlist', function () {
    var playlist_id = $(this).data('id');
    var song_id = $(this).closest('.recommend-song').data('id');

    $.ajax({
        url: 'add_to_playlist.php',
        type: 'POST',
        data: {
            playlist_id: playlist_id,
            song_id: song_id
        },
        success: function (response) {
            if (response.trim() === 'exists') {
                alert('Bài hát đã tồn tại trong playlist!');
            } else if (response.trim() === 'success') {
                alert('Bài hát đã được thêm vào playlist thành công!');
            }
        },
        error: function (xhr, status, error) {
            alert('Đã có lỗi xảy ra: ' + error);
        }
    });
});

// thêm vào yêu thích
$(document).on('click', '.btn-heart', function () {
    var song_id = $(this).closest('.recommend-song').data('id') || $(this).closest('.player-control').data('id');
    var heartIcon = $(this).find('i');
    $.ajax({
        url: 'toggle_favorite.php',
        type: 'POST',
        data: {
            song_id: song_id
        },
        success: function (response) {
            if (response.trim() === 'added') {
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                alert('Bài hát đã được thêm vào danh sách yêu thích!');
            } else if (response.trim() === 'removed') {
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                alert('Bài hát đã được xóa khỏi danh sách yêu thích!');
            } else {
                alert('Có lỗi xảy ra: ' + response);
            }
        },
        error: function (xhr, status, error) {
            alert('Đã có lỗi xảy ra: ' + error);
        }
    });
});