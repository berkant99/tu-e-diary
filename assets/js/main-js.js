$(document).ready(function () {
    $('.field span').text("Моля попълнте това поле!");

    $('input').focus(function () {
        $(this).parents('.field').addClass('focused');
    });

    /* blur event occurs when an element loses focus */
    $('input').blur(function () {
        if ($(this).val() == "") {
            $(this).parents('.field').removeClass('focused');
            $(this).parents('.field').addClass('error');
        } else {
            $(this).parents('.field').removeClass('error');
            $(this).parents('.field').addClass('focused');
        }
    });

    /* close alerts */
    $('#hide-alert').click(function () {
        $('.alert').fadeOut("slow");
    });

    /* hide success message onload */
    setTimeout(function () { $('.alert-success').fadeOut(1000) }, 5000);

    /* show or hide password */
    function hideOrShowPass(passId, iconId) {
        $(iconId).click(function () {
            $(iconId).toggleClass('fa-eye fa-eye-slash');
            var passInput = $(passId);
            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
            } else {
                passInput.attr('type', 'password');
            }
        });
    }

    hideOrShowPass('#newPass-reset', '#show-hide-pass-reset');
    hideOrShowPass('#newPass', '#show-hide-pass-new');

    //menu
    $('nav label').click(function () {
        if ($('body').css('overflow-y') == 'auto') {
            $('body').css('overflow-y', 'hidden');
        } else {
            $('body').css('overflow-y', 'auto');
        }
        $('.nav-menu').toggleClass('active');
        $('.main').toggleClass('blur-main');
        $('.user-info').toggleClass('hide');
        $('.fa-bell-o').toggleClass('hide');
        $('.unread-msg').toggleClass('hide');
        if ($('.dropdown-msg-menu').css('display') == 'block') {
            $('.dropdown-msg-menu').slideUp('fast');
        }
    });

    $('nav .fa-bell-o').click(function () {
        if ($('.dropdown-msg-menu').css('display') == 'none') {
            $('.dropdown-msg-menu').slideDown('slow');
        } else {
            $('.dropdown-msg-menu').slideUp('slow');
        }
    });

    $(window).scroll(function () {
        if (window.scrollY > 10 && $('.dropdown-msg-menu').css('display') == 'block') {
            $('.dropdown-msg-menu').slideUp('slow');
        }
    });
    //end menu

    // formCheckInputs('#student-login-form');
    // formCheckInputs('#email-verification-form');
    // formCheckInputs('#first-signin-form');
    // formCheckInputs('#forgotten-pass-form');
    // formCheckInputs('#reset-password-form');

    // function isEmail(email) {
    //     return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
    // }

    // function checkEmail(emailId, errorId) {
    //     if (!isEmail($('#' + emailId).val())) {
    //         if ($('#' + emailId).val() != '') {
    //             changeSpanErrorText(emailId, errorId, 'Въведете валиден имейл адрес!');
    //         }
    //         return false;
    //     }
    //     else {
    //         return true;
    //     }
    // }

    

    // function changeSpanErrorText(inputId, spanId, text) {
    //     setError(inputId);
    //     $('#' + spanId).text(text);
    // }

    // $('#first-signin-form').submit(function (e) {
    //     checkPasswords(e, 'newPass', 'repeatPass');
    //     if (!checkEmail('email', 'emailError')) {
    //         e.preventDefault();
    //     }
    // });

    // $('#reset-password-form').submit(function (e) {
    //     checkPasswords(e, 'newPass-reset', 'repeatPass-reset');
    // });

    //Password check
    var hasNumber = /\d/;
    var hasUpperCase = /[A-Z]/;
    var hasLowerCase = /[a-z]/;
    var hasSymbols = /[!@#$%&*^]/;

    function addClassToChild(childNumber) {
        $("ul li:nth-child(" + childNumber + ")").addClass('success');
        $("ul li:nth-child(" + childNumber + ") i").addClass('show');
    }

    function removeClassFromChild(childNumber) {
        $("ul li:nth-child(" + childNumber + ")").removeClass('success');
        $("ul li:nth-child(" + childNumber + ") i").removeClass('show');
    }

    function passAnimation(passId, formId) {
        $(passId).focus(function () {
            $('html, body').animate({
                scrollTop: parseInt($(formId).offset().top - 200)
            }, 1000);
            $('#passList').slideDown('slow');
        });

        $(passId).blur(function () {
            $('#passList').slideUp('slow');
        });

        $(passId).on("keyup", function () {
            var password = $(passId).val();
            if (hasUpperCase.test(password)) {
                addClassToChild(1);
            } else {
                removeClassFromChild(1);
            }

            if (hasLowerCase.test(password)) {
                addClassToChild(2);
            } else {
                removeClassFromChild(2);
            }

            if (hasNumber.test(password)) {
                addClassToChild(3);
            } else {
                removeClassFromChild(3);
            }

            if (hasSymbols.test(password)) {
                addClassToChild(4);
            } else {
                removeClassFromChild(4);
            }

            if (password.length >= 8) {
                addClassToChild(5);
            } else {
                removeClassFromChild(5);
            }
        });
    }

    passAnimation('#newPass', '#first-signin-form');
    passAnimation('#newPass-reset', '#reset-password-form');

    // $('#forgotten-pass-form').submit(function (e) {
    //     if (!checkEmail('email', 'emailError')) {
    //         e.preventDefault();
    //     }
    // });
});