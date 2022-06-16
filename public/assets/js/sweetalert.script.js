$(document).ready(function () {
    $('#basic-alert').on('click', function () {
        swal("Here's a message!");
    });

    $('#with-title').on('click', function () {
        swal(
            'The Internet?',
            'That thing is still around?'
        );
    });

    $('#with-html').on('click', function () {
        swal({
            title: 'HTML <small>Title</small>!',
            text: 'A custom <span style="color:#F6BB42">html<span> message.',
            html: true,
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-primary'
        });
    });

    $('#alert-success').on('click', function () {
        swal({
            type: 'success',
            title: 'Success!',
            text: 'Your work has been saved',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-success'
        })
    });

    $('#alert-info').on('click', function () {
        swal({
            type: 'info',
            title: 'Info Alert!',
            text: 'Here is the info alert text',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-info'
        })
    });

    $('#alert-warning').on('click', function () {
        swal({
            type: 'warning',
            title: 'Warning',
            text: 'Here is the warning alert text',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-warning'
        })
    });

    $('#alert-error').on('click', function () {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Something went wrong!',
            confirmButtonText: 'Dismiss',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-danger'
        })
    });

    $('#with-image').on('click', function () {
        swal({
            title: 'Sweet!',
            text: 'Modal with a custom image.',
            imageUrl: 'https://unsplash.it/400/200',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg btn-primary'
        })
    });

    $('#with-timer').on('click', function () {
        let timerInterval;
        swal({
            title: 'Auto close alert!',
            html: 'I will close in <strong>2</strong> seconds.',
            timer: 2000
        }).then((result) => {
            if (
                result.dismiss === swal.DismissReason.timer
            ) {
                console.log('I was closed by the timer')
            }
        })
    });

    $('#with-input').on('click', function () {
        swal({
            title: "An input!",
            text: "Write something:",
            input: "text",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Write something"
        }).then(function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                return false
            }
            swal("Awesome!", "You wrote: " + inputValue, "success");
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.alert-confirm-destroy').on('click', function () {
        let url = $(this).data('url');
        let id = $(this).data('id');
        let title = $(this).data('title');
        let text = $(this).data('text');
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0CC27E',
            cancelButtonColor: '#FF586B',
            confirmButtonText: 'Приступить',
            cancelButtonText: 'Отменить',
            confirmButtonClass: 'btn btn-success mr-5',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        }).then(function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    id: id,
                },
                success: function (response) {
                    swal({
                        title: 'Удалено!',
                        text: 'данных не существует.',
                        type: 'success',
                        onClose: function () {
                            window.location.href = response;
                        }
                    });
                },
                error: function() {
                    swal(
                        'Ошибка',
                        'Вы сохранили данные :)',
                        'error'
                    );
                }
            });
        }, function (dismiss) {
            // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
            if (dismiss === 'cancel') {
                swal(
                    'Отмена',
                    'Вы решили не удалять :)',
                    'error'
                );
            }
        })
    });

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };

});